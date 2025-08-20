<?php

namespace App\Http\Controllers;

use App\Models\RoleUtilisateur;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UtilisateurController extends Controller
{
    public function index()
    {
        $utilisateurs = Utilisateur::all();
        $roles = RoleUtilisateur::all();

        return view('utilisateurs.index', compact('utilisateurs', 'roles'));
    }

    public function create()
    {
        $roles = RoleUtilisateur::all();
        return view('utilisateurs.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_utilisateur' => 'required|string|max:255|unique:utilisateur,nom_utilisateur',
            'password' => 'required|string|min:6',
            'id_role' => 'required|exists:role_utilisateur,id',
        ]);

        Utilisateur::create([
            'nom_utilisateur' => $request->nom_utilisateur,
            'password' => Hash::make($request->password),
            'id_role' => $request->id_role,
        ]);

        return redirect()->route('utilisateurs.index')
                         ->with('success', 'Utilisateur créé avec succès !');
    }

    public function edit(Utilisateur $utilisateur)
    {
        $roles = RoleUtilisateur::all();
        return view('utilisateurs.create', compact('utilisateur', 'roles')); // même vue que create
    }

    public function update(Request $request, Utilisateur $utilisateur)
    {
        $request->validate([
            'nom_utilisateur' => 'required|string|max:255|unique:utilisateur,nom_utilisateur,' . $utilisateur->id,
            'password' => 'nullable|string',
            'id_role' => 'required|exists:role_utilisateur,id',
        ]);

        $data = [
            'nom_utilisateur' => $request->nom_utilisateur,
            'id_role' => $request->id_role,
        ];

        // mettre à jour le mot de passe seulement si rempli
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $utilisateur->update($data);

        return redirect()->route('utilisateurs.index')
                         ->with('success', 'Utilisateur mis à jour avec succès !');
    }

    public function destroy(Utilisateur $utilisateur)
    {
        $utilisateur->delete();

        return redirect()->route('utilisateurs.index')
                         ->with('success', 'Utilisateur supprimé avec succès !');
    }
}
