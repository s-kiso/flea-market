<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
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

    public function index(){
        $user_id = auth()->id();
        $user = User::find($user_id);
        // dd($user);

        $items = Item::paginate(9);
        return view('profile/index', compact('items', 'user'));
    }

}
