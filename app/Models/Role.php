<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'name',
        'herarchy',
        'prefix',
        'description',
    ];

    // Un Rol puede tener a varios Partners
    public function partners()
    {
        return $this->hasMany(Partner::class);
    }
}
