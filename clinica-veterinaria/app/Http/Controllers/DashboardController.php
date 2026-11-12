<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Pet;
use App\Models\Tutor;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        $totalTutores = Tutor::count();
        $totalPets = Pet::count();
        $totalAgendamentos = Agendamento::count();

        return view('dashboard', compact('usuario', 'totalTutores', 'totalPets', 'totalAgendamentos'));
    }
}