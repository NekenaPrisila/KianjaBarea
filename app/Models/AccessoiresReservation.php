<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AccessoiresReservation
 * 
 * @property int $id_reservation
 * @property string $reference_reservation
 * @property int $id_accessoire
 * @property int $id_tarif_accessoire
 * @property int $quantite
 * @property Carbon|null $debut_utilisation
 * @property Carbon|null $fin_utilisation
 * 
 * @property Reservation $reservation
 * @property Accessoire $accessoire
 * @property TarifsAccessoire $tarifs_accessoire
 *
 * @package App\Models
 */
class AccessoiresReservation extends Model
{
	protected $table = 'accessoires_reservation';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_reservation' => 'int',
		'id_accessoire' => 'int',
		'id_tarif_accessoire' => 'int',
		'quantite' => 'int',
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
					->where('reservations.id', '=', 'accessoires_reservation.id_reservation')
					->where('reservations.reference', '=', 'accessoires_reservation.reference_reservation');
	}

	public function accessoire()
	{
		return $this->belongsTo(Accessoire::class, 'id_accessoire');
	}

	public function tarifs_accessoire()
	{
		return $this->belongsTo(TarifsAccessoire::class, 'id_tarif_accessoire');
	}
}
