<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class VueRepartitionMensuelleReservation
 * 
 * @property int|null $annee
 * @property string|null $mois
 * @property int $nombre_reservations
 *
 * @package App\Models
 */
class VueRepartitionMensuelleReservation extends Model
{
	protected $table = 'vue_repartition_mensuelle_reservations';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'annee' => 'int',
		'nombre_reservations' => 'int'
	];

	protected $fillable = [
		'annee',
		'mois',
		'nombre_reservations'
	];
}
