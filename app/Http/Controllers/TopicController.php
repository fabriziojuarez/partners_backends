<?php

namespace App\Http\Controllers;

use App\Http\Requests\Topic\StoreTopicRequest;
use App\Http\Resources\TopicResource;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\Topic;
use App\Models\Course;

class TopicController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Topic::class);

        $topics = Topic::paginate(5);

        $topics->load('course');

        $data = [
            'message' => 'Lista de Temas',
            'topics' => TopicResource::collection($topics),
        ];
        return response()->json($data, 200);
    }

    public function show($id)
    {
        $topic = Topic::findOrFail($id);
        $this->authorize('view', $topic);

        $data = [
            'message' => 'Detalle del Tema',
            'topic' => new TopicResource($topic),
        ];
        return response()->json($data, 200);
    }

    public function store(StoreTopicRequest $request)
    {
        $course = Course::findOrFail($request->course_id);
        //$this->authorize('create', [Topic::class, $course]);

        $topic = DB::transaction(function () use ($request) {
            return Topic::create([
                'name' => $request->name,
                'description' => $request->description,
                'course_id' => $request->course_id,
                'note_max' => $request->note_max,
            ]);
        });

        $topic->refresh();

        $data = [
            'message' => 'Tema Creado',
            'topic' => new TopicResource($topic),
        ];
        return response()->json($data, 201);
    }

    public function update(Request $request, $id)
    {
        $topic = Topic::findOrFail($id);
        $course = Course::find($topic->course_id) ?? $topic->course;
        $this->authorize('update', [$topic, $course]);

        DB::transaction(function() use ($request, $topic) {
            if($request->filled('name')){
                $topic->update(['name' => $request->name,]);
            }
            if($request->filled('description')){
                $topic->update(['description' => $request->description,]);
            }
            if($request->filled('course_id')){
                $topic->update(['course_id' => $request->course_id,]);
            }
            if($request->filled('note_max')){
                $topic->update(['note_max' => $request->note_max,]);
            }
            if($request->filled('is_active')){
                $topic->update(['is_active' => $request->is_active]);
            }
        });

        $topic->refresh();

        $data = [
            'message' => 'Tema Actualizado',
            'topic' => new TopicResource($topic),
        ];
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $topic = Topic::findOrFail($id);
        $this->authorize('delete', $topic);

        DB::transaction(function () use ($topic) {
            $topic->delete();
        });

        $data = [
            'message' => 'Tema Eliminado',
        ];
        return response()->json($data, 200);
    }
}
