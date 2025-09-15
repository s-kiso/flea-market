<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\User;

class MypageController extends Controller
{
    public function edit()
    {
        return view('profile/edit');
    }

    public function edited(ProfileRequest $request)
    {
        $request->flash;
        $image = null;
        if(isset($request->image)) {
            $filename = $request->image->getClientOriginalName();
            $image = $request->image->storeAs('', $filename, 'public');
        };

        $name = $request->input('name');
        $address = $request->input('address');
        $postal_code = $request->input('postal_code');
        $building = $request->input('building');

        $user = Auth::user();
        $user->image = $image;
        $user->name = $name;
        $user->address = $address;
        $user->postal_code = $postal_code;
        $user->building = $building;

        $user->save();

        return redirect('/');
    }

    public function index(Request $request){

        $type = $request->query('tab');
        $user_id = auth()->id();
        $user = User::find($user_id);

        if($type == "buy"){
            $items = $user->purchase->all();
            foreach($items as $i => $item){
                if($item->pivot->condition <> "3"){
                    unset($items[$i]);
                }
            }
        }elseif($type == "deal"){
            //condition==2だけ残す（1,3,nullは削除）
            $sell_items = Item::where('user_id', $user_id)->get()->all();
            foreach ($sell_items as $i => $item) {
                $purchase_data = $item->purchase->all();
                if($purchase_data == null){
                    unset($sell_items[$i]);
                }else{
                    foreach ($purchase_data as $data) {
                        if ($data->pivot->condition <> "2") {
                            unset($sell_items[$i]);
                        }
                    }
                }
            }

            $purchase_items = $user->purchase->all();

            foreach ($purchase_items as $i => $item) {
                if ($item->pivot->condition <> "2") {
                    unset($purchase_items[$i]);
                }
            }

            $items = array_merge($sell_items, $purchase_items);

        }else{
            $items = Item::where('user_id', $user_id)->get()->all();
            foreach ($items as $i => $item) {
                $purchase_data = $item->purchase->all();
                foreach($purchase_data as $data){
                    if ($data->pivot->condition == "2") {
                        unset($items[$i]);
                    }
                }
            }
        }

        return view('profile/index', compact('items', 'user', 'type'));
    }

}
