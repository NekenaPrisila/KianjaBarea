<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TarifsRessource
 * 
 * @property int $id
 * @property float $prix_unitaire
 * @property Carbon|null $date_saisie
 * @property int $id_unite_tarif
 * @property int $id_ressource
 * 
 * @property UniteTarif $unite_tarif
 * @property Ressource $ressource
 * @property Collection|RessourcesRecuOccasionnel[] $ressources_recu_occasionnels
 * @property Collection|RessourcesReservation[] $ressources_reservations
 *
 * @package App\Models
 */
class TarifsRessource extends Model
{
	protected $table = 'tarifs_ressources';
	public $timestamps = false;

	protected $casts = [
		'prix_unitaire' => 'float',
		'date_saisie' => 'datetime',
		'id_unite_tarif' => 'int',
		'id_ressource' => 'int'
	];

	protected $fillable = [
		'prix_unitaire',
		'date_saisie',
		'id_unite_tarif',
		'id_ressource'
	];

	public function unite_tarif()
	{
		return $this->belongsTo(UniteTarif::class, 'id_unite_tarif');
	}

	public function ressource()
	{
		return $this->belongsTo(Ressource::class, 'id_ressource');
	}

	public function ressources_recu_occasionnels()
	{
		return $this->hasMany(RessourcesRecuOccasionnel::class, 'id_tarif');
	}

	public function ressources_reservations()
	{
		return $this->hasMany(RessourcesReservation::class, 'id_tarif_ressource');
	}
}
