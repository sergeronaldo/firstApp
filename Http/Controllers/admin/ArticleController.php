<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $article = DB::table('article')->get();
        foreach($article as $art){
            $art->imgArt = base64_encode($art->imgArt);
        }
        return view('admin.article',['article'=>$article]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.ajoutArt');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $image = null;
        if(!empty($request->file('imgArt'))){
            $image = file_get_contents($request->file('imgArt'));
        }
        DB::table('article')->insert([
            'imgArt'=>$image,
            'title'=>$request->input('title'),
            'body'=>$request->input('body'),
            'date_read'=>now(),
            'userAd'=>session('user_id')
        ]);

        return redirect()->route('admin.article.index')->with('success','Enregistrement réussi');
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
    public function edit(int $article)
    {
        $article = DB::table('article')->where('id_art',$article)->first();
        return view('admin.editArt',['article'=>$article]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $article)
    {
        $image = null;
        if(!empty($request->file('imgArt'))){
            $image = file_get_contents($request->file('imgArt'));
        }
        if($image !== null){
            DB::table('article')->where('id_art',$article)->update([
                'imgArt'=>$image,
                'title'=>$request->input('title'),
                'body'=>$request->input('body'),
                'date_read'=>now(),
                'userAd'=>session('user_id')
            ]);
        }else{
            DB::table('article')->where('id_art',$article)->update([
                'title'=>$request->input('title'),
                'body'=>$request->input('body'),
                'date_read'=>now(),
                'userAd'=>session('user_id')
            ]);
        }
        
        return redirect()->route('admin.article.index')->with('success','mise à jour réussi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $article)
    {
        DB::table('article')->where('id_art',$article)->delete();
        return redirect()->route('admin.article.index')->with('success','suppression réussi');
    }
}
