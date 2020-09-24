<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modification extends Model
{
    protected $fillable = ['badge_number', 'field', 'old', 'new'];

    public $timestamps = false;

    public function item()
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'badge_number', 'badge_number');
    }
}
