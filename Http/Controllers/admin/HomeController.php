<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $home = DB::table('home')->get();
        foreach($home as $h){
            $h->banniere = base64_encode($h->banniere);
            $h->logo = base64_encode($h->logo);
        }
        return view('admin.home',['home'=>$home]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.ajout');
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
        $logo = null;
        if(!empty($request->file('logo'))){
            $logo = file_get_contents($request->file('logo'));
        }
        DB::table('home')->insert([
            'banniere'=>$image,
            'text_1'=>$request->input('text1'),
            'text_2'=>$request->input('soustext'),
            'footer_text'=>$request->input('textfooter'),
            'facebook'=>$request->input('lienFacebook'),
            'twitter'=>$request->input('lienTwitter'),
            'instagram'=>$request->input('lienInstagram'),
            'linkidin'=>$request->input('lienLinkedin'),
            'logo'=>$logo
        ]);

        return redirect()->route('admin.home.index')->with('success','Enregistrement réussi');
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
    public function edit(int $home)
    {
        $home = DB::table('home')->where('id_home',$home)->first();
        return view('admin.edite',['home'=>$home]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $home)
    {
        $image = null;
        $logo = null;
        if(!empty($request->file('banniere'))){
            $image = file_get_contents($request->file('banniere'));
        }
        if(!empty($request->file('logo'))){
            $logo = file_get_contents($request->file('logo'));
        }

        if($image !== null && $logo !== null){
            DB::table('home')->where('id_home',$home)->update([
                'banniere'=>$image,
                'text_1'=>$request->input('text1'),
                'text_2'=>$request->input('soustext'),
                'footer_text'=>$request->input('textfooter'),
                'facebook'=>$request->input('lienFacebook'),
                'twitter'=>$request->input('lienTwitter'),
                'instagram'=>$request->input('lienInstagram'),
                'linkidin'=>$request->input('lienLinkedin'),
                'logo'=>$logo
            ]);
        }else if($image !== null && $logo == null){
            DB::table('home')->where('id_home',$home)->update([
                'banniere'=>$image,
                'text_1'=>$request->input('text1'),
                'text_2'=>$request->input('soustext'),
                'footer_text'=>$request->input('textfooter'),
                'facebook'=>$request->input('lienFacebook'),
                'twitter'=>$request->input('lienTwitter'),
                'instagram'=>$request->input('lienInstagram'),
                'linkidin'=>$request->input('lienLinkedin')
            ]);
        }else if($image == null && $logo !== null){
            DB::table('home')->where('id_home',$home)->update([
                'text_1'=>$request->input('text1'),
                'text_2'=>$request->input('soustext'),
                'footer_text'=>$request->input('textfooter'),
                'facebook'=>$request->input('lienFacebook'),
                'twitter'=>$request->input('lienTwitter'),
                'instagram'=>$request->input('lienInstagram'),
                'linkidin'=>$request->input('lienLinkedin'),
                'logo'=>$logo
            ]);
        }else{
            DB::table('home')->where('id_home',$home)->update([
                'text_1'=>$request->input('text1'),
                'text_2'=>$request->input('soustext'),
                'footer_text'=>$request->input('textfooter'),
                'facebook'=>$request->input('lienFacebook'),
                'twitter'=>$request->input('lienTwitter'),
                'instagram'=>$request->input('lienInstagram'),
                'linkidin'=>$request->input('lienLinkedin'),
            ]);
        }
        
        return redirect()->route('admin.home.index')->with('success','mise à jour réussi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $home)
    {
        DB::table('home')->where('id_home',$home)->delete();
        return redirect()->route('admin.home.index')->with('success','suppression réussi');
    }
}
