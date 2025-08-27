<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Accessoire
 * 
 * @property int $id
 * @property string $nom
 * @property int|null $nombre_disponible
 * 
 * @property Collection|RecuOccasionnel[] $recu_occasionnels
 * @property Collection|Reservation[] $reservations
 * @property Collection|TarifsAccessoire[] $tarifs_accessoires
 *
 * @package App\Models
 */
class Accessoire extends Model
{
	protected $table = 'accessoires';
	public $timestamps = false;

	protected $casts = [
		'nombre_disponible' => 'int'
	];

	protected $fillable = [
		'nom',
		'nombre_disponible'
	];

	public function recu_occasionnels()
	{
		return $this->belongsToMany(RecuOccasionnel::class, 'accessoires_recu_occasionnel', 'id_accessoires', 'id_recu_occasionnel')
					->withPivot('id_tarif', 'quantite', 'debut_utilisation', 'fin_utilisation');
	}

	public function reservations()
	{
		return $this->belongsToMany(Reservation::class, 'accessoires_reservation', 'id_accessoire', 'id_reservation')
					->withPivot('reference_reservation', 'id_tarif_accessoire', 'quantite', 'debut_utilisation', 'fin_utilisation');
	}

	public function tarifs_accessoires()
	{
		return $this->hasMany(TarifsAccessoire::class, 'id_accessoire');
	}
}
