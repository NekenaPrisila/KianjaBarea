<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TypePaiement
 * 
 * @property int $id
 * @property string $nom
 * 
 * @property Collection|Facture[] $factures
 *
 * @package App\Models
 */
class TypePaiement extends Model
{
	protected $table = 'type_paiement';
	public $timestamps = false;

	protected $fillable = [
		'nom'
	];

	public function factures()
	{
		return $this->hasMany(Facture::class, 'id_type_paiement');
	}
}
