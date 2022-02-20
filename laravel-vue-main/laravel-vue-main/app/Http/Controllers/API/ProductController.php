<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // all books
    public function index()
    {
        $Product = Product::all()->toArray();
        return array_reverse($Product);
    }

    public function index2()
    {
        $Product = Product::where('author', Auth::user()->id)->get()->toArray();
        return array_reverse($Product);
    }

    // add book
    public function add(Request $request)
    {
        $imageName = [];
        $resouce_path = public_path('images/');
        foreach($request->images as $key => $image){
            $image_name = time().$key.'.'.$image->extension();
            $image->move($resouce_path, $image_name);
            $imageName[] = $image_name;
        }

        $imageName = implode(',', $imageName);
        // $imageName = time().'.'.$request->image->extension();  
        // $imageName = time().'.'.$request->image->extension(); //$request->imageName;
        
        
        $Product = new Product();
        $Product->image = $imageName;
        $Product->description = $request->description;
        $Product->location = $request->location;
        $Product->time = $request->time;
        $Product->author = Auth::user()->id;
        $Product->save();

        return response()->json('The Product successfully added');
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

        $imageName = [];
        $resouce_path = public_path('images/');

        foreach($request->oldImages as $key => $image){
            $image_name = $image->getClientOriginalName();
            // $image->move($resouce_path, $image_name);
            $imageName[] = $image_name;
        }

        foreach($request->images as $key => $image){
            $image_name = time().$key.'.'.$image->extension();
            $image->move($resouce_path, $image_name);
            $imageName[] = $image_name;
        }

        $imageName = implode(',', $imageName);

        $Product = Product::find($id);
        // if($request->image->extension()){
        //     $imageName = time().'.'.$request->image->extension();   //$request->imageName;
        //     $resouce_path = public_path('images/');
        //     $request->image->move($resouce_path, $imageName);
        //     $Product->image = $imageName;
        // }
        $Product->image = $imageName;
        $Product->location = $request->location;
        $Product->time = $request->time;
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
