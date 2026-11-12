@extends('layouts.app')

@section('content')
<div class="p-4 bg-white rounded shadow-sm mb-4">
    <h2>Bem-vindo(a), {{ $usuario->name }}!</h2>
    <p class="text-muted mb-0">Selecione um dos módulos abaixo para gerenciar a clínica veterinária.</p>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Tutores ({{ $totalTutores }})</h5>
                <p class="card-text">Cadastro, busca, edição e exclusão de tutores com proteção de CPF (LGPD).</p>
                <a href="{{ route('tutores.index') }}" class="btn btn-success">Acessar Tutores</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Pets ({{ $totalPets }})</h5>
                <p class="card-text">Cadastro de animais vinculados aos seus respectivos tutores.</p>
                <a href="{{ route('pets.index') }}" class="btn btn-success">Acessar Pets</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Agendamentos ({{ $totalAgendamentos }})</h5>
                <p class="card-text">Controle de consultas ordenadas por data e reagendamento.</p>
                <a href="{{ route('agendamentos.index') }}" class="btn btn-success">Acessar Agendamentos</a>
            </div>
        </div>
    </div>
</div>
@endsection