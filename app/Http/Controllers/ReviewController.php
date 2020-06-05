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
            if($existing = Review::where('news_id','=',$id)->where('user_id','=',Auth::user()->id)->first()){
            
            if($existing!=null) 
            {
                return response()->json(['status' => false, 'message' =>"You can review a news only once"]);
            }
        }else{
            $review = Review::create([
                'rating'=>$request->rating,
                'review'=>$request->review,
                'news_id'=>$id,
                'user_id' => $request->user()->id,
            ]);
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
            $review =  Review::where('news_id','=',$id)->where('user_id','=',Auth::user()->id)->first();
            $review->update([
                'rating'=>$request->rating,
                'review'=>$request->review,
                'news_id'=>$id,
                'user_id' => $request->user()->id,
            ]);
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
