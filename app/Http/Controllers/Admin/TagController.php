<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tag;
use Session;
use Auth;

class TagController extends Controller
{   
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $tag = Tag::all();

        return view('admin.tag.index',['tags'=>$tag]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $this->authorize('create',Tag::class);
        return view('admin.tag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $this->authorize('create',Tag::class);

        $tag = new Tag();
        $tag->name = $request->get('name');
        $tag->save();

        Session::flash('message', 'successful Insert!');
        Session::flash('type', 'success');

        return  redirect()->action('Admin\TagController@edit',['id' => $tag->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tag = Tag::findorFail($id);

        $this->authorize('view',$tag);

        return view('admin.tag.show',['tag'=>$tag]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = Tag::find($id);

        $this->authorize('update',$tag);

        return view('admin.tag.update',['tag'=>$tag]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tag = Tag::findorFail($id);

        $this->authorize('update',$tag);
        
        $tag->name = $request->get('name');
        $tag->save();

        Session::flash('message', 'successful Update!');
        Session::flash('type', 'success');

        return  redirect()->action('Admin\TagController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::find($id);

        $this->authorize('delete',$tag);
        
        $tag->delete();

        Session::flash('message', 'successful Delete!');
        Session::flash('type', 'success');

        return view('admin.tag.index');
    }
}
