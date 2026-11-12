<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Tutor;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function index()
    {
        $pets = Pet::with('tutor')->orderBy('nome', 'asc')->get();
        $tutores = Tutor::orderBy('nome', 'asc')->get();

        return view('pets.index', compact('pets', 'tutores'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'tutor_id' => ['required', 'exists:tutores,id'],
            'nome' => ['required', 'string', 'max:100'],
            'especie' => ['required', 'string', 'max:60'],
            'raca' => ['nullable', 'string', 'max:80'],
            'data_nascimento' => ['nullable', 'date'],
        ]);

        Pet::create($dados);

        return redirect()->route('pets.index')->with('sucesso', 'Pet cadastrado e vinculado ao tutor com sucesso!');
    }
}