<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RessourcesRecuOccasionnel
 * 
 * @property int $id_ressource
 * @property int $id_tarif
 * @property int $id_recu_occasionnel
 * @property string $reference_recu_occasionnel
 * @property float|null $quantite
 * @property Carbon $debut_utilisation
 * @property Carbon $fin_utilisation
 * 
 * @property Ressource $ressource
 * @property TarifsRessource $tarifs_ressource
 * @property RecuOccasionnel $recu_occasionnel
 *
 * @package App\Models
 */
class RessourcesRecuOccasionnel extends Model
{
	protected $table = 'ressources_recu_occasionnel';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_ressource' => 'int',
		'id_tarif' => 'int',
		'id_recu_occasionnel' => 'int',
		'quantite' => 'float',
		'debut_utilisation' => 'datetime',
		'fin_utilisation' => 'datetime'
	];

	protected $fillable = [
		'quantite',
		'debut_utilisation',
		'fin_utilisation'
	];

	public function ressource()
	{
		return $this->belongsTo(Ressource::class, 'id_ressource');
	}

	public function tarifs_ressource()
	{
		return $this->belongsTo(TarifsRessource::class, 'id_tarif');
	}

	public function recu_occasionnel()
	{
		return $this->belongsTo(RecuOccasionnel::class, 'id_recu_occasionnel')
					->where('recu_occasionnel.id', '=', 'ressources_recu_occasionnel.id_recu_occasionnel')
					->where('recu_occasionnel.reference', '=', 'ressources_recu_occasionnel.reference_recu_occasionnel');
	}
}
