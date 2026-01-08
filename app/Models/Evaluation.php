<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $table = 'evaluations';

    protected $fillable = [
        'enrollment_id',
        'topic_id',
        'nota'
    ];

    // Una Evaluacion corresponde a una Inscripcion
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    // Una Evaluacion corresponde a un Tema
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
