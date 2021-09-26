<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\PersonalAccessToken;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class Utilisateur
 * 
 * @property int $id_utilisateur
 * @property string $nom_utilisateur
 * @property string $nom
 * @property string $prenom
 * @property Carbon $date_de_naissance
 * @property string $sexe
 * @property string $email
 * @property string|null $telephone
 * @property Carbon|null $date_de_creation
 * @property Carbon|null $date_de_modification
 * @property bool|null $statut
 * @property Carbon|null $date_de_desactivation
 * @property string|null $url_photo
 * @property string $password
 * 
 * @property Collection|Profil[] $profils
 * @property Collection|Role[] $roles
 *
 * @package App\Models
 */
class Utilisateur extends Authenticatable implements JWTSubject
{

	// use HasApiTokens, HasFactory, Notifiable;
	use HasFactory, Notifiable;

	protected $table = 'utilisateur';
	protected $primaryKey = 'id_utilisateur';
	public $timestamps = false;

	protected $casts = [
		'statut' => 'bool'
	];

	protected $dates = [
		'date_de_naissance',
		'date_de_creation',
		'date_de_modification',
		'date_de_desactivation'
	];

	protected $hidden = [
		'password',
		'api_token'
	];

	protected $fillable = [
		'nom_utilisateur',
		'nom',
		'prenom',
		'date_de_naissance',
		'sexe',
		'email',
		'telephone',
		'date_de_creation',
		'date_de_modification',
		'statut',
		'date_de_desactivation',
		'url_photo',
		'password',
		'api_token',
		'code_sms',
		'date_code_sms',
		'ville',
		'id_pays',
		'id_profil'
	];

	public function pays()
	{
		return $this->belongsTo(Pays::class, 'id_pays');
	}

	public function profil()
	{
		return $this->belongsTo(Profil::class, 'id_profil');
	}

	public function roles()
	{
		return $this->belongsToMany(Role::class, 'utilisateur_role', 'id_utilisateur', 'id_role');
	}

	public function langues()
	{
		return $this->belongsToMany(Langue::class, 'utilisateur_langue', 'id_utilisateur', 'id_langue')->withPivot('niveau');
	}

	public function refreshToken()
	{
		$token = Str::random(60);

		$this->update(['api_token' => $token]);

		return $token;
	}


    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }    
}
