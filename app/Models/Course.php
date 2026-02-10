<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = [
        'title',
        'description',
        'is_active',
        'manager_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'manager_id' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    // Un curso puede tener varios temas
    public function course_topics()
    {
        return $this->hasMany(CourseTopic::class);
    }

    // Un curso puede estar en varias matriculas
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // Un curso es gestionado por un partner (manager)
    public function manager()
    {
        return $this->belongsTo(Partner::class, 'manager_id');
    }
}
