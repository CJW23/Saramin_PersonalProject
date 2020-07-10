<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
 * 원본 url, 단축 url 저장할 모델
 * */
class Url extends Model
{
    protected $fillable = [
        'user_id', 'original_url', 'short_url', 'query_string',
    ];
}