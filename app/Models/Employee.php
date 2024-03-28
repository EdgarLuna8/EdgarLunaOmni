<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'id',
        'codigo',
        'nombre',
        'salarioDolares',
        'salarioPesos',
        'direccion',
        'estado',
        'ciudad',
        'celular',
        'correo',
        'activo'
    ];
}
