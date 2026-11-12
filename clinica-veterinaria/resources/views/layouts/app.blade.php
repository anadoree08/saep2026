<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SisVet - Gestão de Clínica Veterinária</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    @auth
    <nav class="navbar navbar-expand-lg navbar-dark bg-success mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">🐾 SisVet</a>
            <div class="navbar-nav me-auto">
                <a class="nav-link" href="{{ route('dashboard') }}">Principal</a>
                <a class="nav-link" href="{{ route('tutores.index') }}">Tutores</a>
                <a class="nav-link" href="{{ route('pets.index') }}">Pets</a>
                <a class="nav-link" href="{{ route('agendamentos.index') }}">Agendamentos</a>
            </div>
            <div class="d-flex align-items-center text-white gap-3">
                <span>Olá, <strong>{{ Auth::user()->name }}</strong></span>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Sair</button>
                </form>
            </div>
        </div>
    </nav>
    @endauth

    <main class="container pb-5">
        @if(session('sucesso'))
            <div class="alert alert-success">{{ session('sucesso') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>