<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Console\View\Components\Task;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $primaryKey = 'id';

    protected $fillable = [
        'code',
        'name',
        'username',
        'father_name',
        'company_name',
        'mother_name',
        'email',
        'role_id',
        'image',
        'gender',
        'dob',
        'status',
        'password',
        'fcm_token',
        'parent_id',
        'referral_id',
        'phone_number',
        'about',
        'hobbies',
        'Type',
    ];
    protected  $casts = [
        'hobbies' => 'array',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }


    public function address()
    {
        return $this->hasOne(Address::class);
    }
    public function media()
    {
        return $this->hasMany(Media::class);
    }
    public function professionalProfile()
    {
        return $this->hasOne(Professionalusers::class);
    }
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }
    public function user_steps()
    {
        return $this->hasMany(UserSteps::class);
    }

    public function bank()
    {
        return $this->hasOne(BankDetail::class);
    }

    public function kyc()
    {
        return $this->hasOne(Kyc::class);
    }

    public function children()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function lead()
    {
        return $this->hasMany(Leads::class);
    }

    public function task()
    {
        return $this->hasMany(Task::class);
    }

    public function package()
    {
        return $this->hasOne(Packages::class);
    }

    public function user_document()
    {
        return $this->hasMany(UserDocument::class);
    }

    public function camps()
    {
        return $this->hasMany(Camps::class, 'owner_id', 'id');
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y H:i A');
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y H:i A');
    }
}
