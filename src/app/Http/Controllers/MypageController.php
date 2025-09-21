<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Models\Deal;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
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
        $unread_number = 0;

        //未読のメッセージ数を数える
        $sell_items = Item::where('user_id', $user_id)->get()->all();
        foreach ($sell_items as $i => $item) {
            $purchase_data = $item->purchase->all();
            if ($purchase_data == null) {
                unset($sell_items[$i]);
            } else {
                foreach ($purchase_data as $data) {
                    if ($data->pivot->condition == "2" || $data->pivot->condition == "3") {
                        $unread_data = Deal::where([
                            ['item_id', '=', $data->pivot->item_id],
                            ['user_type', '=', "buyer"],
                            ['check', '=', 1],
                        ])->get()->all();
                        $unread_number = $unread_number + count($unread_data);
                        if($unread_data !== []){
                            $sell_items[$i]->unread_number = count($unread_data);
                            $sell_items[$i]->newest_message_time = strval($unread_data[count($unread_data) - 1]->updated_at);
                        }else{
                            $sell_items[$i]->unread_number = count($unread_data);
                            $sell_items[$i]->newest_message_time = '2025-01-01 00:00:00';
                        }
                    }else{
                        unset($sell_items[$i]);
                    }
                }
            }
        }
        $purchase_items = $user->purchase->all();
        foreach ($purchase_items as $i => $item) {
            if ($item->pivot->condition == "2") {
                $unread_data = Deal::where([
                    ['item_id', '=', $item->pivot->item_id],
                    ['user_type', '=', "seller"],
                    ['check', '=', 1],
                ])->get()->all();
                $unread_number = $unread_number + count($unread_data);
                if ($unread_data !== []) {
                    $purchase_items[$i]->unread_number = count($unread_data);
                    $purchase_items[$i]->newest_message_time = strval($unread_data[count($unread_data) - 1]->updated_at);
                } else {
                    $purchase_items[$i]->unread_number = count($unread_data);
                    $purchase_items[$i]->newest_message_time = '2025-01-01 00:00:00';
                }
            }else{
                unset($purchase_items[$i]);
            }
        }

        if($type == "buy"){
            $items = $user->purchase->all();
            foreach($items as $i => $item){
                if($item->pivot->condition <> "3"){
                    unset($items[$i]);
                }
            }
        }elseif($type == "deal"){
            $items = array_merge($sell_items, $purchase_items);
            $updated_at = array_map("strtotime", array_column($items, 'newest_message_time'));
            array_multisort($updated_at, SORT_DESC, $items);
        }else{
            $items = Item::where('user_id', $user_id)->get()->all();
            foreach ($items as $i => $item) {
                $purchase_data = $item->purchase->all();
                foreach($purchase_data as $data){
                    if ($data->pivot->condition == "2" || $data->pivot->condition == "3") {
                        unset($items[$i]);
                    }
                }
            }
        }

        if(isset($user->rate)){
            $rate = round($user->rate / $user->rate_total);
            $star_yellow = $rate;
            $star_white = 5 - $rate;
        }else{
            $star_yellow = null;
            $star_white = null;
        }

        return view('profile/index', compact('items', 'user', 'type', 'unread_number', 'star_yellow', 'star_white'));
    }

}



