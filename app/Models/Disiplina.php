<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disiplina extends Model
{
    use HasFactory;

    protected $table = 'disiplinas';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    //Se ocultan los campos en la base de datos
    protected $hidden = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function entrenador()
    {
        return $this->belongsToMany(Entrenador::class, 'entrenador_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}
