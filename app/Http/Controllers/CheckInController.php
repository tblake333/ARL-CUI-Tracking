<?php

namespace App\Http\Controllers;

use App\Item;
use Exception;
use Illuminate\Http\Request;

class CheckInController extends Controller
{
    public function fromBarcode()
    {
        $request = request()->validate([
            'barcode' => 'required|max:10'
            ]);

        $item = Item::all()->where('barcode', $request['barcode'])->first();

        if ($item) {
            return redirect()->to('/check-in/' . $item->id);
        } else {
            return response('Item not found', 404);
        }
        
    }

    public function show(Item $item)
    {
        if ($item->getStatus() === 'out') {
            $user = $item->getLatestUser();
            return view('movement.checkin', compact('item', 'user'));
        } else {
            return response('Item is already checked-in', 404);
        }
    }

    public function store(Item $item)
    {
        try {
            $item->checkIn();
            return redirect()->to('/items/' . $item->id);
        } catch(Exception $e) {
            return response('Item is already checked-in', 404);
        }
    }
}
