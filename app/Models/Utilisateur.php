<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Utilisateur
 * 
 * @property int $id
 * @property string $nom_utilisateur
 * @property string $password
 * @property string|null $token
 * @property int $id_role
 * 
 * @property RoleUtilisateur $role_utilisateur
 * @property Collection|Facture[] $factures
 * @property Collection|RecuOccasionnel[] $recu_occasionnels
 * @property Collection|Recu[] $recus
 * @property Collection|Reservation[] $reservations
 *
 * @package App\Models
 */
class Utilisateur extends Authenticatable
{
	protected $table = 'utilisateur';
	public $timestamps = false;

	protected $casts = [
		'id_role' => 'int'
	];

	protected $hidden = [
		'password',
		'token'
	];

	protected $fillable = [
		'nom_utilisateur',
		'password',
		'token',
		'id_role'
	];

	public function role_utilisateur()
	{
		return $this->belongsTo(RoleUtilisateur::class, 'id_role');
	}

	public function factures()
	{
		return $this->hasMany(Facture::class, 'id_creer_par');
	}

	public function recu_occasionnels()
	{
		return $this->hasMany(RecuOccasionnel::class, 'creer_par');
	}

	public function recus()
	{
		return $this->hasMany(Recu::class, 'creer_par');
	}

	public function reservations()
	{
		return $this->hasMany(Reservation::class, 'id_creer_par');
	}
}
