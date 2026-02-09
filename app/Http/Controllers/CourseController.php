<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Course;
use App\Models\Partner;

class CourseController extends Controller
{

    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('view', Course::class);

        // Posiblemente agregarle el sp para ver el progreso de cada curso
        $courses = Course::paginate(5);

        $courses->load(['manager', 'topics']);

        $data = [
            'message' => 'Lista de Cursos',
            'courses' => CourseResource::collection($courses),
        ];
        return response()->json($data, 200);
    }
    
    public function show($id)
    {
        // Extraer con algun sp su progreso y partners matriculados
        $course = Course::findOrFail($id);

        $this->authorize('viewAny', $course);

        $course->load(['manager', 'topics']);

        $data = [
            'message' => 'Detalle del Curso',
            'course' => new CourseResource($course),
        ];
        return response()->json($data, 200);
    }

    public function store(StoreCourseRequest $request)
    {
        $this->authorize('create', [Course::class]);

        $course = DB::transaction(function () use ($request){
            return Course::create([
                'title' => $request->title,
                'description' => $request->description,
                'manager_id' => Auth::user()->partner->id,
            ]);
        });

        $course->refresh();
        $course->load(['manager']);

        $data = [
            'message' => 'Curso Creado',
            'course' => new CourseResource($course),
        ];
        return response()->json($data, 201);
    }

    public function update(UpdateCourseRequest $request, $id)
    {
        $course = Course::with(['manager'])->findOrFail($id);
        $partner = Partner::find($request->manager_id) ?? $course->manager;
        $this->authorize('update', [$course, $partner]);

        DB::transaction(function () use ($request, $course){
            if($request->filled('title')){
                $course->update(['title' => $request->title]);
            }
            if($request->filled('description')){
                $course->update(['description' => $request->description]);
            }
            if($request->filled('is_active')){
                $course->update(['is_active' => $request->is_active]);
            }
            if($request->filled('manager_id')){
                $course->update(['manager_id' => $request->manager_id]);
            }
        });

        $course->refresh();

        $data = [
            'message' => 'Curso Actualizado',
            'course' => new CourseResource($course),
        ];
        return response()->json($data, 200);
    }

    public function delete($id)
    {
        $course = Course::with(['manager'])->findOrFail($id);
        $this->authorize('delete', [$course]);

        DB::transaction(function () use ($course){
            $course->delete();
        });

        $data = [
            'message' => 'Curso Eliminado',
        ];
        return response()->json($data, 200);
    }
}
