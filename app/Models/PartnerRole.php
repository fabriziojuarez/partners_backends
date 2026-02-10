<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerRole extends Model
{
    use HasFactory;

    protected $table = 'partner_roles';

    protected $fillable = [
        'name',
        'hierarchy',
        'prefix',
        'description',
    ];

    protected $hidden = [
        'id',
        'hierarchy',
        'created_at',
        'updated_at',
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
}
