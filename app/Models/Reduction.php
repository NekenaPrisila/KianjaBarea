<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Reduction
 * 
 * @property int $id
 * @property string|null $motif
 * @property float|null $valeur
 * @property int $id_reservation
 * @property string $reference_reservation
 * 
 * @property Reservation $reservation
 *
 * @package App\Models
 */
class Reduction extends Model
{
	protected $table = 'reductions';
	public $timestamps = false;

	protected $casts = [
		'valeur' => 'float',
		'id_reservation' => 'int'
	];

	protected $fillable = [
		'motif',
		'valeur',
		'id_reservation',
		'reference_reservation'
	];

	public function reservation()
	{
		return $this->belongsTo(Reservation::class, 'id_reservation')
					->where('reservations.id', '=', 'reductions.id_reservation')
					->where('reservations.reference', '=', 'reductions.reference_reservation');
	}
}
