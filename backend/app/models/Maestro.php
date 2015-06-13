<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;

class Maestro extends Eloquent implements UserInterface
{
    use UserTrait;
    use SoftDeletingTrait;
    
    const MAESTRO = 1;
    const SUPERVISOR = 2;

    public static $rules = [
        'nombre' => 'required | max:12',
        'apellido' => 'required | max:12',
        'email' => 'required|email|max:50',
        'tipo' => 'required|between:1,2'
    ];

    protected $fillable = ['nombre', 'apellido', 'email', 'tipo'];
    protected $dates    = ['deleted_at'];
    
    protected $hidden   = ['created_at', 'deleted_at', 'updated_at', 'password', 'token'];
    
    public function alumnos()
    {
        return $this->belongsToMany('Alumno');
    }
}