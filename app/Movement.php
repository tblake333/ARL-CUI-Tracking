<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $fillable = ['badge_number', 'type', 'location'];

    public $timestamps = false;

    public function item()
    {
        return $this->belongsTo(Item::class, 'barcode', 'barcode');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'badge_number', 'badge_number');
    }
}
