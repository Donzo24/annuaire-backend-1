<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pay
 * 
 * @property int $id_pays
 * @property string $nom
 * @property string|null $code_pays
 * 
 * @property Collection|Utilisateur[] $utilisateurs
 *
 * @package App\Models
 */
class Pay extends Model
{
	protected $table = 'pays';
	protected $primaryKey = 'id_pays';
	public $timestamps = false;

	protected $fillable = [
		'nom',
		'code_pays'
	];

	public function utilisateurs()
	{
		return $this->hasMany(Utilisateur::class, 'id_pays');
	}
}
