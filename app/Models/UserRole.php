<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'user_roles';

    protected $fillable = [
        'name',
        'description',
    ];

    // Un Rol de Sistema puede tener muchos Usuarios
    public function users()
    {
        return $this->hasMany(User::class, 'user_role_id');
    }
}
