<?php

class Sonido extends \Eloquent
{
    protected $table = 'sonidos';
    protected $fillable = ['mp3', 'ogg'];
    protected $hidden   = ['created_at', 'updated_at'];
}