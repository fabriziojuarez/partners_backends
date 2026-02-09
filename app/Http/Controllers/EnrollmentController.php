<?php

namespace App\Http\Controllers;

use App\Http\Requests\Enrollment\StoreEnrollmentRequest;
use App\Http\Resources\EnrollmentResource;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Evaluation;
use App\Models\Partner;
use App\Models\Topic;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class EnrollmentController extends Controller
{
    public function index(){
        $enrollments = Enrollment::paginate(10);

        $enrollments->load(['course', 'partner']);


        $data = [
            "message" => "Listando matriculas",
            "enrollments" => EnrollmentResource::collection($enrollments),
        ];
        return response()->json($data, 200);
    }

    public function show(){

    }

    public function store(StoreEnrollmentRequest $request)
    {
        $course = Course::findOrFail($request->course_id);
        $partner = Partner::findOrFail($request->partner_id);

        // Recopilar los temas del curso
        $topics = Topic::where('course_id', $course->id)
            ->where('is_active', true)->get();

        if($topics->isEmpty()){
            $data = [
                'message' => "Curso no tiene temas configurados para evaluar",
                'topics'=> $topics,
            ];
            return response()->json($data, 434);
        }

        // Autorizacion


        // Creacion de la matricula
        $enrollment = DB::transaction(function () use ($request) {
            return Enrollment::create([
                "partner_id" => $request->partner_id,
                "course_id" => $request->course_id,
                "period_month" => $request->period_month,
                "period_year" => $request->period_year,
            ]);
        });

        // Generacion de registros respecto a la cantidad de temas a evaluar
        DB::transaction(function () use ($enrollment, $topics) {
            $topics->map(function($topic) use ($enrollment){
            Evaluation::create([
                    'enrollment_id' => $enrollment->id,
                    'topic_id' => $topic->id,
                ]);
            });
        });

        $enrollment->refresh();
        $enrollment->load(['course', 'partner']);

        $data = [
            "message" => "Matricula creada y Evaluaciones cargadas",
            "matricula" => new EnrollmentResource($enrollment),
        ];
        return response()->json($data, 200);
    }

    public function update(){

    }

    public function delete(){

    }
}
