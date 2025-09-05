<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExhibitionRequest;
use App\Models\Condition;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;

use function GuzzleHttp\Promise\all;

class ItemController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth')
    //         ->only(['index']);
    // }

    public function index(Request $request)
    {
        $user_id = auth()->id();
        $type = $request->query('tab');

        if($type == "mylist"){
            if (isset($user_id)) {
                $items = User::find($user_id)->like->all();
                foreach($items as $key => $item){
                    $seller = $item->user_id;
                    if($seller == $user_id){
                        unset($items[$key]);
                    }
                }
            } else {
                $items = [];
            }
        }else{
            if (isset($user_id)) {
                $items = Item::where('user_id', '<>', $user_id)->orWhereNull('user_id')->get();
            } else {
                $items = Item::all();
            }
        }
        return view('item/index', compact('items', 'type'));
    }

    public function detail($item_id)
    {
        $user_id = auth()->id();
        // $user = User::find($user_id);

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

        // dd($comments);

        return view('item/detail', compact('item', 'condition', 'categories', 'likes_number', 'likes_user', 'comments', 'comments_number'));
    }

    public function register()
    {
        $conditions = Condition::all();
        return view('item/register', compact('conditions'));
    }

    public function registered(Request $request)
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

    public function comment(Request $request)
    {
        $user_id = auth()->id();
        $item_id = $request->input('id');
        $comment = $request->input('comment');

        User::find($user_id)->comment()->attach($item_id, ['comment'=>$comment]);

        return redirect()->route('item.detail', ['item_id' => $item_id]);
    }

}
