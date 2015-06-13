<?php

class Imagen extends \Eloquent
{
    protected $table = 'imagenes';
    protected $fillable = ['data'];
    protected $hidden   = ['created_at', 'updated_at'];
}