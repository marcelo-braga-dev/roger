<?php

namespace App\Service\Usuarios\Funcoes;

use App\Models\MetaVendas;
use App\Models\User;

abstract class FuncoesService
{
    private $usuario;
    protected $metas;
    private $funcao;

    public function __construct()
    {
        $this->usuario = (new User())->getNomes();
        $this->metas = [];
    }

    protected function dados($items): array
    {
        $dados = [];
        foreach ($items as $item) {
            $this->metas = (new MetaVendas())->getMetas();

            $dados[] = $this->dadosCompleto($item);
        }
        return $dados;
    }

    protected function dado($item)
    {
        return $this->dadosCompleto($item);
    }

    protected function nomes($items): array
    {
        $dados = [];
        foreach ($items as $item) {
            $dados[] = [
                'id' => $item->id,
                'codigo' => $item->codigo,
                'nome' => $item->name,
            ];
        }
        return $dados;
    }

    private function dadosCompleto($item): array
    {
        return [
            'id' => $item->id,
            'codigo' => $item->codigo,
            'nome' => $item->name,
            'codigo_nome' => $item->codigo . ' - ' . $item->name,
            'email' => $item->email,
            'funcao' => $item->funcao,
            'superior_id' => $item->superior,
            'superior_nome' => $this->usuario[$item->superior]['nome'] ?? '',
            'data_cadastro' => date('d/m/y H:i', strtotime($item->created_at)),
            'meta_semestre_1' => $this->metas[$item->id]['semestre_1'] ?? 0,
            'meta_semestre_2' => $this->metas[$item->id]['semestre_2'] ?? 0,
        ];
    }
}
