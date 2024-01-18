<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class postController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = DB::table('post')->get();
        foreach($post as $h){
            $h->banniere = base64_encode($h->banniere);
        }
        $home = DB::table('home')->first();
        $home->logo = base64_encode($home->logo);
        return view('admin.post',['post'=>$post,'home'=>$home]);
    }

   /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.ajoutPost');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $image = null;
        if(!empty($request->file('banniere'))){
            $image = file_get_contents($request->file('banniere'));
        }
        DB::table('post')->insert([
            'banniere'=>$image,
            'text_1'=>$request->input('text1'),
            'text_2'=>$request->input('soustext'),
        ]);

        return redirect()->route('admin.post.index')->with('success','Enregistrement réussi');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $post)
    {
        $post = DB::table('post')->where('id_post',$post)->first();
        return view('admin.editPost',['post'=>$post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $post)
    {
        $image = null;
        if(!empty($request->file('banniere'))){
            $image = file_get_contents($request->file('banniere'));
        }
        if($image !== null){
            DB::table('post')->where('id_post',$post)->update([
                'banniere'=>$image,
                'text_1'=>$request->input('text1'),
                'text_2'=>$request->input('soustext'),
            ]);
        }else{
            DB::table('post')->where('id_post',$post)->update([
                'text_1'=>$request->input('text1'),
                'text_2'=>$request->input('soustext'),
            ]);
        }
        
        return redirect()->route('admin.post.index')->with('success','mise à jour réussi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $post)
    {
        DB::table('post')->where('id_post',$post)->delete();
        return redirect()->route('admin.post.index')->with('success','suppression réussi');
    }
}
