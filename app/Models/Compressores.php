<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compressores extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome'
    ];

    public function get()
    {
        return $this->newQuery()
            ->get();
    }

    public function create($dados)
    {
        $this->newQuery()
            ->create([
                'nome' => $dados->nome
            ]);
    }

    public function armazenarDados($dados)
    {

    }

    public function find($id)
    {
        return $this->newQuery()
            ->find($id);
    }
}
