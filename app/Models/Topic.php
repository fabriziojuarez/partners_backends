<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $table = 'topics';

    protected $fillable = [
        'name',
        'note_max',
        'course_id',
    ];

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
