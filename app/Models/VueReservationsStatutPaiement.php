<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VueReservationsStatutPaiement
 * 
 * @property int $reservation_id
 * @property string $reservation_reference
 * @property string $statut_paiement
 * @property Carbon|null $date_confirmation
 *
 * @package App\Models
 */
class VueReservationsStatutPaiement extends Model
{
	protected $table = 'vue_reservations_statut_paiement';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'reservation_id' => 'int',
		'date_confirmation' => 'datetime'
	];

	protected $fillable = [
		'reservation_id',
		'reservation_reference',
		'statut_paiement',
		'date_confirmation'
	];
}
