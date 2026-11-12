@extends('layouts.app')

@section('content')
<h3 class="mb-3">Gerenciamento de Agendamentos</h3>

<div class="card shadow-sm mb-4">
    <div class="card-header fw-bold">Novo Agendamento</div>
    <div class="card-body">
        <form action="{{ route('agendamentos.store') }}" method="POST" class="row g-3">
            @csrf
            <div class="col-md-3">
                <label class="form-label">Tutor</label>
                <select name="tutor_id" class="form-select" required>
                    <option value="">Selecione...</option>
                    @foreach($tutores as $tutor)
                        <option value="{{ $tutor->id }}">{{ $tutor->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Pet</label>
                <select name="pet_id" class="form-select" required>
                    <option value="">Selecione...</option>
                    @foreach($pets as $pet)
                        <option value="{{ $pet->id }}">{{ $pet->nome }} (Tutor: {{ $pet->tutor->nome }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Data</label>
                <input type="date" name="data_agendamento" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Hora</label>
                <input type="time" name="hora_agendamento" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Serviço</label>
                <input type="text" name="servico" class="form-control" placeholder="Consulta / Vacina" required>
            </div>
            <div class="col-12">
                <label class="form-label">Observação</label>
                <input type="text" name="observacao" class="form-control">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-success">Agendar</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header fw-bold">Agendamentos Cadastrados (Ordenados por Data)</div>
    <div class="table-responsive">
        <table class="table table-striped mb-0 align-middle">
            <thead>
                <tr>
                    <th>Data / Hora</th>
                    <th>Serviço / Status</th>
                    <th>Dados do Tutor</th>
                    <th>Dados do Pet</th>
                    <th>Atualizar Data</th>
                </tr>
            </thead>
            <tbody>
                @forelse($agendamentos as $agendamento)
                <tr>
                    <td>
                        <strong>{{ date('d/m/Y', strtotime($agendamento->data_agendamento)) }}</strong><br>
                        <small class="text-muted">{{ substr($agendamento->hora_agendamento, 0, 5) }}</small>
                    </td>
                    <td>
                        {{ $agendamento->servico }}<br>
                        <span class="badge bg-info text-dark">{{ $agendamento->status }}</span>
                        @if($agendamento->observacao)
                            <br><small class="text-muted">{{ $agendamento->observacao }}</small>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $agendamento->tutor->nome }}</strong><br>
                        <small>CPF: {{ $agendamento->tutor->cpf_descriptografado }}</small><br>
                        <small>Tel: {{ $agendamento->tutor->telefone }} | {{ $agendamento->tutor->email }}</small>
                    </td>
                    <td>
                        <strong>{{ $agendamento->pet->nome }}</strong> ({{ $agendamento->pet->especie }})<br>
                        <small>Raça: {{ $agendamento->pet->raca ?? 'Não informada' }}</small><br>
                        <small>Nasc.: {{ $agendamento->pet->data_nascimento ? date('d/m/Y', strtotime($agendamento->pet->data_nascimento)) : '-' }}</small>
                    </td>
                    <td>
                        <form action="{{ route('agendamentos.updateData', $agendamento) }}" method="POST" class="d-flex gap-1">
                            @csrf
                            @method('PATCH')
                            <input type="date" name="data_agendamento" value="{{ $agendamento->data_agendamento }}" class="form-control form-control-sm" required>
                            <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-3">Nenhum agendamento cadastrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection