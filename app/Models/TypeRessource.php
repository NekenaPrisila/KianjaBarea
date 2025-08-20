<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TypeRessource
 * 
 * @property int $id
 * @property string $nom
 * @property string|null $description
 * 
 * @property Collection|Ressource[] $ressources
 *
 * @package App\Models
 */
class TypeRessource extends Model
{
	protected $table = 'type_ressource';
	public $timestamps = false;

	protected $fillable = [
		'nom',
		'description'
	];

	public function ressources()
	{
		return $this->hasMany(Ressource::class, 'id_type_ressource');
	}
}
