<?php

namespace App\Http\Controllers;

use App\Item;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CheckOutController extends Controller
{
    public function fromBarcode()
    {
        $request = request()->validate([
            'barcode' => 'required|max:10'
            ]);

        $item = Item::all()->where('barcode', $request['barcode'])->first();

        if ($item) {
            return redirect()->to('/check-out/' . $item->id);
        } else {
            return response('Item not found', 404);
        }
        
    }

    public function show(Item $item)
    {
        if ($item->getStatus() === 'in') {
            return view('movement.checkout', compact('item'));
        } else {
            return response('Item is already checked-out', 404);
        }
    }

    public function store(Item $item)
    {
        $userData = $this->validatedData();

        // Either get the existing user, or create the user if new
        $user = User::firstOrCreate($userData);

        try {
            $item->checkOut($user);
            return redirect()->to('/items/' . $item->id);
        } catch (Exception $e) {
            return response('Item is already checked-out', 404);
        }
    }

    private function validatedData()
    {
        $request = request();

        return request()->validate([
            'badge_number' => 'required|integer|digits_between:1,6',
            'first_name' => [
                Rule::requiredIf(function () use ($request) {
                    $user = User::find($request->badge_number);
                    return !(bool)$user;
                }), 'nullable', 'alpha', 'max:70'
            ],
            'last_name' => [
                Rule::requiredIf(function () use ($request) {
                    $user = User::find($request->badge_number);
                    return !(bool)$user;
                }), 'nullable', 'alpha', 'max:70'
            ],
        ]);
    }
}
