<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        $user = User::create($validatedData);

        return response()->json(['message' => 'Stworzono pomyśnie', 'user' => $user], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = User::find($request->id);
        if(!$user){
            return response()->json(['message' => 'Nie znaleziono użytkownika'], 404);
        };

        $validatedData = $request->validate([
            'name' => 'string',
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:8',
            'role' => 'in:superadmin,admin,user'
        ]);

        $user->update($validatedData);

        return response()->json(['message' => 'Zaktualizowano pomyślnie', 'user' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $user = User::find($request->id);
        if(!$user){
            return response()->json(['message' => 'Nie znaleziono użytkownika'], 404);
        }

        if($user->id == $request->user()->id){
            return response()->json(['message' => 'Nie możesz usunąć siebie'], 403);
        }

        $user->delete();
        return response()->json(['message' => 'Usunięto poprawnie'], 200);
    }
}
