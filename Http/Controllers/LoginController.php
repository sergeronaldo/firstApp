<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function login(){
        return view('admin.login');
    }
    public function dologin(Request $request){
        $userInput = $request->input('email');
        $passW = $request->input('mdp'); 
        if (filter_var($userInput, FILTER_VALIDATE_EMAIL)) {
            $user = DB::table('admin')->where('userW',$userInput)->first();
            $pws = md5($passW);
            if($user && ($pws === $user->passW)){
                $request->session()->put('user_id',$user->id_user);
                $request->session()->put('nom',$user->nom);
                $request->session()->put('prenom',$user->prenom);
                $request->session()->regenerate();
                return redirect()->intended(route('admin.home.index'))->with('success','Vous êtes connecté');
            }
        }
    }
    public function dologout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

}
