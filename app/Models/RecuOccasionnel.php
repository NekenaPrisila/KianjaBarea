<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RecuOccasionnel
 * 
 * @property int $id
 * @property Carbon|null $date_edition
 * @property string $motif
 * 
 * @property Collection|AccessoiresRecuOccationnel[] $accessoires_recu_occationnels
 * @property Collection|Ressource[] $ressources
 *
 * @package App\Models
 */
class RecuOccasionnel extends Model
{
	protected $table = 'recu_occasionnel';
	public $timestamps = false;

	protected $casts = [
		'date_edition' => 'datetime'
	];

	protected $fillable = [
		'date_edition',
		'motif'
	];

	public function accessoires_recu_occationnels()
	{
		return $this->hasMany(AccessoiresRecuOccationnel::class, 'id_recu');
	}

	public function ressources()
	{
		return $this->belongsToMany(Ressource::class, 'ressources_recu_occasionnel', 'id_recu', 'id_ressource')
					->withPivot('id_tarif', 'quantite', 'debut_utilisation', 'fin_utilisation');
	}
}
