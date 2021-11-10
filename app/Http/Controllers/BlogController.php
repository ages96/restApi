<?php

namespace App\Http\Controllers;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Blog $blog)
    {
        $this->blog = $blog;
    }

    public function detail($id)
    {
     
        $post = $this->blog->getDetail($id);
        
        if($post){
            return response()->json(['message' => 'Succesfully get data', 'data' => $post], 200);
        }
        
        return response()->json(['message' => 'Blog not available', 'data' => (object) null], 404);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), ['title'=>'required|unique:blogs|min:5|max:100'], ['title.required'=>'Title is required']);

        if($validate->fails()){
            return response()->json(['message' => $validate->errors()->first(), 'data' => (object) null], 422);
        }

        try {

            $post = new Blog;
            $post->title = $request->title;
            $post->description = $request->description;
            $saved = $post->save();

            if($saved){
                return response()->json(['message' => 'Created Successfuly', 'data' => (object) null], 200);
            }

        } catch (\Exception $e){
            return response()->json(['message' => 'Something went wrong', 'data' => (object) null], 500);
        }

    }

}
