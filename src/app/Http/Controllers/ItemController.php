<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;
use App\Models\Condition;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;

use function GuzzleHttp\Promise\all;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $user_id = auth()->id();
        $previous_page = url()->previous();
        $type = $request->query('tab');
        $url = $request->input('url');

        if($url == "/?tab=mylist"){
                $type = 'mylist';
            }

        if(isset($search)){
            if ($type == "mylist") {
                if (isset($user_id)) {
                    $items = User::find($user_id)->like;
                    $items = $items->filter(function($item) use ($search){
                        return strpos($item->name, $search) !== false;
                    });
                    foreach ($items as $key => $item) {
                        $seller = $item->user_id;
                        if ($seller == $user_id) {
                            unset($items[$key]);
                        }
                    }
                } else {
                    $items = [];
                }
            } else {
                if (isset($user_id)) {
                    $items = Item::where('user_id', '<>', $user_id)->orWhereNull('user_id')->get();
                    $items = $items->filter(function ($item) use ($search) {
                        return strpos($item->name, $search) !== false;
                    });
                } else {
                    $items = Item::where('name', 'LIKE', "%{$search}%")->get();
                }
            }
        }else{
            if ($type == "mylist") {
                if (isset($user_id)) {
                    $items = User::find($user_id)->like->all();
                    foreach ($items as $key => $item) {
                        $seller = $item->user_id;
                        if ($seller == $user_id) {
                            unset($items[$key]);
                        }
                    }
                } else {
                    $items = [];
                }
            } else {
                if (isset($user_id)) {
                    $items = Item::where('user_id', '<>', $user_id)->orWhereNull('user_id')->get();
                } else {
                    $items = Item::all();
                }
            }
        }

        //購入済みかどうか判定
        foreach($items as $item){
            $purchase_data = Purchase::where('item_id', $item->id)->get()->all();
            $purchase_check = null;
            foreach ($purchase_data as $data) {
                if ($data->condition == '2') {
                    $purchase_check = 'purchased';
                    $item['purchase_check'] = $purchase_check;
                }
            }
        }
        return view('item/index', compact('items', 'type', 'search'));
    }

    public function detail($item_id)
    {
        $user_id = auth()->id();
        $item = Item::find($item_id);
        $condition = $item->condition->name;
        $categories = $item->category;

        $likes = $item->like->all();
        $likes_number = count($likes);
        $likes_user = $item->like->find($user_id);
        if(isset($likes_user)){
            $likes_user = "true";
        }else{
            $likes_user = "false";
        }

        $comments = $item->comment->all();
        $comments_number = count($comments);

        //購入済みかどうか判定
        $purchase_data = Purchase::where('item_id', $item_id)->get()->all();
        $purchase_check = null;
        foreach($purchase_data as $data){
            if($data->condition == '2'){
                $purchase_check = 'purchased';
            }
        }

        return view('item/detail', compact('item', 'condition', 'categories', 'likes_number', 'likes_user', 'comments', 'comments_number', 'purchase_check'));
    }

    public function register()
    {
        $conditions = Condition::all();
        $categories = Category::all();
        return view('item/register', compact('conditions', 'categories'));
    }

    public function registered(ExhibitionRequest $request)
    {
        $user_id = auth()->id();
        $filename = $request->image->getClientOriginalName();
        $image = $request->image->storeAs('', $filename, 'public');
        $category = $request->input('category');

        $register_data = new Item();
        $register_data->condition_id = $request->input('condition');
        $register_data->user_id = $user_id;
        $register_data->name = $request->input('name');
        $register_data->brand = $request->input('brand');
        $register_data->price = $request->input('price');
        $register_data->description = $request->input('description');
        $register_data->image = $image;
        $register_data->save();

        $item_id = $register_data->id;
        Item::find($item_id)->category()->attach($category);

        return redirect()->route('home');
    }

    public function like(Request $request)
    {
        $item_id = $request->input('id');
        $user_id = auth()->id();
        $status = $request->input('status');

        if($status == "true"){
            User::find($user_id)->like()->detach($item_id);
        }else{
            User::find($user_id)->like()->attach($item_id);
        }

        return redirect()->route('item.detail', ['item_id'=>$item_id]);
    }

    public function comment(CommentRequest $request)
    {
        $user_id = auth()->id();
        $item_id = $request->input('id');
        $comment = $request->input('comment');

        User::find($user_id)->comment()->attach($item_id, ['comment'=>$comment]);

        return redirect()->route('item.detail', ['item_id' => $item_id]);
    }

}
