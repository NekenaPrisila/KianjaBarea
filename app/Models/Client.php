<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Client
 * 
 * @property int $id
 * @property string $reference
 * @property string $nom
 * @property string $representant
 * @property string $telephone
 * @property string|null $email
 * @property string|null $adresse
 * @property Carbon $date_ajout
 * @property int $id_type_client
 * 
 * @property TypeClient $type_client
 * @property Collection|Reservation[] $reservations
 *
 * @package App\Models
 */
class Client extends Model
{
	protected $table = 'clients';
	public $timestamps = false;

	protected $casts = [
		'date_ajout' => 'datetime',
		'id_type_client' => 'int'
	];

	protected $fillable = [
		'nom',
		'representant',
		'telephone',
		'email',
		'adresse',
		'date_ajout',
		'id_type_client'
	];

	public function type_client()
	{
		return $this->belongsTo(TypeClient::class, 'id_type_client');
	}

	public function reservations()
	{
		return $this->hasMany(Reservation::class, 'id_client');
	}
}
