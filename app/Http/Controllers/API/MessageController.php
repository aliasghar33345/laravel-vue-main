<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Message;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\SendMessage;

class MessageController extends Controller
{
    // all books
    public function index()
    {
        $Message = Message::with('user')->get();
        return $Message;
    }

    // add book
    public function add(Request $request)
    {
        $user = Auth::user();
        // var_dump($request->message);
        $messages = $user->messages()->create([
            'message'=> $request->message['_value']
        ]);
        broadcast(new SendMessage($user, $messages))->toOthers();
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
