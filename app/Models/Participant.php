<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Participant
 *
 * @property $id
 * @property $nombre
 * @property $email
 * @property $celular
 * @property $cedula
 * @property $direccion
 * @property $estado
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Participant extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'email', 'celular', 'cedula', 'direccion', 'estado'];


}
