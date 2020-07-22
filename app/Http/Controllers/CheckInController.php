<?php

namespace App\Http\Controllers;

use App\Item;
use Exception;
use Illuminate\Http\Request;

class CheckInController extends Controller
{
    public function store(Item $item)
    {
        try {
            $item->checkIn();
        } catch(Exception $e) {
            return response('Item is already checked-in', 404);
        }
    }
}
