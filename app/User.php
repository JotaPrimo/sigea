<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'id_perfil',
        'inativadoPorUsuario',
        'dataInativado',
        'motivoInativado',
        'ativo',
    ];

    const ATIVO = 1;
    const INATIVO = 0;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'id_perfil');
    }

    public function isAdmin()
    {
        return $this->id_perfil == Perfil::ADMIN;
    }

    public function isUserExterno()
    {
        return $this->id_perfil == Perfil::USUARIO_EXTERNO;
    }

    public static retornaAtividadesUsuarioLogado() {
        return Atividade::where('ativo', '=', Atividade::ATIVO)
            ->where('cadastradoPorUsuario', '=', auth()->user()->id)
            ->get();
    }

    public static retornaAtividadesExternas() {
        return Atividade::where('ativo', '=', Atividade::ATIVO)
            ->where('cadastradoPorUsuario', '!=', auth()->user()->id)
            ->get();
    }

}
