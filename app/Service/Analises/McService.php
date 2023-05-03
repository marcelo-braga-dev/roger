<?php

namespace App\Service\Analises;

use App\Models\Produtos;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class McService
{
    private function filtroPeriodo($query, $ano, $mes, $grupos)
    {
        $ano ? $query->whereYear('data_cadastro', $ano) : null;
        $mes ? $query->whereMonth('data_cadastro', $mes) : null;
        $grupos ? $query->where('cod_grupo', $grupos) : null;
    }

    public function filtroUsuario($query, $vendedor, $cliente, $gerente)
    {
        if ($cliente) return $query->where('cliente', $cliente);
        if ($vendedor) return $query->where('vendedor', $vendedor);
        if ($gerente) return $query->where('gerente_regional', $gerente);
    }

    public function calcular($request, $gerente = null)
    {
        $nomes = (new User())->getNomes();
        $gerenteAtual = $gerente ?? $request->gerente;
        $vendedor = $request->vendedor;
        $cliente = $request->cliente;
        $mes = $request->mes;
        $ano = $request->ano;
        $grupos = $request->grupos;

        $query = (new Produtos())->newQuery()
            ->select(
                'grupo', 'cod_grupo',
                'cliente',
                'vendedor',
                'gerente_regional',
                DB::raw('
                AVG(prazo_medio) as prazo,
                SUM(valor_total) as valor,
                (SUM(valor_total) - SUM(custo) - SUM(comissao) - SUM(frete)) as mc')
            )
            ->groupBy('cod_grupo');

        $this->filtroPeriodo($query, $ano, $mes, $grupos);
        $this->filtroUsuario($query, $vendedor, $cliente, $gerenteAtual);
        $clientes = $query->get()
            ->transform(function ($dados) use ($nomes) {
                return [
                    'cod' => $dados->cod_grupo,
                    'cliente' => $dados->cliente,
                    'vendedor' => $nomes[$dados->vendedor]['nome'],
                    'grupo' => $dados->grupo,
                    'valor' => $dados->valor,
                    'mc' => $dados->mc,
                    'mc_taxa' => ''
                ];
            });

        $mediaQuery = (new Produtos())->newQuery()
            ->select(DB::raw('
            AVG(prazo_medio) as media_total, SUM(valor_total) as valor_total,
            SUM(valor_total)-(SUM(custo)+SUM(imposto)+SUM(comissao)+SUM(frete)) as media_valor_total'));

        $this->filtroPeriodo($mediaQuery, $ano, $mes, $grupos);
        $this->filtroUsuario($mediaQuery, $vendedor, $cliente, $gerenteAtual);
        $media = $mediaQuery->first();

        return [
            'tabela' => $clientes,
            'media' => $media['media_valor_total'] / ($media['valor_total'] ?? 1) * 100,
            'media_valor' => $media['media_valor_total'] ?? 0,
            'grupos' => $this->grupos($mes, $ano, $grupos)
        ];
    }

    public function grupos($mes = null, $ano = null, $grupos = null, $gerenteAtual = null)
    {
        $query = (new Produtos())->newQuery();

        $this->filtroPeriodo($query, $ano, $mes, $grupos);

        return $query->groupBy('grupo')
            ->orderBy('grupo')
            ->get(['grupo', 'cod_grupo']);
    }
}
