<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Partner extends Authenticatable
{
    use HasFactory;

    protected $table = 'partners';

    protected $fillable = [
        'name',
        'role_id',
    ];

    protected $hidden = [
        //'id',
        'user_id',
        'created_at',
        'updated_at',
    ];

    // Un Partner pertenece a un Usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un Partner pertemece a un rol
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Un Partner puede estar en varias matriculas
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
