<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class VueChiffreAffaireMensuel
 * 
 * @property int|null $annee
 * @property int|null $mois
 * @property float|null $chiffre_affaire
 *
 * @package App\Models
 */
class VueChiffreAffaireMensuel extends Model
{
	protected $table = 'vue_chiffre_affaire_mensuel';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'annee' => 'int',
		'mois' => 'int',
		'chiffre_affaire' => 'float'
	];

	protected $fillable = [
		'annee',
		'mois',
		'chiffre_affaire'
	];
}
