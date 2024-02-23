<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Mail\CareerRequestMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PublicController extends Controller
{

public function __construct(){
        $this->middleware('auth')->except('homepage');
}

public function careers(){
    return view ('careers');
}


public function careersSubmit(Request $request){
    $request->validate([
        'role'=>'required',
        'email'=>'required|email',
        'message'=>'required',
    ]);

    $user=Auth::user();
    $role=$request->role;
    $email=$request->email;
    $message=$request->message;

    Mail::to('admin@theaulabpost.it')->send(new CareerRequestMail(compact('role', 'email', 'message')));

    switch ($role) {
        case 'admin':
            $user->is_admin = NULL;
            break;
        case 'revisor':
            $user->is_revisor = NULL;
            break;
        case 'writer':
            $user->is_writer = NULL;
            break;
    }
    $user->update();

    return redirect(route('welcome'))->with('message', 'Grazie per averci contattato!');
}

public function accettaRichiesta($role, $email)
{
    // Trova l'utente associato all'email
    $user = User::where('email', $email)->first();

    // Aggiorna il ruolo dell'utente in base alla richiesta
    switch ($role) {
        case 'admin':
            $user->is_admin = true;
            break;
        case 'revisor':
            $user->is_revisor = true;
            break;
        case 'writer':
            $user->is_writer = true;
            break;
    }
    $user->save();

    // Puoi anche inviare una notifica o un'email di conferma all'utente qui, se necessario

    // Reindirizza l'utente a una pagina di conferma o a qualsiasi altra pagina desiderata
    return redirect()->route('welcome')->with('message', 'Richiesta accettata con successo!');
}




public function welcome(){
    $articles = Article::where('is_accepted', true)->orderBy('created_at', 'desc')->take(4)->get();
    return view('welcome', compact('articles'));
}
}
