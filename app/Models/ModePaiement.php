<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ModePaiement
 * 
 * @property int $id
 * @property string $nom
 * 
 * @property Collection|Recu[] $recus
 *
 * @package App\Models
 */
class ModePaiement extends Model
{
	protected $table = 'mode_paiement';
	public $timestamps = false;

	protected $fillable = [
		'nom'
	];

	public function recus()
	{
		return $this->hasMany(Recu::class, 'id_mode_paiement');
	}
}
