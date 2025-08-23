<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExhibitionRequest;
use App\Models\Condition;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::paginate(9);
        return view('item/index', compact('items'));
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

    public function registered(ExhibitionRequest $request)
    {
        $filename = $request->image->getClientOriginalName();
        $image = $request->image->storeAs('', $filename, 'public');
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
