<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'nom_utilisateur' => 'required|string',
            'password' => 'required|string',
        ]);

        // // Pour tester directement
        // $motDePasseClair = $request->password;
        // $motDePasseHash = Hash::make($motDePasseClair);

        // dd([
        //     'mot_de_passe_clair' => $motDePasseClair,
        //     'mot_de_passe_hash' => $motDePasseHash
        // ]);

        $user = Utilisateur::where('nom_utilisateur', $request->nom_utilisateur)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'nom_utilisateur' => 'Identifiants incorrects.',
            ])->onlyInput('nom_utilisateur');
        }
 
        Auth::login($user);

        $request->session()->regenerate();

        $role = $user->role_utilisateur->role ?? null;

        switch ($role) {
            case 'admin':
                return redirect()->route('ressources.index');
            case 'caisse':
                return redirect()->route('factures.index');
            case 'commercial':
                return redirect()->route('calendar.index');
            case 'dg':
                return redirect()->route('diagramme.stats');
            default:
                return redirect('/');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
