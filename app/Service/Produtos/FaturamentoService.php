<?php

namespace App\Service\Produtos;

use App\Models\Produtos;
use App\Models\User;

/**
 * @deprecated
 */
class FaturamentoService
{
    private array $nome;

    public function __construct()
    {
        $this->nome = (new User())->getNomes();
    }

    public function faturamentoVendedor($request, $gerenteAtual = null)
    {
        $this->getVendedores($gerenteAtual, $request);

        $dados = [];

        foreach ($this->vendedores as $item) {

            $faturamento = $this->getFaturamentos($item['id'], $request, $gerenteAtual);

            $dados = $this->getDados($item['id'], $faturamento, $dados);
        }

        return $this->dadosCompremenares($dados);
    }

    private function buscaValor($ano, $id, $campo, $request, $gerenteAtual)
    {
        $querySun = (new Produtos())->newQuery();

        $ano ? $querySun->whereYear('data_cadastro', $ano) : '';
        $gerenteAtual ? $querySun->where('gerente_regional', $gerenteAtual) : '';
        $request->mes ? $querySun->whereMonth('data_cadastro', $request->mes) : '';

        return $querySun->where('vendedor', $id)->sum($campo);
    }

    public function filtro(mixed $gerenteAtual, $request, $query): void
    {
        $gerente = $gerenteAtual ?? $request->gerente;
        $vendedor = $request->vendedor;
        $cliente = $request->cliente;
        $where = [];
        if ($gerente) $where[] = ['gerente_regional', $gerente];
        if ($vendedor) $where[] = ['vendedor', $vendedor];
        if ($cliente) $where[] = ['cliente', $cliente];
        count($where) ? $query->where($where) : '';
    }

    public function getFaturamentos($id, $request, $gerenteAtual): array
    {
        $faturamento['comparar']['faturamento'][$id] =
            $this->buscaValor($request->ano_comparar, $id, 'valor_total', $request, $gerenteAtual, 'vendedor');
        $faturamento['comparar']['litros'][$id] =
            $this->buscaValor($request->ano_comparar, $id, 'litros', $request, $gerenteAtual, 'vendedor');

        $faturamento['analisar']['faturamento'][$id] =
            $this->buscaValor($request->ano_analizar, $id, 'valor_total', $request, $gerenteAtual, 'vendedor');
        $faturamento['analisar']['litros'][$id] =
            $this->buscaValor($request->ano_analizar, $id, 'litros', $request, $gerenteAtual, 'vendedor');
        return $faturamento;
    }

    public function getDados($id, array $faturamento, array $dados): array
    {
        $dados[$id] = [
            'comparar' => [
                'faturamento' => convert_float_money($faturamento['comparar']['faturamento'][$id]),
                'faturamento_float' => $faturamento['comparar']['faturamento'][$id],
                'litros' => $faturamento['comparar']['litros'][$id]
            ],
            'analizar' => [
                'faturamento' => convert_float_money($faturamento['analisar']['faturamento'][$id]),
                'faturamento_float' => $faturamento['analisar']['faturamento'][$id],
                'litros' => $faturamento['analisar']['litros'][$id],
            ],
            'vendedor' => $this->nome[$id]['codigo'] . '-' . $this->nome[$id]['nome'],
            'id_vendedor' => $id,
        ];
        return $dados;
    }

    public function getVendedores(mixed $gerenteAtual, $request): void
    {
        $query = (new Produtos())->newQuery()->distinct();

        $this->filtro($gerenteAtual, $request, $query);

        // coleta vendedores com produtos
        $this->vendedores = $query->get('vendedor')->transform(function ($e) {
            return ['id' => $e->vendedor];
        });
    }

    public function dadosCompremenares(array $dados): array
    {
        $res['tabela'] = [];
        $totalFaturamentoComparar = 0;
        $totalLitrosComparar = 0;
        $totalFaturamentoAnalizar = 0;
        $totalLitrosAnalizar = 0;
        foreach ($dados as $item) {
            $res['tabela'][] = $item;
            $totalFaturamentoComparar += $item['comparar']['faturamento_float'];
            $totalLitrosComparar += $item['comparar']['litros'];
            $totalFaturamentoAnalizar += $item['analizar']['faturamento_float'];
            $totalLitrosAnalizar += $item['analizar']['litros'];
        }

        $razaoComparar = $totalLitrosComparar ? $totalFaturamentoComparar / $totalLitrosComparar : 0;
        $razaoAnalisar = $totalLitrosAnalizar ? $totalFaturamentoAnalizar / $totalLitrosAnalizar : 0;

        $res['totais'] = [
            'comparar_faturado' => convert_float_money($totalFaturamentoComparar),
            'comparar_litros' => $totalLitrosComparar,
            'analisar_faturado' => convert_float_money($totalFaturamentoAnalizar),
            'analisar_litros' => $totalLitrosAnalizar,
            'comparar_ticket' => convert_float_money($razaoComparar),
            'analisar_ticket' => convert_float_money($razaoAnalisar),
            'taxa_faturado' => $totalFaturamentoComparar ? round((($totalFaturamentoAnalizar - $totalFaturamentoComparar) / $totalFaturamentoComparar), 4) : 0,
            'taxa_litros' => $totalLitrosComparar ? round((($totalLitrosAnalizar - $totalLitrosComparar) / $totalLitrosComparar), 4) : 0,
            'taxa_ticket' => $razaoComparar ? round(((($razaoAnalisar) - ($razaoComparar)) / ($razaoComparar)), 4) : 0,
        ];
        return $res;
    }
}
