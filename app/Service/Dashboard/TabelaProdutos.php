<?php

namespace App\Service\Dashboard;

use App\Models\Produtos;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TabelaProdutos
{
    public function calcular($request, $gerente = null)
    {
        $gerenteAtual = $gerente ?? $request->gerente;
        $vendedor = $request->vendedor;
        $grupo = $request->grupo;
        $mes = $request->mes;
        $ano = $request->ano;

        $query = (new Produtos())->newQuery()
            ->select(
                'produto',
                DB::raw('AVG(prazo_medio) as prazo, SUM(valor_total) as valor')
            )
            ->groupBy('cod_produto');

        $this->filtroPeriodo($query, $ano, $mes);
        $this->filtroUsuario($query, $vendedor, $grupo, $gerenteAtual);

        $clientes = $query->orderByDesc('valor')
            ->limit(5)
            ->get()
            ->transform(function ($dados) {
                return [
                    'produto' => $dados->produto,
                    'valor' => $dados->valor,
                    'prazo' => $dados->prazo,
                ];
            });

        $query = (new Produtos())->newQuery();
        $this->filtroPeriodo($query, $ano, $mes);
        $valores = $query->select(DB::raw('SUM(valor_total) as total_geral'))
            ->first();

        $total = 0;
        foreach ($clientes as $cliente) {
            $total += $cliente['valor'];
        }

        return [
            'tabela' => $clientes,
            'total' => $total,
            'total_geral' => $valores['total_geral']
        ];
    }

    private function filtroPeriodo($query, $ano, $mes)
    {
        $ano ? $query->whereYear('data_cadastro', $ano) : null;
        $mes ? $query->whereMonth('data_cadastro', $mes) : null;
    }

    private function filtroUsuario($query, $vendedor, $grupo, $gerente)
    {
        if ($grupo) return $query->where('cod_grupo', $grupo);
        if ($vendedor) return $query->where('vendedor', $vendedor);
        if ($gerente) return $query->where('gerente_regional', $gerente);
    }
}
