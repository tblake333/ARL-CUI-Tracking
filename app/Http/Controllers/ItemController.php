<?php

namespace App\Http\Controllers;

use App\Events\ItemEditedEvent;
use App\Item;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();

        return view('item.index', compact('items'));
    }

    public function create()
    {
        $item = new Item();

        return view('item.create', compact('item'));
    }

    public function store()
    {
        $data = $this->validatedData();

        Item::create($data);

        return redirect('/items');
    }

    public function show(Item $item)
    {
        return view('item.show', compact('item'));
    }

    public function edit(Item $item)
    {
        return view('item.edit', compact('item'));
    }

    public function update(Item $item)
    {
        $data = $this->validatedData($item);
        $item->fill($data);
        
        $userData = $data['edited_by'];
        $user = User::firstOrCreate($userData);

        // Dispatch item edited event to track changes
        event(new ItemEditedEvent($item, $user));
        
        $item->save();

        return redirect('/items');
    }

    public function search()
    {
        return view('item.search');
    }

    public function withQuery()
    {
        $request = request()->validate(['query' => 'required']);
        return redirect()->to('/items/results/' . $request['query']);
    }

    public function results($query)
    {
        $results = Item::search($query);

        return view('item.results', compact('results'));
    }

    protected function validatedData(Item $item = null)
    {
        $request = request();

        $ownerBadgeNumber = $request->owner ? $request->owner['badge_number'] : null;
        $editedByBadgeNumber = $request->edited_by ? $request->edited_by['badge_number'] : null;

        $rules = [
            'title' => 'required|max:30',
            'barcode' => 'required|max:10|unique:items,barcode',
            'type' => 'required|max:30',
            'owner.badge_number' => 'required|integer|digits_between:1,6',
            'owner.first_name' => [$this->requiredIfNewUser($ownerBadgeNumber), 'max:70'],
            'owner.last_name' => [$this->requiredIfNewUser($ownerBadgeNumber), 'max:70'],
            'source' => 'max:30',
            'source_date' => 'nullable|date_format:Y-m-d',
            'location' => 'required|max:30',
            'description' => 'max:250',
            'keywords' => 'max:40'
        ];

        if ($item) {
            $rules['barcode'] = $rules['barcode'] . ',' . $item->id;
            $rules['edited_by.badge_number'] = 'required|integer|digits_between:1,6';
            $rules['edited_by.first_name'] = [$this->requiredIfNewUser($editedByBadgeNumber), 'max:70'];
            $rules['edited_by.last_name'] = [$this->requiredIfNewUser($editedByBadgeNumber), 'max:70'];
        }

        return request()->validate($rules);
    }

    /**
     * Returns RequiredIf Rule if badge number corresponds to a new user.
     * 
     * @param int $badgeNumber
     * 
     * @return \Illuminate\Validation\Rules\RequiredIf
     */
    private function requiredIfNewUser($badgeNumber)
    {
        return Rule::requiredIf(function () use ($badgeNumber) {
            return $this->isNewUser($badgeNumber);
        });
    }

    private function isNewUser($badgeNumber)
    {
        $owner = User::find($badgeNumber);
        return !(bool)$owner;
    }

}
