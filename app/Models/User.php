<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\src\Usuarios\Funcoes\AdminsUsuario;
use App\src\Usuarios\Funcoes\GerenteRegionalUsuario;
use App\src\Usuarios\Funcoes\VendedorUsuario;
use App\src\Usuarios\Status\AtivoStatusUsuario;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'funcao',
        'status',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getUser(int $id) //possui Service
    {
        return $this->newQuery()->find($id);
    }

    public function getNomes()
    {
        $dados = $this->newQuery()->get();
        $items = [];
        foreach ($dados as $dado) {
            $items[$dado->id] = [
                'id' => $dado->id,
                'codigo' => $dado->codigo,
                'nome' => $dado->name
            ];
        }
        return $items;
    }

    public function createAdmin($request, string $funcao)
    {
        $user = $this
            ->create([
                'codigo' => $request->codigo,
                'name' => $request->nome,
                'funcao' => $funcao,
                'email' => $request->email,
                'password' => Hash::make($request->senha),
                'superior' => $request->gerente,
                'status' => (new AtivoStatusUsuario())->getStatus()
            ]);

        event(new Registered($user));
    }

    public function get()
    {
        return $this->newQuery()->get();
    }

    public function atualizarSenha($id, $senha)
    {
        $this->newQuery()
            ->find($id)
            ->update([
                'password' => Hash::make($senha)
            ]);
    }
}
