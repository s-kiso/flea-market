<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function purchase(Request $request, $item_id)
    {
        $user_id = auth()->id();
        $user = User::find($user_id);
        $item = Item::find($item_id);
        $type = $request->query('type');

        $modified_address = Purchase::where([
            ['item_id', '=', $item_id],
            ['user_id', '=', $user_id],
        ])->first();

        //購入済みかどうかのチェック
        $purchase_data = Purchase::where('item_id', $item_id)->get()->all();
        $purchase_check = null;
        foreach ($purchase_data as $data) {
            if ($data->condition == '2') {
                $purchase_check = 'purchased';
            }
        }

        return view('purchase/index', compact('item', 'user', 'type', 'modified_address', 'purchase_check'));
    }

    public function purchased(PurchaseRequest $request, $item_id)
    {
        $condition = $request->input('condition');
        $user_id = auth()->id();

        //購入済みかどうかのチェック
        $purchase_data = Purchase::where('item_id', $item_id)->get()->all();
        foreach ($purchase_data as $data) {
            if ($data->condition == '2') {
                return redirect()->route('purchase.home', ['item_id' => $item_id]);
            }
        }

        $registered_data = Purchase::where([
            ['item_id', '=', $item_id],
            ['user_id', '<>', $user_id],
        ])->delete();

        if($condition == 0){
            $delivery_address = new Purchase();
            $delivery_address->user_id = $user_id;
            $delivery_address->item_id = $item_id;
            $delivery_address->postal_code = $request->input('postal_code');
            $delivery_address->address = $request->input('address');
            $delivery_address->building = $request->input('building');
            $delivery_address->condition = 2;
            $delivery_address->save();
        }elseif($condition == 1){
            $registered_address = Purchase::where([
                ['item_id', '=', $item_id],
                ['user_id', '=', $user_id],
            ])->first();
            $registered_address->postal_code = $request->input('postal_code');
            $registered_address->address = $request->input('address');
            $registered_address->building = $request->input('building');
            $registered_address->condition = 2;
            $registered_address->update();
        }
        return redirect('/mypage?type=purchase');
    }

    public function edit($item_id){
        $previous_page = url()->previous();
        $type = substr($previous_page, strpos($previous_page, 'type='));
        if(strpos($type, 'type=') !== false){
            $type = substr($type, 5);
        }else{
            $type = null;
        }

        return view('purchase/edit', compact('item_id', 'type'));
    }

    public function edited(AddressRequest $request, $item_id){

        $type = $request->input('type');
        $postal_code = $request->input('postal_code');
        $address = $request->input('address');
        $building = $request->input('building');
        $user_id = auth()->id();

        $registered_address = Purchase::where([
            ['item_id', '=', $item_id],
            ['user_id', '=', $user_id],
        ])->first();

        if(!isset($registered_address)){

            $delivery_address = new Purchase();
            $delivery_address->user_id = $user_id;
            $delivery_address->item_id = $item_id;
            $delivery_address->postal_code = $postal_code;
            $delivery_address->address = $address;
            $delivery_address->building = $building;
            $delivery_address->condition = 1;
            $delivery_address->save();
        }else{
            $address_condition = $registered_address->condition;
            if ($address_condition == 1) {
                $registered_address->postal_code = $postal_code;
                $registered_address->address = $address;
                $registered_address->building = $building;
                $registered_address->update();
            }
        }

        if($type == null){
            return redirect()->route('purchase.home', ['item_id' => $item_id])->with(compact('postal_code', 'address', 'building', 'item_id'));
        }else{
            return redirect()->route('purchase.payment', ['item_id' => $item_id, 'type' => $type])->with(compact('postal_code', 'address', 'building', 'item_id'));
        }
    }
}
