<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estimation;

class EstimationController extends Controller
{
    public function index()
    {
        return Estimation::all();
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'project_id' => 'required|exists:projects,id',
            'price' => 'required|numeric',
            'duration' => 'required|numeric',
            'type' => 'required|in:fixed,hourly',
        ]);

        return response()->json(['message' => 'Stworzono pomyśnie', 'estimation' => Estimation::create($data)], 201);
    }

    public function show(Estimation $estimation)
    {
        return $estimation;
    }

    public function update(Request $request, Estimation $estimation)
    {
        $estimation = Estimation::find($request->id);
        if(!$estimation){
            return response()->json(['message' => 'Nie znaleziono szacunku'], 404);
        };
        $data = $request->validate([
            'name' => 'string',
            'description' => 'string',
            'project_id' => 'exists:projects,id',
            'price' => 'numeric',
            'duration' => 'numeric',
            'type' => 'in:fixed,hourly',
        ]);

        $estimation->update($data);

        return response()->json(['message' => 'Zaktualizowano pomyśnie', 'estimation' => $estimation], 200);
    }

    public function destroy(Request $request)
    {
        $estimation = Estimation::find($request->id);
        if(!$estimation){
            return response()->json(['message' => 'Nie znaleziono szacunku'], 404);
        };
        $estimation->delete();

        return response()->json(['message' => 'Usunięto pomyśnie'], 200);
    }


}
