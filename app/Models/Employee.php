<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    protected $table = 'employees';
    use SoftDeletes;
    public $timestamps = false;

    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';
    const DELETED_AT = 'deleted_on';

   protected $fillable = [
        'nomor',
        'nama',
        'jabatan',
        'talahir',
        'photo_upload_path',
        'created_by',
        'updated_by'
    ];
}
