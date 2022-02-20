<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Message;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\SendMessage;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    // all books
    public function index()
    {
        $Message = Message::with('user')->get();
        return $Message;
    }

    public function index3($id)
    {
        $Message = Message::where(['user_id'=> $id, 'to_id'=> Auth::user()->id])->update(['is_read' => 1]);

        $id = intval($id);
        $Message = Message::with('user')->where(['user_id'=> Auth::user()->id, 'to_id'=> $id])->orWhere(['user_id'=> $id, 'to_id'=> Auth::user()->id])->orderBy('id', 'ASC')->get();
        return $Message;
    }

    public function index2()
    {
        $Message = Message::with('user')->where('user_id', '!=', Auth::user()->id)->where('to_id', '=', Auth::user()->id)->orderBy('id', 'DESC')->limit(1)->get();
        return $Message;
    }

    public function readMsg(Request $request)
    {
        $Message = Message::find($request->id);
        $Message->is_read = 1;
        $Message->save();
    }

    // add book
    public function add(Request $request)
    {
        $user = Auth::user();
        var_dump($request->to_id);
        $messages = $user->messages()->create([
            'message'=> $request->message,
            'to_id'=> intval($request->to_id),
            'is_read'=> 0
        ]);
        return "Message sent";
    }

    // edit book
    public function edit($id)
    {
        $book = Product::find($id);
        return response()->json($book);
    }

    // update book
    public function update($id, Request $request)
    {
        $Product = Product::find($id);
        if($request->image->extension()){
            $imageName = time().'.'.$request->image->extension();   //$request->imageName;
            $resouce_path = public_path('images/');
            $request->image->move($resouce_path, $imageName);
            $Product->image = $imageName;
        }
        $Product->description = $request->description;
        $Product->save();

        return response()->json('The book successfully updated');
    }

    // delete book
    public function delete($id)
    {
        $Product = Product::find($id);
        $Product->delete();

        return response()->json('The book successfully deleted');
    }
}
