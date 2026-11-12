<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificarExpiracaoSessao
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $tempoMaximoSegundos = 15 * 60; // 15 minutos de inatividade
            $ultimaAtividade = session('ultima_atividade');

            if ($ultimaAtividade && (time() - $ultimaAtividade > $tempoMaximoSegundos)) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->withErrors(['email' => 'Sua sessão expirou por inatividade (15 minutos). Faça login novamente.']);
            }

            session(['ultima_atividade' => time()]);
        }

        return $next($request);
    }
}