<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Actividad extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'actividades';
    
    // HU-03 y HU-04: Campos permitidos para el CRUD
    protected $fillable = [
        'titulo', 
        'descripcion', 
        'asignatura_id', 
        'fecha_limite', 
        'prioridad', 
        'estado'
    ];
}