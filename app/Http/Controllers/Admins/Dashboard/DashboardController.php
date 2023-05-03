<?php

namespace App\Http\Controllers\Admins\Dashboard;

use App\Http\Controllers\Controller;
use App\Service\Analises\ProdutosService;
use App\Service\Dashboard\DescontoMedioService;
use App\Service\Dashboard\MediaMcService;
use App\Service\Dashboard\PrazoMedioService;
use App\Service\Dashboard\TabelaProdutos;
use App\Service\Dashboard\TabelaGerentesService;
use App\Service\Dashboard\TabelaVendedoreService;
use App\Service\Produtos\GruposService;
use App\Service\Usuarios\Funcoes\VendedoresUsuariosService;
use App\Service\Usuarios\UsuariosService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {        
        return Inertia::render('Admin/Dashboard/Index');
    }

    public function filtrar(Request $request)
    {
        $descontoMedio = (new DescontoMedioService())->calcular($request);
        $mediaMc = (new MediaMcService())->calcular($request);
        $prazoMedio = (new PrazoMedioService())->calcular($request);

        $produtos = (new TabelaProdutos())->calcular($request);
        $gerentes = (new TabelaGerentesService())->calcular($request);
        $vendedores = (new TabelaVendedoreService())->calcular($request);

        return [
            'produtos' => $produtos,
            'gerentes' => $gerentes,
            'vendedores' => $vendedores,
            'descontoMedio' => $descontoMedio,
            'mediaMc' => $mediaMc,
            'prazoMedio' => $prazoMedio,
        ];
    }

    public function usuarios(Request $request)
    {
        $usuarios = (new UsuariosService())->todosUsuarios();
        if ($request->gerente)
            $vendedores = (new VendedoresUsuariosService())->getVendedoresPeloSuperior($request->gerente);
        else {
            $vendedores = (new VendedoresUsuariosService())->getUsers();
        }

        $grupos = (new GruposService())->getGrupos();

        return [
            'gerentes' => $usuarios['gerente_regional'],
            'vendedores' => $vendedores,
            'grupos' => $grupos
        ];
    }
}
