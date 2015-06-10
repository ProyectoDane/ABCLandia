<?php

class Rendimiento extends \Eloquent
{      
    public static $rules = [
        'alumno_id'         => 'required | numeric | exists:alumnos,id',
        'maestro_id'        => 'required | numeric | exists:maestros,id',
        'categoria_id'      => 'required | numeric | exists:categorias,id',
        'ejercicio'         => 'required | numeric | min:1|max:6',
        'nivel'             => 'required | numeric | min:1|max:3',
        'secuencia'         => 'required | alpha',
        'tiempo'            => 'required | numeric | min:0',
        'cantidad_aciertos' => 'required | numeric | min:0',
        'cantidad_fallas'   => 'required | numeric | min:0',
        'timestamp'         => 'required | date_format:Y-m-d H:i:s',
    ];
    
    protected $fillable = [
        'alumno_id',
        'maestro_id',
        'categoria_id',
        'ejercicio',
        'nivel',
        'secuencia',
        'tiempo',
        'cantidad_aciertos',
        'cantidad_fallas',
        'timestamp'
    ];
 
    protected $hidden   = ['created_at', 'updated_at'];
}