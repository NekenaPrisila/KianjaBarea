<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TarifsAccessoire
 * 
 * @property int $id
 * @property float $prix_unitaire
 * @property Carbon $date_saisie
 * @property int $id_unite_tarif
 * @property int $id_accessoire
 * 
 * @property UniteTarif $unite_tarif
 * @property Accessoire $accessoire
 * @property Collection|AccessoiresReservation[] $accessoires_reservations
 *
 * @package App\Models
 */
class TarifsAccessoire extends Model
{
	protected $table = 'tarifs_accessoires';
	public $timestamps = false;

	protected $casts = [
		'prix_unitaire' => 'float',
		'date_saisie' => 'datetime',
		'id_unite_tarif' => 'int',
		'id_accessoire' => 'int'
	];

	protected $fillable = [
		'prix_unitaire',
		'date_saisie',
		'id_unite_tarif',
		'id_accessoire'
	];

	public function unite_tarif()
	{
		return $this->belongsTo(UniteTarif::class, 'id_unite_tarif');
	}

	public function accessoire()
	{
		return $this->belongsTo(Accessoire::class, 'id_accessoire');
	}

	public function accessoires_reservations()
	{
		return $this->hasMany(AccessoiresReservation::class, 'id_tarif_accessoire');
	}
}
