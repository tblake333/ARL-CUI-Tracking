<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Change extends Model
{
    protected $fillable = ['badge_number', 'field', 'old', 'new'];

    public $timestamps = false;
}
