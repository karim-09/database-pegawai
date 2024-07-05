<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
    protected $table = 'modules';
    protected $primaryKey = 'modulekode';
    protected $fillable = [
                'modulekode',
                'modulename',
                'moduledesk',
                'moduleurl',
                'moduleicon',
                'modulesort',
                'created_at',
                'updated_at',
            ];
    public $timestamps = true;
    public $incrementing = false;
}
