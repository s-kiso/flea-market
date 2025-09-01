<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function purchase($item_id)
    {
        $user_id = auth()->id();
        $user = User::find($user_id);
        $item = Item::find($item_id);

        return view('purchase/index', compact('item', 'user'));
    }

    public function edit($item_id){
        return view('purchase/edit');
    }
}
