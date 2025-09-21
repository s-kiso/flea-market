<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Http\Requests\DealRequest;
use App\Http\Requests\ImageModifyRequest;
use App\Http\Requests\ModifyRequest;
use App\Http\Requests\PurchaseRequest;
use App\Models\Deal;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\DealEnd;

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
            if ($data->condition <> '1') {
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
            if ($data->condition <> '1') {
                return redirect()->route('purchase.home', ['item_id' => $item_id]);
            }
        }

        Purchase::where([
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

    public function deal(Request $request, $item_id){
        $item = Item::find($item_id);
        $purchase_info = Item::find($item_id)->purchase->first();
        $condition = $purchase_info->pivot->condition;
        $user_id = auth()->id();
        $user = User::find($user_id);
        $edit_id = $request->query('edit');
        $edit_type = $request->query('type');

        $seller = User::find($item->user_id);
        $buyer = User::find($purchase_info->pivot->user_id);

        //メッセージのやり取りを抽出
        $messages = Deal::where('item_id', $item_id)->orderBy('id', 'asc')->get();

        if($item->user_id == $user_id){
            $user_type = "seller";
            $my_user = $seller;
            $client_user = $buyer;
            foreach($messages as $message){
                if($message->user_type == "buyer"){
                    $message->check = 2;
                    $message->update();
                }
            }
        }else{
            $user_type = "buyer";
            $my_user = $buyer;
            $client_user = $seller;
            foreach ($messages as $message) {
                if ($message->user_type == "seller") {
                    $message->check = 2;
                    $message->update();
                }
            }
        }

        //未読のメッセージ数を数える
        $sell_items = Item::where('user_id', $user_id)->get()->all();
        $unread_number = 0;
        foreach ($sell_items as $i => $sell_item) {
            $purchase_data = $sell_item->purchase->all();
            if ($purchase_data == null) {
                unset($sell_items[$i]);
            } else {
                foreach ($purchase_data as $data) {
                    if ($data->pivot->item_id == $item_id) {
                        unset($sell_items[$i]);
                    } elseif ($data->pivot->condition == "2" || $data->pivot->condition == "3") {
                        $unread_data = Deal::where([
                            ['item_id', '=', $data->pivot->item_id],
                            ['user_type', '=', "buyer"],
                            ['check', '=', 1],
                        ])->get()->all();
                        $unread_number = $unread_number + count($unread_data);
                        if ($unread_data !== []) {
                            $sell_items[$i]->unread_number = count($unread_data);
                            $sell_items[$i]->newest_message_time = strval($unread_data[count($unread_data) - 1]->updated_at);
                        } else {
                            $sell_items[$i]->unread_number = count($unread_data);
                            $sell_items[$i]->newest_message_time = '2025-01-01 00:00:00';
                        }
                    } else {
                        unset($sell_items[$i]);
                    }
                }
            }
        }
        $purchase_items = $user->purchase->all();
        foreach ($purchase_items as $i => $purchase_item) {
            if ($purchase_item->id == $item_id) {
                unset($purchase_items[$i]);
            } elseif ($purchase_item->pivot->condition == "2") {
                $unread_data = Deal::where([
                    ['item_id', '=', $purchase_item->pivot->item_id],
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
            } else {
                unset($purchase_items[$i]);
            }
        }
        $dealing_items = array_merge($sell_items, $purchase_items);
        $updated_at = array_map("strtotime", array_column($dealing_items, 'newest_message_time'));
        array_multisort($updated_at, SORT_DESC, $dealing_items);

        return view('purchase/deal', compact('dealing_items', 'item', 'my_user', 'client_user', 'user_type', 'messages', 'edit_id', 'edit_type', 'condition'));
    }

    public function dealing(Request $request, $item_id){

        $type = $request->input("type");
        $rate = $request->input('rate');
        $purchase_user_id = Item::find($item_id)->purchase->first()->pivot->user_id;

        if (!isset($rate)) {
            $rate = 0;
        } else {
            $rate = 5 - intval($rate);
        }

        if($type == "buyer"){
            $seller = User::find(Item::find($item_id)->user_id);
            $seller->rate = $seller->rate + $rate;
            $seller->rate_total = $seller->rate_total + 1;
            $seller->update();
            Item::find($item_id)->purchase()->sync([$purchase_user_id => ['condition' => "3"]]);

            $user_name = User::find(Item::find($item_id)->user_id)->name;
            $item = Item::find($item_id)->name;
            $url = $item_id;
            $mail_to = User::find(Item::find($item_id)->user_id)->email;
            Mail::to($mail_to)->send(new DealEnd($user_name, $item, $url));
        }else{
            $buyer = User::find(Item::find($item_id)->purchase->first()->pivot->user_id);
            $buyer->rate = $buyer->rate + $rate;
            $buyer->rate_total = $buyer->rate_total + 1;
            $buyer->update();
            Item::find($item_id)->purchase()->sync([$purchase_user_id => ['condition' => "4"]]);
        }

        return redirect()->route('home');
    }

    public function chat(DealRequest $request, $item_id){

        $user_id = auth()->id();
        $message = $request->input('chat');
        $user_type = $request->input('user_type');

        if(isset($request->image)){
            $filename = $request->image->getClientOriginalName();
            $image = $request->image->storeAs('', $filename, 'public');
        }

        $deal = new Deal();
        $deal->item_id = $item_id;
        $deal->user_type = $user_type;
        if(isset($image)){
            $deal->image = $image;
        }
        $deal->message = $message;
        $deal->check = 1;
        $deal->save();

        return redirect()->route('item.deal', ['item_id' => $item_id]);
    }

    public function modify(ModifyRequest $request, $item_id){

        $modify_item = Deal::find($request->edit_id);
        $modify_message = $request->input('modify_message');

        $modify_item->message = $modify_message;
        $modify_item->update();

        return redirect()->route('item.deal', ['item_id' => $item_id]);
    }

    public function modify_image(ImageModifyRequest $request, $item_id)
    {
        $modify_item = Deal::find($request->edit_id);
        $filename = $request->modify_image->getClientOriginalName();
        $image = $request->modify_image->storeAs('', $filename, 'public');
        $modify_item->image = $image;
        $modify_item->update();

        return redirect()->route('item.deal', ['item_id' => $item_id]);
    }

    public function delete(Request $request, $item_id){
        $type = $request->input('edit_type');
        $delete_item = Deal::find($request->edit_id);

        if($type == "message"){
            if(isset($delete_item->image)){
                $delete_item->message = null;
                $delete_item->update();
            }else{
                $delete_item->delete();
            }
        }else{
            $delete_item->image = null;
            $delete_item->update();
        }

        return redirect()->route('item.deal', ['item_id' => $item_id]);
    }

}