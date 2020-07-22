<?php

namespace App\Http\Controllers;

use App\Item;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    public function index() {

        $items = Item::all();

        return view('item.index', compact('items'));
    }

    public function create() {
        $item = new Item();

        return view('item.create', compact('item'));
    }

    public function store() {
        
        $data = $this->validatedData();

        Item::create($data);

        return redirect('/items');

    }

    public function show(Item $item) {
        return view('item.show', compact('item'));
    }

    public function edit(Item $item) {
        return view('item.edit', compact('item'));
    }

    public function update(Item $item) {
        
        $data = $this->validatedData($item);

        $item->update($data);

        return redirect('/items');

    }

    protected function validatedData(Item $item = null) {

        $request = request();

        $rules = [
            'title' => 'required|max:30',
            'barcode' => 'required|max:10|unique:items,barcode',
            'type' => 'required|max:30',
            'owner.badge_number' => 'required|integer|digits_between:1,6',
            'owner.first_name' => [
                Rule::requiredIf(function () use ($request) {
                    $owner = User::find($request->owner['badge_number']);
                    return !(bool)$owner;
                }), 'max:70'
            ],
            'owner.last_name' => [
                Rule::requiredIf(function () use ($request) {
                    $owner = User::find($request->owner['badge_number']);
                    return !(bool)$owner;
                }), 'max:70'
            ],
            'source' => 'max:30',
            'source_date' => 'nullable|date_format:Y-m-d',
            'location' => 'required|max:30',
            'description' => 'max:250',
            'keywords' => 'max:40'
        ];

        if ($item) {
            $rules['barcode'] = $rules['barcode'] . ',' . $item->id;
            $rules['badge_number'] = 'required|integer|digits_between:1,6';
        }

        return request()->validate($rules);
    }

}
