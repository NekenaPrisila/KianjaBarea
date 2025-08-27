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
 * @property string $reference
 * @property Carbon|null $date_edition
 * @property string $motif
 * @property string|null $reference_paiement
 * @property float|null $cout_total
 * @property int $creer_par
 * @property int $id_mode_paiement
 * 
 * @property Utilisateur $utilisateur
 * @property ModePaiement $mode_paiement
 * @property Collection|Accessoire[] $accessoires
 * @property Collection|Ressource[] $ressources
 *
 * @package App\Models
 */
class RecuOccasionnel extends Model
{
	protected $table = 'recu_occasionnel';
	public $timestamps = false;

	protected $casts = [
		'date_edition' => 'datetime',
		'cout_total' => 'float',
		'creer_par' => 'int',
		'id_mode_paiement' => 'int'
	];

	protected $fillable = [
		'date_edition',
		'motif',
		'reference_paiement',
		'cout_total',
		'creer_par',
		'id_mode_paiement'
	];

	public function utilisateur()
	{
		return $this->belongsTo(Utilisateur::class, 'creer_par');
	}

	public function mode_paiement()
	{
		return $this->belongsTo(ModePaiement::class, 'id_mode_paiement');
	}

	public function accessoires()
	{
		return $this->belongsToMany(Accessoire::class, 'accessoires_recu_occasionnel', 'id_recu_occasionnel', 'id_accessoires')
					->withPivot('id_tarif', 'reference_recu_occasionnel', 'quantite', 'debut_utilisation', 'fin_utilisation');
	}

	public function ressources()
	{
		return $this->belongsToMany(Ressource::class, 'ressources_recu_occasionnel', 'id_recu_occasionnel', 'id_ressource')
					->withPivot('id_tarif', 'reference_recu_occasionnel', 'quantite', 'debut_utilisation', 'fin_utilisation');
	}
}
