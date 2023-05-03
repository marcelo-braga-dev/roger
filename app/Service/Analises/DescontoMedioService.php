<?php

namespace App\Service\Analises;

use App\Models\Produtos;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DescontoMedioService
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

        // Clientes
        $query = (new Produtos())->newQuery()
            ->select(
                'cliente',
                'vendedor',
                DB::raw('AVG(desconto) as desconto,
                    SUM(valor_total) as valor_total,
                    SUM(valor_sugerido) as valor_sugerido,
                    AVG(desconto/valor_sugerido) as media')
            )
            ->groupBy('cliente');

        $this->filtroPeriodo($query, $ano, $mes, $grupos);
        $this->filtroUsuario($query, $vendedor, $cliente, $gerenteAtual);

        $clientes = $query->get()
            ->transform(function ($dados) use ($nomes) {
                return [
                    'vendedor' => $nomes[$dados->vendedor]['nome'],
                    'cliente' => $dados->cliente,
                    'valor_sugerido' => $dados->valor_sugerido,
                    'valor_desconto' => $dados->desconto,
                    'valor_total' => 0,
                ];
            });

        // Media
        $query = (new Produtos())->newQuery()
            ->select(DB::raw(
                '(SUM(valor_sugerido) - SUM(valor_total)) / SUM(valor_sugerido) * 100 as media'
            ));

        $this->filtroPeriodo($query, $ano, $mes, $grupos);
        $this->filtroUsuario($query, $vendedor, $cliente, $gerenteAtual);

        $media = $query->first();

        return [
            'tabela' => $clientes,
            'media' => $media['media'],
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
