<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Dept extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'depts';
    protected $primaryKey = 'deptcode';
    protected $fillable = [
                'deptcode',
                'deptname',
                'deptemail',
                'depttelp',
                'deptaddress',
                'created_by',
                'updated_by',
                'deleted_by',
                'created_at',
                'updated_at',
                'deleted_at',
            ];
    public $timestamps = false;
    public $incrementing = false;
    protected $dates = ['deleted_at'];

    protected static function boot()
    {

        parent::boot();

        // updating created_by and updated_by when model is created
        static::creating(function ($model) {
            if (!$model->isDirty('created_by')) {
                $model->created_by = Auth()->user()->id;
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
                'deleted_by' => Auth()->user()->id,
            ]);
        });
    }
}
