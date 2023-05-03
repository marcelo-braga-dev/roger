<?php

namespace App\Service\Dashboard;

use App\Models\Produtos;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DescontoMedioService
{
    private function filtroPeriodo($query, $ano, $mes)
    {
        $ano ? $query->whereYear('data_cadastro', $ano) : null;
        $mes ? $query->whereMonth('data_cadastro', $mes) : null;
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

        $query = (new Produtos())->newQuery()
            ->select(
                'gerente_regional', 'desconto', 'valor_sugerido',
                DB::raw('AVG(desconto) / AVG(valor_sugerido) as media,
                    AVG(desconto/valor_sugerido) as media_')
            )
            ->orderByDesc('media')
            ->limit(5)
            ->groupBy('gerente_regional');

        $this->filtroPeriodo($query, $ano, $mes);
        $this->filtroUsuario($query, $vendedor, $cliente, $gerenteAtual);

        $clientes = $query->get()
            ->transform(function ($dados) use ($nomes) {
                return [
                    'gerente' => $nomes[$dados->gerente_regional]['nome'],
                    'media' => $dados->media,
                ];
            });

        return [
            'tabela' => $clientes,
        ];
    }
}
