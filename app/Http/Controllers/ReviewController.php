<?php

namespace App\Http\Controllers;
use App\Http\Requests\ReviewRequest;
use App\Review;
use App\Http\Resources\Review as ReviewResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\News;
class ReviewController extends Controller
{
    public function save(ReviewRequest $request,$id){
    try{
        if($existing = Review::where('news_id','=',$id)
       ->where('user_id','=',Auth::user()->id)
       ->first()){
        
        if($existing!=null) 
        {
            return response()->json(['status' => false, 'message' =>"You can review a news only once"]);
        }
       }else{
        $review =  new Review;
        $new_id = News::find($id);
        $review->rating = $request->input('rating');
        $review->review = $request->input('review');
        $review->news_id=$new_id->id;
        $user = auth()->user()->id;
        $review->user_id = $user; 
        $review->save();
        return new ReviewResource($review);
       }
    }catch(\Exception $e){
        return response()->json(['status' => false, 'message' => 'Record not Created']);
        }

    }

    public function show($id)
    {
        try {
            $user=Auth::user()->id;
            $review = Review::select('*')->where('user_id','=',$user)->first();
            return new ReviewResource($review);
        } catch(\Exception $e){
        return response()->json(['status' => false, 'message' => 'No Matching Record Found']);

        }
       
    }

    public function update(ReviewRequest $request, $id){
        try{
            $review =  Review::find($id);
            $review->rating = $request->input('rating');
            $review->review = $request->input('review');
            $user = auth()->user()->id;
            $review->user_id = $user; 
            $review->save();
            return new ReviewResource($review);
        }catch(\Exception $e){
            return response()->json(['status' => false, 'message' => 'Record Not Updated']);
            }
    }
     
    public function destroy($id){
        try{
            $review = Review::findOrFail($id);

            if($review->delete()) {
                return new ReviewResource($review);
            }
         }catch(\Exception $e){
        return response()->json(['status' => false, 'message' => 'No Record Found']);

         }
    }
}
