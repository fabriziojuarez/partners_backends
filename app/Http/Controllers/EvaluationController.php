<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function index(){
        // TRAERA TODAS LAS MATRICULAS
    }

    public function show($id){
        // SELECCIONAR UNA EVALUACION EN ESPECIFICO??
    }

    public function store(){
        // COMO LAS MATRICULAS NO SE CREAN MANUALMENTE, NO ESTOY SEGURO PARA QUE EMPLEARLO
        // TAL VEZ PARA GENERAR UNA EVALUACION INDIVIDUAL, COMO PARA GENERAR UN INTENTO
        // DE MEJORAR LA NOTA
    }

    public function update(){
        // SOLO SERIVIARIA PARA ACTUALIZAR NOTAS / OBSERVACION O ERRORES
    }

    public function delete(){
        // POSIBLEMENTE ELIMINARLO, LAS EVALUACIONES NO SE PUEDEN ELIMINAR
    }
}
