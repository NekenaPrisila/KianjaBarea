<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TypeClient
 * 
 * @property int $id
 * @property string $nom
 * 
 * @property Collection|Client[] $clients
 *
 * @package App\Models
 */
class TypeClient extends Model
{
	protected $table = 'type_client';
	public $timestamps = false;

	protected $fillable = [
		'nom'
	];

	public function clients()
	{
		return $this->hasMany(Client::class, 'id_type_client');
	}
}
