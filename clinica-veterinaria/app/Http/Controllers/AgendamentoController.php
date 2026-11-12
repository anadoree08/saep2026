<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Pet;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendamentoController extends Controller
{
    public function index()
    {
        $agendamentos = Agendamento::with(['tutor', 'pet'])
            ->orderBy('data_agendamento', 'asc')
            ->orderBy('hora_agendamento', 'asc')
            ->get();

        $tutores = Tutor::orderBy('nome', 'asc')->get();
        $pets = Pet::with('tutor')->orderBy('nome', 'asc')->get();

        return view('agendamentos.index', compact('agendamentos', 'tutores', 'pets'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'tutor_id' => ['required', 'exists:tutores,id'],
            'pet_id' => ['required', 'exists:pets,id'],
            'data_agendamento' => ['required', 'date'],
            'hora_agendamento' => ['required'],
            'servico' => ['required', 'string', 'max:120'],
            'observacao' => ['nullable', 'string'],
        ]);

        Agendamento::create([
            'user_id' => Auth::id(),
            'tutor_id' => $dados['tutor_id'],
            'pet_id' => $dados['pet_id'],
            'data_agendamento' => $dados['data_agendamento'],
            'hora_agendamento' => $dados['hora_agendamento'],
            'servico' => $dados['servico'],
            'status' => 'Agendado',
            'observacao' => $dados['observacao'] ?? null,
        ]);

        return redirect()->route('agendamentos.index')->with('sucesso', 'Agendamento registrado com sucesso!');
    }

    public function updateData(Request $request, Agendamento $agendamento)
    {
        $dados = $request->validate([
            'data_agendamento' => ['required', 'date'],
        ]);

        $agendamento->update([
            'data_agendamento' => $dados['data_agendamento'],
        ]);

        return redirect()->route('agendamentos.index')->with('sucesso', 'Data do agendamento atualizada com sucesso!');
    }
}