<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UniteTarif
 * 
 * @property int $id
 * @property string $nom
 * 
 * @property Collection|TarifsAccessoire[] $tarifs_accessoires
 * @property Collection|TarifsRessource[] $tarifs_ressources
 *
 * @package App\Models
 */
class UniteTarif extends Model
{
	protected $table = 'unite_tarif';
	public $timestamps = false;

	protected $fillable = [
		'nom'
	];

	public function tarifs_accessoires()
	{
		return $this->hasMany(TarifsAccessoire::class, 'id_unite_tarif');
	}

	public function tarifs_ressources()
	{
		return $this->hasMany(TarifsRessource::class, 'id_unite_tarif');
	}
}
