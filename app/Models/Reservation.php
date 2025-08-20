<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Reservation
 * 
 * @property int $id
 * @property string $reference
 * @property string $description
 * @property Carbon $date_premier_jour
 * @property Carbon $date_dernier_jour
 * @property Carbon|null $date_creation
 * @property float|null $cout_total
 * @property int $id_creer_par
 * @property int $id_client
 * @property string $reference_client
 * 
 * @property Utilisateur $utilisateur
 * @property Client $client
 * @property Collection|Accessoire[] $accessoires
 * @property Collection|Facture[] $factures
 * @property Collection|Reduction[] $reductions
 * @property Collection|Ressource[] $ressources
 *
 * @package App\Models
 */
class Reservation extends Model
{
	protected $table = 'reservations';
	public $timestamps = false;

	protected $casts = [
		'date_premier_jour' => 'datetime',
		'date_dernier_jour' => 'datetime',
		'date_creation' => 'datetime',
		'cout_total' => 'float',
		'id_creer_par' => 'int',
		'id_client' => 'int'
	];

	protected $fillable = [
		'description',
		'date_premier_jour',
		'date_dernier_jour',
		'date_creation',
		'cout_total',
		'id_creer_par',
		'id_client',
		'reference_client'
	];

	public function utilisateur()
	{
		return $this->belongsTo(Utilisateur::class, 'id_creer_par');
	}

	public function client()
	{
		return $this->belongsTo(Client::class, 'id_client');
	}

	public function accessoires()
	{
		return $this->belongsToMany(Accessoire::class, 'accessoires_reservation', 'id_reservation', 'id_accessoire')
					->withPivot('reference_reservation', 'id_tarif_accessoire', 'quantite', 'debut_utilisation', 'fin_utilisation');
	}

	public function factures()
	{
		return $this->hasMany(Facture::class, 'id_reservation');
	}

	public function reductions()
	{
		return $this->hasMany(Reduction::class, 'id_reservation');
	}

	public function ressources()
	{
		return $this->belongsToMany(Ressource::class, 'ressources_reservation', 'id_reservation', 'id_ressource')
					->withPivot('reference_reservation', 'id_tarif_ressource', 'quantite', 'debut_utilisation', 'fin_utilisation');
	}

	public function statutPaiement()
	{
		return $this->hasOne(VueReservationsStatutPaiement::class, 'reservation_id', 'id');
	}

	public function etatPaiement()
	{
		return $this->hasOne(VueEtatPaiement::class, 'id', 'id'); // 'id' = clé primaire de Reservation
	}

	public function getSommeReductions()
	{
		return $this->reductions->sum('valeur');
	}

}
