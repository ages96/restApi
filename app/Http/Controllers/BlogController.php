<?php

namespace App\Http\Controllers;
use App\Models\Blog;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Jobs\SubmitEmailSub;

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

                $subs = Subscription::where("blog_id","=",null)
                    ->where("sent", 0)
                    ->get();

                if (count($subs)>0){
                    foreach ($subs as $key => $value) {
                        if (strlen($value)>0) {
                            $data["title"] = $request->title;
                            $data["description"] = $request->description;
                            $data["receiver"] = $value->email;
                            $emailSub = (new SubmitEmailSub($data));
                            dispatch($emailSub);
                        }
                    }
                }

                return response()->json(['message' => 'Created Successfuly', 'data' => (object) null], 200);
            }

        } catch (\Exception $e){
            return response()->json(['message' => $e->getMessage(), 'data' => (object) null], 500);
        }

    }

}