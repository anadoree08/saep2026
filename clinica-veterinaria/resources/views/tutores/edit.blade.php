@extends('layouts.app')

@section('content')
<h3 class="mb-3">Editar Tutor</h3>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('tutores.update', $tutor) }}" method="POST" class="row g-3">
            @csrf
            @method('PUT')
            <div class="col-md-4">
                <label class="form-label">Nome Completo</label>
                <input type="text" name="nome" class="form-control" value="{{ $tutor->nome }}" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">CPF</label>
                <input type="text" name="cpf" class="form-control" value="{{ $tutor->cpf_descriptografado }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Telefone</label>
                <input type="text" name="telefone" class="form-control" value="{{ $tutor->telefone }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control" value="{{ $tutor->email }}" required>
            </div>
            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-success">Salvar Alterações</button>
                <a href="{{ route('tutores.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection