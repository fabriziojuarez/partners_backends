<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $table = 'topics';

    protected $fillable = [
        'name',
        'is_active',
        'note_max',
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
            'note_max' => 'float',
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
