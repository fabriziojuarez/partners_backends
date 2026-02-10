<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseTopic extends Model
{
    protected $table = 'course_topics';

    protected $fillable = [
        'name',
        'is_active',
        'grade_max',
        'course_id',
        'description',
    ];

    protected $hidden = [
        'course_id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'grade_max' => 'float',
            'course_id' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    // Un Tema corresponde a un Curso
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Un Tema puede tener varias Evaluaciones
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}
