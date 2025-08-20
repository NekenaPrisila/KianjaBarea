<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RoleUtilisateur
 * 
 * @property int $id
 * @property string $role
 * 
 * @property Collection|Utilisateur[] $utilisateurs
 *
 * @package App\Models
 */
class RoleUtilisateur extends Model
{
	protected $table = 'role_utilisateur';
	public $timestamps = false;

	protected $fillable = [
		'role'
	];

	public function utilisateurs()
	{
		return $this->hasMany(Utilisateur::class, 'id_role');
	}
}
