<?php

namespace App\Http\Controllers;

use App\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class TutorController extends Controller
{
    public function index(Request $request)
    {
        $busca = $request->input('busca');

        $tutores = Tutor::when($busca, function ($query, $busca) {
                $query->where('nome', 'ILIKE', "%{$busca}%")
                      ->orWhere('email', 'ILIKE', "%{$busca}%")
                      ->orWhere('telefone', 'ILIKE', "%{$busca}%");
            })
            ->orderBy('nome', 'asc')
            ->get();

        return view('tutores.index', compact('tutores', 'busca'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:150'],
            'cpf' => ['required', 'string', 'max:20'],
            'telefone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:150'],
        ]);

        Tutor::create([
            'nome' => $dados['nome'],
            'cpf' => Crypt::encryptString($dados['cpf']),
            'telefone' => $dados['telefone'],
            'email' => $dados['email'],
        ]);

        return redirect()->route('tutores.index')->with('sucesso', 'Tutor cadastrado com sucesso (CPF criptografado)!');
    }

    public function edit(Tutor $tutor)
    {
        return view('tutores.edit', compact('tutor'));
    }

    public function update(Request $request, Tutor $tutor)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:150'],
            'cpf' => ['required', 'string', 'max:20'],
            'telefone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:150'],
        ]);

        $tutor->update([
            'nome' => $dados['nome'],
            'cpf' => Crypt::encryptString($dados['cpf']),
            'telefone' => $dados['telefone'],
            'email' => $dados['email'],
        ]);

        return redirect()->route('tutores.index')->with('sucesso', 'Dados do tutor atualizados com sucesso!');
    }

    public function destroy(Tutor $tutor)
    {
        $tutor->delete();
        return redirect()->route('tutores.index')->with('sucesso', 'Tutor excluído com sucesso!');
    }
}