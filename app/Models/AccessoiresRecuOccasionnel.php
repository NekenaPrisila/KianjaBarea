<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AccessoiresRecuOccasionnel
 * 
 * @property int $id_accessoires
 * @property int $id_tarif
 * @property int $id_recu_occasionnel
 * @property string $reference_recu_occasionnel
 * @property int $quantite
 * @property Carbon $debut_utilisation
 * @property Carbon $fin_utilisation
 * 
 * @property Accessoire $accessoire
 * @property TarifsAccessoire $tarifs_accessoire
 * @property RecuOccasionnel $recu_occasionnel
 *
 * @package App\Models
 */
class AccessoiresRecuOccasionnel extends Model
{
	protected $table = 'accessoires_recu_occasionnel';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_accessoires' => 'int',
		'id_tarif' => 'int',
		'id_recu_occasionnel' => 'int',
		'quantite' => 'int',
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
		return $this->belongsTo(Accessoire::class, 'id_accessoires');
	}

	public function tarifs_accessoire()
	{
		return $this->belongsTo(TarifsAccessoire::class, 'id_tarif');
	}

	public function recu_occasionnel()
	{
		return $this->belongsTo(RecuOccasionnel::class, 'id_recu_occasionnel')
					->where('recu_occasionnel.id', '=', 'accessoires_recu_occasionnel.id_recu_occasionnel')
					->where('recu_occasionnel.reference', '=', 'accessoires_recu_occasionnel.reference_recu_occasionnel');
	}
}
