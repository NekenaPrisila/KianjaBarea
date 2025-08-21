<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AccessoiresRecuOccationnel
 * 
 * @property int $id_accessoire
 * @property int $id_tarif
 * @property int $id_recu
 * @property float $quantite
 * @property Carbon $debut_utilisation
 * @property Carbon $fin_utilisation
 * 
 * @property Accessoire $accessoire
 * @property TarifsAccessoire $tarifs_accessoire
 * @property RecuOccasionnel $recu_occasionnel
 *
 * @package App\Models
 */
class AccessoiresRecuOccationnel extends Model
{
	protected $table = 'accessoires_recu_occationnel';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_accessoire' => 'int',
		'id_tarif' => 'int',
		'id_recu' => 'int',
		'quantite' => 'float',
		'debut_utilisation' => 'datetime',
		'fin_utilisation' => 'datetime'
	];

	protected $fillable = [
		'quantite',
		'debut_utilisation',
		'fin_utilisation'
	];

	public function accessoire()
	{
		return $this->belongsTo(Accessoire::class, 'id_accessoire');
	}

	public function tarifs_accessoire()
	{
		return $this->belongsTo(TarifsAccessoire::class, 'id_tarif');
	}

	public function recu_occasionnel()
	{
		return $this->belongsTo(RecuOccasionnel::class, 'id_recu');
	}
}
