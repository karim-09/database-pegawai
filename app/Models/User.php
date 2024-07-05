<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
// use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    // use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'profile_photo_path',
        'role_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    // protected $appends = [
    //     'profile_photo_path',
    // ];

    protected $dates = ['deleted_at'];

    protected static function boot()
    {

        parent::boot();

        // updating created_by and updated_by when model is created
        static::creating(function ($model) {
            if (!$model->isDirty('created_by')) {
                $model->created_by = Auth()->user()->id ?? 1;
                $model->created_at = date('Y-m-d H:i:s');
            }
            if (!$model->isDirty('updated_by')) {
                $model->updated_by = NULL;
            }
        });

        // updating updated_by when model is updated
        static::updating(function ($model) {
            if (!$model->isDirty('updated_by')) {
                $model->updated_by = Auth()->user()->id ?? 1;
                $model->updated_at = date('Y-m-d H:i:s');
            }
        });

        // updating deleted_by when model is deleted
        // static::deleting(function ($model) {
        //     if (!$model->isDirty('deleted_by')) {
        //         $model->deleted_by = Auth()->user()->id;
        //     }
        // });

        // updating deleted_by when model is deleted
        static::softDeleted(function ($model) {
            $model->update([
                'deleted_by' => Auth()->user()->id ?? 1,
            ]);
        });
    }

    public function scopeIsNotAdmin($query)
    {
        return $query->where('role_id', '!=', 1);
    }
}
