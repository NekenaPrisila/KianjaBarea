<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Recu
 * 
 * @property int $id
 * @property string $reference
 * @property Carbon $date_edition
 * @property int $id_mode_paiement
 * @property int $id_facture
 * @property string $reference_facture
 * @property int $creer_par
 * 
 * @property ModePaiement $mode_paiement
 * @property Facture $facture
 * @property Utilisateur $utilisateur
 *
 * @package App\Models
 */
class Recu extends Model
{
	protected $table = 'recus';
	public $timestamps = false;

	protected $casts = [
		'date_edition' => 'datetime',
		'id_mode_paiement' => 'int',
		'id_facture' => 'int',
		'creer_par' => 'int'
	];

	protected $fillable = [
		'date_edition',
		'id_mode_paiement',
		'id_facture',
		'reference_facture',
		'creer_par',
		'reference_paiement'
	];

	public function mode_paiement()
	{
		return $this->belongsTo(ModePaiement::class, 'id_mode_paiement');
	}

	public function facture()
	{
		return $this->belongsTo(Facture::class, 'id_facture');
	}

	public function utilisateur()
	{
		return $this->belongsTo(Utilisateur::class, 'creer_par');
	}
}
