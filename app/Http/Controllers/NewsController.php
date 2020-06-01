<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Requests\NewsRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\News;
use App\User;



use App\Http\Resources\News as NewsResource;


class NewsController extends Controller
{
    


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        try{
         $news = News::paginate(15);
         return NewsResource::collection($news);

        } catch(\Exception $e){
            return response()->json(['status' => false, 'message' => 'No Record Found']);
            
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsRequest $request)
    {
        

        
       try{
        $news =  new News;
        
        $news->title = $request->input('title');
        $news->header = $request->input('header');
        $news->description = $request->input('description');
        $user = auth()->user()->id;
        $news->news_created = $user; 
        $file = $request->file('photo');
        $filename = $file->getClientOriginalName();
        $path = public_path().'/uploads/';
        $url=$file->move($path, $filename);
        $news->file_url=url($url.$filename);
      
       



        if($news->save()) {
       
            return new NewsResource($news);
       }
       }catch(\Exception $e){
        return response()->json(['status' => false, 'message' => 'Record not Created']);
       
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $news = News::findOrFail($id); 
            return new NewsResource($news);
        } catch(\Exception $e){
        return response()->json(['status' => false, 'message' => 'No Matching Record Found']);

        }
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NewsRequest $request, $id)
    {

        try{

        $news = News::find($id);
        $news->title = $request->input('title');
        $news->header = $request->input('header');
        $news->description = $request->input('description');
        $user = auth()->user()->id;
        $news->news_created = $user; 
        $file = $request->file('photo');
        $filename = $file->getClientOriginalName();
        $path = public_path().'/uploads/';
        $url=$file->move($path, $filename);
        $news->file_url=url($url.$filename);
        if($news->save()) {
       
            return new NewsResource($news);
       }
        }catch(\Exception $e){
        return response()->json(['status' => false, 'message' => 'Record Not Updated']);

        }
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         try{
            $news = News::findOrFail($id);

            if($news->delete()) {
                return new NewsResource($news);
            }
         }catch(\Exception $e){
        return response()->json(['status' => false, 'message' => 'No Record Found']);

         }
        
    }
}