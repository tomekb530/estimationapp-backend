<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        return Project::all();
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'client_id' => 'required|exists:clients,id',
        ]);

        return response()->json(['message' => 'Stworzono pomyśnie', 'project' => Project::create($data)], 201);
    }

    public function show(Project $project)
    {
        return $project;
    }

    public function update(Request $request)
    {
        $project = Project::find($request->id);
        if(!$project){
            return response()->json(['message' => 'Nie znaleziono projektu'], 404);
        };
        $data = $request->validate([
            'name' => 'string',
            'description' => 'string',
            'client_id' => 'exists:clients,id',
        ]);

        $project->update($data);

        return response()->json(['message' => 'Zaktualizowano pomyśnie', 'project' => $project], 200);
    }

    public function destroy(Request $request)
    {
        $project = Project::find($request->id);
        if(!$project){
            return response()->json(['message' => 'Nie znaleziono projektu'], 404);
        };
        $project->delete();

        return response()->json(['message' => 'Usunięto pomyśnie'], 200);
    }


}
