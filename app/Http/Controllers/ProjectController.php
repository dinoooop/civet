<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query();
        if (isset($request->search)) {
            $query->where('name', 'like', "%{$request->search}%");
        }
        $data = $query->orderBy('created_at', 'desc')->get();
        return response()->json($data);
    }

    public function show(Request $request, $id)
    {
        $data = Project::findOrFail($id);
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $data = Project::create($validated);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
        ]);

        $data = Project::findOrFail($id)->update($validated);
        return response()->json($data);
    }

    public function destroy(Request $request, $id)
    {
        $data = Project::findOrFail($id)->delete();
        return response()->json($data);
    }
}
