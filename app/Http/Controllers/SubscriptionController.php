<?php

namespace App\Http\Controllers;
use App\Models\Subscription;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
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

    public function subscribe(Request $request)
    {
        $validate = Validator::make($request->all(), ['email'=>'required|email|unique:subscriptions'], ['email.required'=>'email is required']);

        if($validate->fails()){
            return response()->json(['message' => $validate->errors()->first(), 'data' => (object) null], 422);
        }

        try {

            $sub = new Subscription;
            $sub->email = $request->email;
            $saved = $sub->save();

            if($saved){
                return response()->json(['message' => 'Subscribed!', 'data' => (object) null], 200);
            }

        } catch (\Exception $e){
            return response()->json(['message' => 'Something went wrong', 'data' => (object) null], 500);
        }

    }

    public function unsubscribe(Request $request)
    {
        $validate = Validator::make($request->all(), ['email'=>'required|email'], ['email.required'=>'Email is required']);

        if($validate->fails()){
            return response()->json(['message' => $validate->errors()->first(), 'data' => (object) null], 422);
        }

        try {

            $deleted = Subscription::where("email", $request->email)->delete();

            if($deleted){
                return response()->json(['message' => 'Unsubscribed!', 'data' => (object) null], 200);
            }

        } catch (\Exception $e){
            return response()->json(['message' => 'Something went wrong', 'data' => (object) null], 500);
        }

    }

}
