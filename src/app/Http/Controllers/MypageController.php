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
                if($item->pivot->condition == "1"){
                    unset($items[$i]);
                }
            }
        }else{
            $items = Item::where('user_id', $user_id)->get()->all();
        }
        return view('profile/index', compact('items', 'user', 'type'));
    }

}
