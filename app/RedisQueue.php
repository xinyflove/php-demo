<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RedisQueue extends Model
{
    protected $table = 'redis_queue';
    protected $guarded = [];
    public $timestamps = false;
}
