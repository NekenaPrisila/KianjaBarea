<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Facture
 * 
 * @property int $id
 * @property string $reference
 * @property Carbon $date_edition
 * @property float|null $montant_paye
 * @property float|null $reste_a_payer
 * @property int $id_type_paiement
 * @property int $id_reservation
 * @property string $reference_reservation
 * @property int $id_creer_par
 * 
 * @property TypePaiement $type_paiement
 * @property Reservation $reservation
 * @property Utilisateur $utilisateur
 * @property Collection|Recu[] $recus
 *
 * @package App\Models
 */
class Facture extends Model
{
	protected $table = 'facture';
	public $timestamps = false;

	protected $casts = [
		'date_edition' => 'datetime',
		'montant_paye' => 'float',
		'reste_a_payer' => 'float',
		'id_type_paiement' => 'int',
		'id_reservation' => 'int',
		'id_creer_par' => 'int'
	];

	protected $fillable = [
		'date_edition',
		'montant_paye',
		'reste_a_payer',
		'id_type_paiement',
		'id_reservation',
		'reference_reservation',
		'id_creer_par'
	];

	public function type_paiement()
	{
		return $this->belongsTo(TypePaiement::class, 'id_type_paiement');
	}

	public function reservation()
	{
		return $this->belongsTo(Reservation::class, 'id_reservation');
	}

	public function utilisateur()
	{
		return $this->belongsTo(Utilisateur::class, 'id_creer_par');
	}

	public function recus()
	{
		return $this->hasMany(Recu::class, 'id_facture');
	}

	public static function getResteAPayerParReservation($reservationId)
    {
        return self::where('id_reservation', $reservationId)
                   ->orderByDesc('date_edition') // pour prendre la dernière facture si plusieurs
                   ->value('reste_a_payer');
    }

	public static function getTotalMontantPaye($reservationId)
	{
		return self::where('id_reservation', $reservationId)
				->sum('montant_paye');
	}
}
