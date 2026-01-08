<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemRole extends Model
{
    protected $table = 'systemroles';

    protected $fillable = [
        'name',
        'description',
    ];

    // Un Rol de Sistema puede tener muchos Usuarios
    public function users()
    {
        return $this->hasMany(User::class, 'systemrole_id');
    }
}
