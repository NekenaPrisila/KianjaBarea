<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RessourcesReservation
 * 
 * @property int $id_reservation
 * @property string $reference_reservation
 * @property int $id_tarif_ressource
 * @property int $id_ressource
 * @property float $quantite
 * @property Carbon|null $debut_utilisation
 * @property Carbon|null $fin_utilisation
 * 
 * @property Reservation $reservation
 * @property TarifsRessource $tarifs_ressource
 * @property Ressource $ressource
 *
 * @package App\Models
 */
class RessourcesReservation extends Model
{
	protected $table = 'ressources_reservation';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_reservation' => 'int',
		'id_tarif_ressource' => 'int',
		'id_ressource' => 'int',
		'quantite' => 'float',
		'debut_utilisation' => 'datetime',
		'fin_utilisation' => 'datetime'
	];

	protected $fillable = [
		'quantite',
		'debut_utilisation',
		'fin_utilisation'
	];

	public function reservation()
	{
		return $this->belongsTo(Reservation::class, 'id_reservation')
					->where('reservations.id', '=', 'ressources_reservation.id_reservation')
					->where('reservations.reference', '=', 'ressources_reservation.reference_reservation');
	}

	public function tarifs_ressource()
	{
		return $this->belongsTo(TarifsRessource::class, 'id_tarif_ressource');
	}

	public function ressource()
	{
		return $this->belongsTo(Ressource::class, 'id_ressource');
	}
}
