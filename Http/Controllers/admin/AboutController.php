<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $about = DB::table('about')->get();
        foreach($about as $h){
            $h->banniere = base64_encode($h->banniere);
        }
        $home = DB::table('home')->first();
        $home->logo = base64_encode($home->logo);
        return view('admin.about',['about'=>$about,'home'=>$home]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.ajoutAbout');
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
        DB::table('about')->insert([
            'banniere'=>$image,
            'text_1'=>$request->input('text1'),
            'text_2'=>$request->input('soustext'),
            'apropos'=>$request->input('apropos')
        ]);

        return redirect()->route('admin.about.index')->with('success','Enregistrement réussi');
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
    public function edit(int $about)
    {
        $about = DB::table('about')->where('id_about',$about)->first();
        return view('admin.editAbout',['about'=>$about]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $about)
    {
        $image = null;
        if(!empty($request->file('banniere'))){
            $image = file_get_contents($request->file('banniere'));
        }
        if($image !== null){
            DB::table('about')->where('id_about',$about)->update([
                'banniere'=>$image,
                'text_1'=>$request->input('text1'),
                'text_2'=>$request->input('soustext'),
                'apropos'=>$request->input('apropos')
            ]);
        }else{
            DB::table('about')->where('id_about',$about)->update([
                'text_1'=>$request->input('text1'),
                'text_2'=>$request->input('soustext'),
                'apropos'=>$request->input('apropos')
            ]);
        }
        
        return redirect()->route('admin.about.index')->with('success','mise à jour réussi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $about)
    {
        DB::table('about')->where('id_about',$about)->delete();
        return redirect()->route('admin.about.index')->with('success','suppression réussi');
    }
}
