<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuarios extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    protected $table = 'usuarios'; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Name',
        'Email',
        'Password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'Password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'Password' => 'hashed',
        ];
    }
    
    // Definir la relación con la tabla 'Informacion_personal'
    public function Informacion_personal()
    {
        return $this->hasOne(Informacion_personal::class, 'usuario_id');
    }

    public function deleteUser()
    {
        // Aquí puedes realizar alguna lógica antes de eliminar el usuario
        // Ejemplo: eliminar también los detalles del usuario
        if ($this->Informacion_personal) {
            $this->Informacion_personal->delete(); // Elimina el detalle relacionado
        }

        // Ahora eliminamos el usuario
        $this->delete();
    }
}
