<?php

use \Illuminate\Database\Eloquent\Collection;

class Alumno extends \Eloquent
{
    use SoftDeletingTrait;
    
    public static $rules = [
            'nombre' => 'required | max:12|unique_with:alumnos,apellido',
            'apellido' => 'required | max:12',
            'edad' => 'required | integer | between:2,99',
            'sexo' => 'required|between:1,2',
            'categoria_id' => 'required | completa',
            'maestros' => 'required | minCount:1',
            'tipo_letra' => 'required | numeric | between:1,3'
    ];
    
    public static function create_rules()
    {
        return self::$rules;
    }
    
    public static function update_rules($id)
    {
        $rules = self::$rules;
        $rules['nombre'] .= ','.$id;
        return $rules;
    }
    
    protected $fillable = ['nombre', 'apellido', 'edad', 'sexo', 'categoria_id', 'tipo_letra'];
    protected $dates    = ['deleted_at'];
    
    protected $hidden   = ['created_at', 'deleted_at', 'updated_at'];
    
    //public function categoria()
    //{
    //    return $this->belongsTo('Categoria');
    //}
    
    public function maestros()
    {
        return $this->belongsToMany('Maestro');
    }
    
    public function categoria()
    {
        return $this->belongsTo('Categoria');
    }
    
    public function ToDto()
    {
        $alumno_dto = new stdClass();
        
        $alumno_dto->id             = $this->id;
        $alumno_dto->nombre         = $this->nombre;
        $alumno_dto->apellido       = $this->apellido;
        $alumno_dto->sexo           = $this->sexo;
        $alumno_dto->edad           = $this->edad;
        $alumno_dto->maestros       = new Collection(array_pluck($this->maestros, 'id'));
        $alumno_dto->categoria_id   = (int) $this->categoria_id;
        $alumno_dto->categoria_nombre = $this->categoria->nombre;
        $alumno_dto->tipo_letra     = $this->tipo_letra;
        
        $alumno_dto->maestros_nombres = implode(", ",
                array_map(function($e) {
                    return $e['apellido'] . ' ' . $e['nombre'];
                }, $this->maestros->toArray()));
        
        return $alumno_dto;
    }
    
    public static function create(array $attributes)
    {
        $maestros = $attributes['maestros'];
        array_forget($attributes, 'maestros');
        
        $me = parent::create($attributes);
        $me->maestros()->sync($maestros);    

        return $me;
    }
    
    public function update(array $attributes = array())
    {
        parent::update($attributes);
        
        if (Auth::user()->tipo === Maestro::SUPERVISOR)
        {
            $this->maestros()->sync($attributes['maestros']);
        }
        
        return $this;
    }
}