<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class BlogController extends Controller
{
    public function index(){
        $home = DB::table('home')->first();
        $home->banniere = base64_encode($home->banniere);
        $home->logo = base64_encode($home->logo);
        $article = DB::table('article')
                    ->join('admin','article.id_art','=','admin.id_user')
                    ->select('admin.*','article.*')
                    ->limit(4)
                    ->get();

        return view('blog.index',[
            'home'=>$home,
            'article'=>$article
        ]);
    }
    public function about(){
        $home = DB::table('home')->first();
        $home->logo = base64_encode($home->logo);
        $about = DB::table('about')->first();
        $about->banniere = base64_encode($about->banniere);
        return view('blog.about',[
            'home'=>$home,
            'about'=>$about
        ]);
    }
    public function post(){
        $home = DB::table('home')->first();
        $home->logo = base64_encode($home->logo);
        $post = DB::table('about')->first();
        $post->banniere = base64_encode($post->banniere);
        $article = DB::table('article')
        ->join('admin','article.id_art','=','admin.id_user')
        ->select('admin.*','article.*')
        ->limit(4)
        ->get();
        return view('blog.post',[
            'home'=>$home,
            'post'=>$post,
            'article'=>$article
        ]);
    }
    public function contact(){
        $home = DB::table('home')->first();
        $home->logo = base64_encode($home->logo);
        $contact = DB::table('contact')->first();
        $contact->banniere = base64_encode($contact->banniere);
        return view('blog.contact',[
            'home'=>$home,
            'contact'=>$contact
        ]);
    }
    public function show(int $article){
        $art = DB::table('article')
        ->join('admin','article.id_art','=','admin.id_user')
        ->select('admin.*','article.*')
        ->where('id_art',$article)
        ->first();
        $art->imgArt = base64_encode($art->imgArt);
        $home = DB::table('home')->first();
        $home->logo = base64_encode($home->logo);
        return view('blog.showArt',[
            'article'=>$art,
            'home'=>$home
        ]);
    }
    public function doContact(Request $request){
        if(!empty($request->input('fullname')) && !empty($request->input('email')) && !empty($request->input('tel')) && !empty($request->input('message'))){
            $data = [
                'fullname'=>$request->input('fullname'),
                'email'=>$request->input('email'),
                'tel'=>$request->input('tel'),
                'message'=>$request->input('message'),
            ];
            Mail::to('gnangnon83@gmail.com')->send(new ContactMail($data));
            return redirect()->back()->with('success','Votre demande a bien été envoyée');
        }else{
            return redirect()->back()->with('error','Veuillez remplir les champs vide');
        }
    }
}
