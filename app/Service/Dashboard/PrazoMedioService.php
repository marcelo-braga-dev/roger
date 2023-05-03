<?php

namespace App\Service\Dashboard;

use App\Models\Produtos;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PrazoMedioService
{
    private function filtroPeriodo($query, $ano, $mes)
    {
        $ano ? $query->whereYear('data_cadastro', $ano) : null;
        $mes ? $query->whereMonth('data_cadastro', $mes) : null;
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

        $query = (new Produtos())->newQuery()
            ->select(
                'cliente',
                'vendedor',
                'gerente_regional',
                DB::raw('AVG(prazo_medio) as prazo, SUM(valor_total) as valor')
            )
            ->groupBy('gerente_regional');
        $this->filtroPeriodo($query, $ano, $mes);
        $this->filtroUsuario($query, $vendedor, $cliente, $gerenteAtual);
        $clientes = $query->orderByDesc('valor')
            ->limit(5)
            ->get()
            ->transform(function ($dados) use ($nomes) {
                return [
                    'cliente' => $dados->cliente,
                    'valor' => $dados->valor,
                    'prazo' => round($dados->prazo),
                    'gerente' => $nomes[$dados->gerente_regional]['nome'],
                    'vendedor' => $nomes[$dados->vendedor]['nome'],
                ];
            });

        $mediaQuery = (new Produtos())->newQuery()
            ->select(DB::raw('
            AVG(prazo_medio) as media_total'));

        $this->filtroPeriodo($mediaQuery, $ano, $mes);
        $this->filtroUsuario($mediaQuery, $vendedor, $cliente, $gerenteAtual);
        $media = $mediaQuery->first();

        return [
            'tabela' => $clientes,
            'media' => $media['media_total'] ?? 0
        ];
    }
}
