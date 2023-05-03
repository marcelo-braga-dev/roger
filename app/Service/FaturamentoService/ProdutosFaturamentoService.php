<?php

namespace App\Service\FaturamentoService;

use App\Models\Produtos;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProdutosFaturamentoService
{
    private array $nomes;

    public function __construct()
    {
        $this->nomes = (new User())->getNomesVendedor();
    }

    public function execute($dados, $ano = null, $gerenteAtual = null)
    {
        $query = (new Produtos())->newQuery();

        $this->filtro($query, $gerenteAtual, $dados, $ano);

        return ($query->select(
            'cod_grupo', 'grupo',
            DB::raw('SUM(valor_total) as valor_total, SUM(litros) as litros')
        )
            ->groupBy('cod_grupo')
            ->orderBy('grupo')
            ->get()
            ->transform(function ($item) {
                return [
                    'vendas' => $item->valor_total,
                    'litros' => $item->litros,
                    'cod' => $item->cod_grupo,
                    'grupo' => $item->grupo,
                ];
            }));
    }

    private function filtro($query, $gerenteAtual, $dados, $ano): void
    {
        $gerente = $gerenteAtual ?? $dados->gerente;

        if ($ano) $query->whereYear('data_cadastro', $ano);
        if ($dados->mes) $query->whereMonth('data_cadastro', $dados->mes);

        $where = [];
        if ($gerente) $where[] = ['gerente_regional', $gerente];
        if ($dados->vendedor) $where[] = ['vendedor', $dados->vendedor];
        if ($dados->cliente) $where[] = ['cliente', $dados->cliente];
        if ($dados->grupos) $where[] = ['cod_grupo', $dados->grupos];
        count($where) ? $query->where($where) : '';
    }

    public function tabela($dados, $comparar, $analisar, $anoComparar = null, $anoAnalisar = null, $gerenteAtual = null)
    {
        $query = (new Produtos())->newQuery();

        $this->filtro($query, $gerenteAtual, $dados, null);

        if ($anoComparar) $query->whereYear('data_cadastro', $anoComparar);
        if ($anoAnalisar) $query->orWhereYear('data_cadastro', $anoAnalisar);

        $grupos = $query->groupBy('grupo')
            ->orderBy('grupo')
            ->get(['grupo', 'cod_grupo']);

        $totalVendasComparar = 0;
        $totalLitrosComparar = 0;
        $totalVendasAnalizar = 0;
        $totalLitrosAnalizar = 0;

        $dadosComparar = [];
        foreach ($comparar as $item) {
            $totalVendasComparar += $item['vendas'];
            $totalLitrosComparar += $item['litros'];
            $dadosComparar[$item['cod']] = $item;
        }

        $dadosAnalisar = [];
        foreach ($analisar as $item) {
            $totalVendasAnalizar += $item['vendas'];
            $totalLitrosAnalizar += $item['litros'];
            $dadosAnalisar[$item['cod']] = $item;
        }

        $dados = [];
        foreach ($grupos as $item) {
            $dados[] = [
                'nome' => $dadosComparar[$item['cod_grupo']]['grupo'] ?? null,
                'analisar' => $dadosComparar[$item['cod_grupo']] ?? null,
                'comparar' => $dadosAnalisar[$item['cod_grupo']] ?? null,
            ];
        }
        return [
            'tabela' => $dados,
            'totais' =>  $this->totais($totalLitrosComparar, $totalVendasComparar, $totalLitrosAnalizar, $totalVendasAnalizar)
        ];
    }

    public function totais($totalLitrosComparar, $totalVendasComparar, $totalLitrosAnalizar, $totalVendasAnalizar): array
    {
        $razaoComparar = $totalLitrosComparar ? $totalVendasComparar / $totalLitrosComparar : 0;
        $razaoAnalisar = $totalLitrosAnalizar ? $totalVendasAnalizar / $totalLitrosAnalizar : 0;

        return [
            'comparar' => [
                'vendas' => $totalVendasComparar,
                'litros' => $totalLitrosComparar,
                'ticket' => $razaoComparar
            ],
            'analisar' => [
                'vendas' => $totalVendasAnalizar,
                'litros' => $totalLitrosAnalizar,
                'ticket' => $razaoAnalisar
            ],
            'taxa' => [
                'vendas' => $totalVendasComparar ? round((($totalVendasAnalizar - $totalVendasComparar) / $totalVendasComparar), 4) : 0,
                'litros' => $totalLitrosComparar ? round((($totalLitrosAnalizar - $totalLitrosComparar) / $totalLitrosComparar), 4) : 0,
                'ticket' => $razaoComparar ? round(((($razaoAnalisar) - ($razaoComparar)) / ($razaoComparar)), 4) : 0
            ]
        ];
    }

    public function grupos($dados, $comparar = null, $analisar = null, $gerenteAtual = null)
    {
        $query = (new Produtos())->newQuery();

        $this->filtro($query, $gerenteAtual, $dados, null);

        if ($comparar) $query->whereYear('data_cadastro', $comparar);
        if ($analisar) $query->orWhereYear('data_cadastro', $analisar);

        return $query->groupBy('grupo')
            ->orderBy('grupo')
            ->get(['grupo', 'cod_grupo']);
    }
}
