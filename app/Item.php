<?php

namespace App;

use App\Events\ItemEditedEvent;
use Exception;
use Illuminate\Database\Eloquent\Model;

/**
 * Model representing an item
 * 
 * @author Tristan Blake
 */
class Item extends Model
{
    protected $fillable = ['title', 'barcode', 'type', 'source', 'owner', 'source_date', 'location', 'description', 'keywords'];

    /**
     * Method to check-out item
     * 
     * @param App\User $user User checking item out
     * 
     * @return void
     * 
     * @throws Exception if item is already checked-out
     */
    public function checkOut($user)
    {
        if ($this->getStatus() === 'in') {
            $this->movements()->create([
                'badge_number' => $user->badge_number,
                'type' => 'out'
            ]);
        } else {
            // Item is already checked-out, so check-out request cannot take place
            throw new Exception('Item is already checked out');
        }
    }

    /**
     * Method to check-in item
     * 
     * @return void
     * 
     * @throws Exception if item is already checked-in
     */
    public function checkIn()
    {
        $latestMovement = $this->movements()->latest('id')->first();

        $user = User::find($latestMovement->badge_number);

        if ($this->getStatus() === 'out') {
            $this->movements()->create([
                'badge_number' => $user->badge_number,
                'type' => 'in'
            ]);
        } else {
            // Item is already checked-in, so check-in request cannot take place
            throw new Exception('Item is already checked in');
        }
    }

    /**
     * Get the current status of the item.
     * 
     * @return string Status of item. Either 'in' or 'out'
     */
    public function getStatus()
    {
        $latestMovement = $this->movements()->latest('id')->first();

        // If latest movement not found, item has never been checked out, so it is considered to be 'in'
        return $latestMovement ? $latestMovement->type : 'in';
    }

    /**
     * Function that handles owner input upon creating an item.
     * 
     * This function is called as soon as an instance of this model is created that contains the required 'owner' attribute.
     * The 'owner' attribute is the parameter passed into this function and should be an array containing owner data.
     * 
     * If owner is a new user, badge_number, first_name, and last_name should be present in the array passed into the 
     * model's 'owner' attribute.
     * 
     * Ex.
     * $owner = [
     *      'badge_number' =  8911,
     *      'first_name'   = 'John',
     *      'last_name'    = 'Doe'
     * ]
     * 
     * If owner is an existing user, only the badge_number should be present in the array passed into the model's 'owner'
     * attribute.
     * 
     * Ex.
     * $owner = [
     *      'badge_number' = 8911
     * ]
     * 
     * Note: This method should never be explicitly called and is called automatically by Laravel when creating an item model.
     * 
     * 
     * @param array $owner containing badge number and, if new user, first and last name
     * 
     * @return void
     */
    public function setOwnerAttribute($owner)
    {
        // Finds user corresponding to owner's badge number, or creates new user based on owner data
        $user = User::firstOrCreate($owner);

        $this->attributes['owner_badge_number'] = $user->badge_number;
    }

    
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_badge_number', 'badge_number');
    }

    public function movements()
    {
        return $this->hasMany(Movement::class, 'barcode', 'barcode');
    }

    public function changes()
    {
        return $this->hasMany(Change::class, 'item_id', 'id');
    }
}
