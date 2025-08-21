<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ressource
 * 
 * @property int $id
 * @property string $nom
 * @property float|null $caution
 * @property int|null $capacite
 * @property int $id_type_ressource
 * 
 * @property TypeRessource $type_ressource
 * @property Collection|RecuOccasionnel[] $recu_occasionnels
 * @property Collection|Reservation[] $reservations
 * @property Collection|TarifsRessource[] $tarifs_ressources
 *
 * @package App\Models
 */
class Ressource extends Model
{
	protected $table = 'ressources';
	public $timestamps = false;

	protected $casts = [
		'caution' => 'float',
		'capacite' => 'int',
		'id_type_ressource' => 'int'
	];

	protected $fillable = [
		'nom',
		'caution',
		'capacite',
		'id_type_ressource'
	];

	public function type_ressource()
	{
		return $this->belongsTo(TypeRessource::class, 'id_type_ressource');
	}

	public function recu_occasionnels()
	{
		return $this->belongsToMany(RecuOccasionnel::class, 'ressources_recu_occasionnel', 'id_ressource', 'id_recu')
					->withPivot('id_tarif', 'quantite', 'debut_utilisation', 'fin_utilisation');
	}

	public function reservations()
	{
		return $this->belongsToMany(Reservation::class, 'ressources_reservation', 'id_ressource', 'id_reservation')
					->withPivot('reference_reservation', 'id_tarif_ressource', 'quantite', 'debut_utilisation', 'fin_utilisation');
	}

	public function tarifs_ressources()
	{
		return $this->hasMany(TarifsRessource::class, 'id_ressource');
	}
}
