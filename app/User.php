<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $primaryKey = 'badge_number';

    protected $fillable = ['badge_number', 'first_name', 'last_name'];

    public $timestamps = false;

    public $incrementing = false;

    public function items()
    {
        return $this->hasMany(Item::class, 'owner_badge_number', 'badge_number');
    }

    public function movements()
    {
        return $this->hasMany(Movement::class, 'badge_number', 'badge_number');
    }

    public function modifications()
    {
        return $this->hasMany(Modification::class, 'badge_number', 'badge_number');
    }

    /**
     * Get list of all items currently checked out by the user.
     * 
     * If there are no items currently checked out by the user, returns an empty list.
     * 
     * @return Illuminate\Database\Eloquent\Collection containing Items that are checked out by the user
     */
    public function getCheckedOutItems()
    {
        $items = $this->movements()->select('barcode')
                                   ->groupBy('barcode')
                                   ->havingRaw('COUNT(barcode) % 2 <> 0')
                                   ->get()
                                   ->map(function($movement) {
                                       return $movement->item;
                                   });
        return $items;
    }

    public function getGroupedModifications()
    {
        $result = [];

        $modifications = $this->modifications;
        foreach ($modifications as $modification) {

            // In order to ensure that a group of modifications is associated with one item at a particular time,
            // the key to the associative array is the timestamp concatenated with '_' and the item id
            $key = $modification->time . '_' . $modification->item_id;

            if (array_key_exists($key, $result)) {

                // Add modification to group of modifications that occurred at the same time
                $result[$key][] = $modification;

            } else {
                // $modificationCollection is null
                $result[$key] = [$modification];
            }
            
        }

        return $result;
    }
}
