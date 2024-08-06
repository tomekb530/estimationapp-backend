<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Client::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'description' => 'required|string',
            'country' => 'required|string',
            'logo' => 'nullable|image',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos');
        }

        return response()->json(['message' => 'Stworzono pomyśnie', 'client' => Client::create($data)], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return $client;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $client = Client::find($request->id);
        if (!$client) {
            return response()->json(['message' => 'Nie znaleziono klienta'], 404);
        }

        $data = $request->validate([
            'name' => 'string',
            'email' => 'email',
            'description' => 'string',
            'country' => 'string',
            'logo' => 'nullable|image',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos');
        }

        $client->update($data);

        return response()->json(['message' => 'Zaktualizowano pomyślnie', 'client' => $client], 200);
    }

    public function logo(Request $request){
        $client = Client::find($request->id);
        if (!$client) {
            return response()->json(['message' => 'Nie znaleziono klienta'], 404);
        }

        return response()->download(storage_path('app/' . $client->logo));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $client = Client::find($request->id);
        if (!$client) {
            return response()->json(['message' => 'Nie znaleziono klienta'], 404);
        }

        $client->delete();

        return response()->json(['message' => 'Usunięto pomyślnie'], 200);
    }
}
