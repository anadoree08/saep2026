@extends('layouts.app')

@section('content')
<h3 class="mb-3">Gerenciamento de Pets</h3>

<div class="card shadow-sm mb-4">
    <div class="card-header fw-bold">Cadastrar Novo Pet</div>
    <div class="card-body">
        <form action="{{ route('pets.store') }}" method="POST" class="row g-3">
            @csrf
            <div class="col-md-4">
                <label class="form-label">Tutor Responsável</label>
                <select name="tutor_id" class="form-select" required>
                    <option value="">Selecione um tutor...</option>
                    @foreach($tutores as $tutor)
                        <option value="{{ $tutor->id }}">{{ $tutor->nome }} ({{ $tutor->telefone }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Nome do Pet</label>
                <input type="text" name="nome" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Espécie</label>
                <input type="text" name="especie" class="form-control" placeholder="Ex: Cachorro, Gato" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Raça</label>
                <input type="text" name="raca" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="form-label">Nascimento</label>
                <input type="date" name="data_nascimento" class="form-control">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-success">Cadastrar Pet</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header fw-bold">Pets Cadastrados</div>
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome do Pet</th>
                    <th>Espécie</th>
                    <th>Raça</th>
                    <th>Data Nascimento</th>
                    <th>Tutor Responsável</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pets as $pet)
                <tr>
                    <td>{{ $pet->id }}</td>
                    <td>{{ $pet->nome }}</td>
                    <td>{{ $pet->especie }}</td>
                    <td>{{ $pet->raca ?? '-' }}</td>
                    <td>{{ $pet->data_nascimento ? date('d/m/Y', strtotime($pet->data_nascimento)) : '-' }}</td>
                    <td>{{ $pet->tutor->nome }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-3">Nenhum pet cadastrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection