<?php

namespace App\Http\Controllers\Admin\Compressores;

use App\Http\Controllers\Controller;
use App\Models\Compressores;
use Illuminate\Http\Request;

class DadosController extends Controller
{
    public function store(Request $request)
    {
        (new Compressores())->armazenarDados($request);
    }
}
