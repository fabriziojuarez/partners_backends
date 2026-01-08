<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = [
        'title',
        'description',
    ];

    // Un curso puede tener varios temas
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    // Un curso puede estar en varias matriculas
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
