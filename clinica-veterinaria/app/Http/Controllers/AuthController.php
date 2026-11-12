<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credenciais = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Informe o e-mail.',
            'email.email' => 'Informe um e-mail válido.',
            'password.required' => 'Informe a senha.',
        ]);

        if (Auth::attempt($credenciais)) {
            $request->session()->regenerate();
            session(['ultima_atividade' => time()]);

            return redirect()->intended(route('dashboard'));
        }

        // Validação em caso de falha na autenticação (Critério 3.3)
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'E-mail ou senha inválidos. Verifique suas credenciais.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('sucesso', 'Você saiu do sistema com segurança.');
    }
}

