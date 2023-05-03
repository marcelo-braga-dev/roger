<?php

namespace App\Service\Usuarios\Metas;

use App\Models\MetaVendas;
use App\Models\User;
use App\Service\Usuarios\Funcoes\FuncoesService;

class GerentesMetasService extends FuncoesService
{
    public function metas()
    {
        $gerentes = (new User())->getGerentes();
        $dados = [];
        foreach ($gerentes as $gerente) {
            $vendedores = (new User())->getVendedorPeloSuperior($gerente->id);
            $this->metas[$gerente->id] = (new MetaVendas())->getMetaGerente($vendedores);

            $dados[] = ($this->dado($gerente));
        }

        return $dados;
    }
}
