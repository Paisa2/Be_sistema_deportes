<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrenador extends Model
{
    use HasFactory;
    protected $table = 'entrenadores';

    protected $fillable = [
        'nombre',
        'apellidos',
        'edad',
        'archivo',
    ];

    //Se ocultan los campos en la base de datos
    protected $hidden = ['created_at', 'updated_at'];

    public function diciplinas()
    {
        return $this->hasMany(Disiplina::class, 'diciplina_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}
