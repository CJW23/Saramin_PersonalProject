<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AccessUrl extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'url_id',
        'before_url'
    ];
}
