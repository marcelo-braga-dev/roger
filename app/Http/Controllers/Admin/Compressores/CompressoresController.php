<?php

namespace App\Http\Controllers\Admin\Compressores;

use App\Http\Controllers\Controller;
use App\Models\Compressores;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompressoresController extends Controller
{
    public function index()
    {
        $dados = (new Compressores())->get();

        return Inertia::render('Admin/Compressores/Index', compact('dados'));
    }

    public function show($id)
    {
        $compressor = (new Compressores())->find($id);

        return Inertia::render('Admin/Compressores/Show');
    }

    public function create()
    {
        return Inertia::render('Admin/Compressores/Create');
    }

    public function store(Request $request)
    {
        (new Compressores())->create($request);
        return redirect()->route('admin.compressores.index');
    }
}
