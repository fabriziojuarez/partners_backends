<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $table = 'entrollments';

    protected $fillable = [
        'course_id',
        'partner_id',
        'period_month',
        'period_year'
    ];

    // Funcion que expone el atriburo period por convencion: get-Period-Attribute
    public function getPeriodAttribute()
    {
        return sprintf('%04d-%02d', $this->period_year, $this->period_month);
    }

    // Una inscripcion corresponde a un curso
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Una inscripcion corresponde a un partner
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    // Una inscripcion puede tener muchas evaluaciones
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}
