<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest as RequestsProfileRequest;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function edit()
    {
        return view('profile/edit');
    }

    public function edited(ProfileRequest $request)
    {
        $filename = $request->image->getClientOriginalName();
        $image = $request->image->storeAs('', $filename, 'public');

        $request->flash;
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
}
