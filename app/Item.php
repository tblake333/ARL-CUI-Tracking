<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

/**
 * Model representing an item
 * 
 * @author Tristan Blake
 */
class Item extends Model
{
    protected $fillable = ['title', 'barcode', 'type', 'source', 'owner', 'source_date', 'location', 'description', 'keywords'];

    /**
     * Basic search function
     * 
     * Searches through all fields
     * 
     * @param string $value to be searched
     * 
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function search($value)
    {
        $builder = self::query();

        foreach (Schema::getColumnListing('items') as $field) {
            $builder->orWhere($field, 'like', '%' . $value . '%');
        }

        return $builder->get();
    }

    /**
     * Method to check-out item
     * 
     * @param App\User $user User checking item out
     * @param App\User $location New location where the item is going
     * 
     * @return void
     * 
     * @throws Exception if item is already checked-out
     */
    public function checkOut($user, $location)
    {
        if ($this->getStatus() === 'in') {
            $this->movements()->create([
                'badge_number' => $user->badge_number,
                'type' => 'out',
                'location' => $location
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
     * Get the latest user to either check-in or check-out this item.
     * 
     * Returns null if item has never been checked-out before
     * 
     * @return App\User|null
     */
    public function getLatestUser()
    {
        $latestMovement = $this->movements()->latest('id')->first();

        return $latestMovement ? $latestMovement->user : null;
    }

    /**
     * Get the current location of this item.
     * 
     * Returns the default location assigned to this item if it is checked-in,
     * returns the location entered when checking out the item if it is checked-out.
     * 
     * @return String
     */
    public function getCurrentLocation()
    {
        $latestMovement = $this->movements()->latest('id')->first();

        $isCheckedOut = $latestMovement && $latestMovement->type === 'out';

        return $isCheckedOut ? $latestMovement->location : $this->location;
    }

    public function getGroupedModifications()
    {
        $result = [];

        $modifications = $this->modifications;
        foreach ($modifications as $modification) {

            // In order to ensure that a group of modifications is associated with one user at a particular time,
            // the key to the associative array is the timestamp concatenated with '_' and the badge number
            $key = $modification->time . '_' . $modification->badge_number;

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

    public function modifications()
    {
        return $this->hasMany(Modification::class, 'item_id', 'id');
    }
}
