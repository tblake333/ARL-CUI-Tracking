<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $fillable = ['badge_number', 'type'];

    public $timestamps = false;
}
