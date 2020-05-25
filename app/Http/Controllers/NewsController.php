<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Requests\NewsRequest;

use Illuminate\Http\Request;
use App\News;
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
        $news = News::paginate(15);

       
        return NewsResource::collection($news);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsRequest $request)
    {
       
       

        $news =  new News;
        $news->id = $request->input('id');
        $news->title = $request->input('title');
        $news->header = $request->input('header');
        $news->description = $request->input('description');
        
        $file = $request->file('photo');
        $filename = $file->getClientOriginalName();
        $path = public_path().'/uploads/';
        $url=$file->move($path, $filename);
        $news->file_url=url($url.$filename);
      
        



        if($news->save()) {
       
            return new NewsResource($news);
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
        $news = News::findOrFail($id);

        
        return new NewsResource($news);
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
        $news = News::find($id);
        $news->id = $request->input('id');
        $news->title = $request->input('title');
        $news->header = $request->input('header');
        $news->description = $request->input('description');
        
        $file = $request->file('photo');
        $filename = $file->getClientOriginalName();
        $path = public_path().'/uploads/';
        $url=$file->move($path, $filename);
        $news->file_url=url($url.$filename);
       
        $news->save();

        return new NewsResource($news);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         
         $news = News::findOrFail($id);

         if($news->delete()) {
             return new NewsResource($news);
         }
    }
}