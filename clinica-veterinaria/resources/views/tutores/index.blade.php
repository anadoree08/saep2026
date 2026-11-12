@extends('layouts.app')

@section('content')
<h3 class="mb-3">Gerenciamento de Tutores</h3>

<div class="card shadow-sm mb-4">
    <div class="card-header fw-bold">Cadastrar Novo Tutor</div>
    <div class="card-body">
        <form action="{{ route('tutores.store') }}" method="POST" class="row g-3">
            @csrf
            <div class="col-md-4">
                <label class="form-label">Nome Completo</label>
                <input type="text" name="nome" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">CPF (Criptografado)</label>
                <input type="text" name="cpf" class="form-control" placeholder="000.000.000-00" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Telefone</label>
                <input type="text" name="telefone" class="form-control" placeholder="(00) 00000-0000" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-success">Salvar Tutor</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('tutores.index') }}" method="GET" class="row g-2">
            <div class="col-md-9">
                <input type="text" name="busca" class="form-control" placeholder="Buscar tutor por nome, e-mail ou telefone..." value="{{ $busca }}">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Buscar</button>
                @if($busca)
                    <a href="{{ route('tutores.index') }}" class="btn btn-secondary">Limpar</a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header fw-bold">Tutores Cadastrados</div>
    <div class="table-responsive">
        <table class="table table-striped mb-0 align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CPF (LGPD)</th>
                    <th>Telefone</th>
                    <th>E-mail</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tutores as $tutor)
                <tr>
                    <td>{{ $tutor->id }}</td>
                    <td>{{ $tutor->nome }}</td>
                    <td>{{ $tutor->cpf_descriptografado }}</td>
                    <td>{{ $tutor->telefone }}</td>
                    <td>{{ $tutor->email }}</td>
                    <td class="d-flex gap-2">
                        <a href="{{ route('tutores.edit', $tutor) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('tutores.destroy', $tutor) }}" method="POST" onsubmit="return confirm('Deseja realmente excluir este tutor?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-3">Nenhum tutor encontrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection