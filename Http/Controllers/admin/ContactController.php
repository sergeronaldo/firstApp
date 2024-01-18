<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contact = DB::table('contact')->get();
        foreach($contact as $h){
            $h->banniere = base64_encode($h->banniere);
        }
        $home = DB::table('home')->first();
        $home->logo = base64_encode($home->logo);
        return view('admin.contact',['contact'=>$contact,'home'=>$home]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.ajoutContact');
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
        DB::table('contact')->insert([
            'banniere'=>$image,
            'text_1'=>$request->input('text1'),
            'text_2'=>$request->input('soustext'),
        ]);

        return redirect()->route('admin.contact.index')->with('success','Enregistrement réussi');
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
    public function edit(int $contact)
    {
        $contact = DB::table('contact')->where('id_contact',$contact)->first();
        return view('admin.editContact',['contact'=>$contact]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $contact)
    {
        $image = null;
        if(!empty($request->file('banniere'))){
            $image = file_get_contents($request->file('banniere'));
        }
        if($image !== null){
            DB::table('contact')->where('id_contact',$contact)->update([
                'banniere'=>$image,
                'text_1'=>$request->input('text1'),
                'text_2'=>$request->input('soustext'),
            ]);
        }else{
            DB::table('contact')->where('id_contact',$contact)->update([
                'text_1'=>$request->input('text1'),
                'text_2'=>$request->input('soustext'),
            ]);
        }
        
        return redirect()->route('admin.contact.index')->with('success','mise à jour réussi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $contact)
    {
        DB::table('contact')->where('id_contact',$contact)->delete();
        return redirect()->route('admin.contact.index')->with('success','suppression réussi');
    }
}
