<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class VueEtatPaiement
 * 
 * @property int $id
 * @property string $reference
 * @property float|null $cout_total
 * @property float|null $total_paye
 * @property float|null $reste_a_payer
 * @property string $etat_paiement
 *
 * @package App\Models
 */
class VueEtatPaiement extends Model
{
	protected $table = 'vue_etat_paiement';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'cout_total' => 'float',
		'total_paye' => 'float',
		'reste_a_payer' => 'float'
	];

	protected $fillable = [
		'id',
		'reference',
		'cout_total',
		'total_paye',
		'reste_a_payer',
		'etat_paiement'
	];
}
