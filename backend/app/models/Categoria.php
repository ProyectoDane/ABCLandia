<?php

class Categoria extends \Eloquent
{
    use SoftDeletingTrait;
    
    public static $rules = [
            'nombre'        => 'required | max:50',
            'descripcion'   => 'required',
    ];
    
    protected $fillable = ['nombre', 'descripcion', 'maestro_id'];
    protected $dates    = ['deleted_at'];
    
    protected $hidden   = ['created_at', 'deleted_at', 'updated_at'];
    
    public function maestros()
    {
        return $this->belongsToMany('Maestro');
    }
    
    public function alumnos()
    {
        return $this->hasMany('Alumno');
    }
    
    public static function create(array $attributes)
    {
        $categoria = parent::create($attributes);
        
        DB::statement("INSERT INTO palabras (categoria_id, letra, palabra, created_at, updated_at)
                       SELECT $categoria->id, letra, '', '$categoria->created_at', '$categoria->updated_at' FROM letras");
        
        return $categoria;
    }
    
    public static function copy(Categoria $categoria)
    {
        $nombre = $categoria->nombre . ' (duplicada)';
        $i = 2;
        while (self::where('nombre', $nombre)->get()->count())
        {
            $nombre = $categoria->nombre . ' (duplicada ' . $i++ . ')';
        }
        
        $data = array(
                'nombre' => $nombre,
                'descripcion' => $categoria->descripcion,
                'maestro_id' => Auth::user()->id
        );

        $duplicada = parent::create($data);
        
        DB::statement("INSERT INTO palabras (categoria_id, letra, palabra, imagen_id, sonido_id, created_at, updated_at)
                       SELECT $duplicada->id, letra, palabra, imagen_id, sonido_id, '$duplicada->created_at', '$duplicada->updated_at' FROM palabras WHERE categoria_id = $categoria->id");
        
        return $duplicada;
    }
    
    public function ToDto()
    {
        $dto = new stdClass();
        
        $dto->id            = $this->id;
        $dto->nombre        = $this->nombre;
        $dto->descripcion   = $this->descripcion;
        $dto->propia        = $this->maestro_id === Auth::user()->id;
        
        return $dto;
    }
}