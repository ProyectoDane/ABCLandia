<?php

class Palabra extends \Eloquent
{
    use SoftDeletingTrait;
    
    public static function rules($letra)
    {
        return [
            'palabra' => 'required | alpha | max:12|letra:'.$letra,
            'foto'    => 'format:image/jpeg,image/png',
            'sonido'  => 'format:audio/mpeg,audio/mp3'
        ];
    }
    
    protected $fillable = ['palabra', 'imagen_id', 'sonido_id'];
    protected $dates    = ['deleted_at'];
    
    protected $hidden   = ['categoria_id', 'created_at', 'deleted_at', 'updated_at'];
    
    public function imagen()
    {
        return $this->belongsTo('Imagen');
    }
    
    public function sonido()
    {
        return $this->belongsTo('Sonido');
    }
    
    public function scopeByCategoria($query, $categoria_id)
    {
        return $query->where('categoria_id', $categoria_id);
    }
    
    public static function get($letra, $categoria_id)
    {
        if ($letra === 'ñ')
            return self::where('categoria_id', $categoria_id)->where('letra', $letra)->get()->last();
        else
            return self::where('categoria_id', $categoria_id)->where('letra', $letra)->first();
    }
    
    public function update(array $attributes = array())
    {
        $foto = Input::file('foto');
        
        if (null !== $foto)
        {
            $tmpName = $foto->getRealPath();
            $fp = fopen($tmpName, 'r');
            $imagen_id = Imagen::create(['data' => fread($fp, filesize($tmpName))])->id;
            fclose($fp);
            
            $attributes['imagen_id'] = $imagen_id;
        }
        else
        {
            $attributes['imagen_id'] = $this->imagen_id;
        }
        
        $sonido = Input::file('sonido');
        
        if (null !== $sonido)
        {
            // Levanto el mp3
            $tmpName = $sonido->getRealPath();
            $fp = fopen($tmpName, 'r');
            $mp3 = fread($fp, filesize($tmpName));
            fclose($fp);
            
            // Lo convierto en ogg
            // <!-- build:so linux -->
            $exec = '/exec/';
            $ffmpeg = './ffmpeg';
            // <!-- /build -->
            
            // <!-- build:so windows -->
            $exec = '\\exec\\';
            $ffmpeg = 'ffmpeg.exe';
            // <!-- /build -->
            
            $path = app_path() . $exec;
            $command = $path . $ffmpeg . ' -i ' . $tmpName . ' -c:a libvorbis -qscale:a 5 ' . $tmpName . '.ogg';
            
            exec($command);
            
            // Levanto el ogg
            $fp = fopen($tmpName.'.ogg', 'r');
            $ogg = fread($fp, filesize($tmpName.'.ogg'));
            fclose($fp);
            
            // Guardamos el sonido en la base
            $sonido_id = Sonido::create(['mp3' => $mp3, 'ogg' => $ogg])->id;
            
            $attributes['sonido_id'] = $sonido_id;
        }
        else
        {
            $attributes['sonido_id'] = $this->sonido_id;
        }

        parent::update($attributes);
    }
}