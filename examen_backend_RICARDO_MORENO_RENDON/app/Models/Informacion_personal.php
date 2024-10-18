<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Informacion_personal extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $table = 'informacion_personal'; 

    // Define los campos que pueden ser asignados en masa
    protected $fillable = ['usuario_id', 'Direccion', 'Telefono', 'Fecha_nacimiento'];

    // Define la relación con el modelo Usuarios
    public function Usuarios()
    {
        return $this->belongsTo(Usuarios::class, 'usuario_id');
    }
}
