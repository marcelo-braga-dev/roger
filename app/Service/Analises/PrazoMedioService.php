<?php

namespace App\Service\Analises;

use App\Models\Produtos;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PrazoMedioService
{
    private function filtroPeriodo($query, $ano, $mes, $grupos)
    {
        $ano ? $query->whereYear('data_cadastro', $ano) : null;
        $mes ? $query->whereMonth('data_cadastro', $mes) : null;
        $grupos ? $query->where('cod_grupo', $grupos) : null;
    }

    private function filtroUsuario($query, $vendedor, $cliente, $gerente)
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
                'cliente',
                'vendedor',
                'gerente_regional',
                DB::raw('AVG(prazo_medio) as prazo, SUM(valor_total) as valor')
            )
            ->groupBy('cliente');
        $this->filtroPeriodo($query, $ano, $mes, $grupos);
        $this->filtroUsuario($query, $vendedor, $cliente, $gerenteAtual);
        $clientes = $query->orderByDesc('valor')
            ->get()

            ->transform(function ($dados) use ($nomes) {
                return [
                    'cliente' => $dados->cliente,
                    'valor' => $dados->valor,
                    'prazo' => $dados->prazo,
                    'gerente' => $nomes[$dados->gerente_regional]['nome'],
                    'vendedor' => $nomes[$dados->vendedor]['nome'],
                ];
            });

        $mediaQuery = (new Produtos())->newQuery()
            ->select(DB::raw('
            AVG(prazo_medio) as media_total'));

        $this->filtroPeriodo($mediaQuery, $ano, $mes, $grupos);
        $this->filtroUsuario($mediaQuery, $vendedor, $cliente, $gerenteAtual);
        $media = $mediaQuery->first();

        return [
            'tabela' => $clientes,
            'media' => $media['media_total'] ?? 0,
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
