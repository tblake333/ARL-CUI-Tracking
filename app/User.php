<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $primaryKey = 'badge_number';

    protected $fillable = ['badge_number', 'first_name', 'last_name'];

    public $timestamps = false;

    public $incrementing = false;

    public function item() {
        return $this->hasOne(Item::class, 'owner_badge_number', 'badge_number');
    }
}
