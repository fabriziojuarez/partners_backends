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
        'hierarchy',
        'prefix',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'hierarchy' => 'integer',
        ];
    }

    // Un Rol puede tener a varios Partners
    public function partners()
    {
        return $this->hasMany(Partner::class);
    }

    // Funcion para saber si puede visualizar partners
    public function isManager(): bool
    {
        return in_array($this->prefix, ['BT', 'SSV', 'SM']);
    }
}
