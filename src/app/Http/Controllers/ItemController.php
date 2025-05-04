<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExhibitionRequest;
use App\Models\Condition;
use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::paginate(9);
        return view('item/index', compact('items'));
    }

    public function detail($item_id)
    {
        $item = Item::find($item_id);
        $condition = Item::find($item_id)->condition->name;
        return view('item/detail', compact('item', 'condition'));
    }

    public function register()
    {
        $conditions = Condition::all();
        return view('item/register', compact('conditions'));
    }

    public function registered(ExhibitionRequest $request)
    {
        $filename = $request->image->getClientOriginalName();
        $image = $request->image->storeAs('', $filename, 'public');
    }
}
