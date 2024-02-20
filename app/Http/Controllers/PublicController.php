<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\CareerRequestMail;
use Illuminate\Support\Facades\Mail;

class PublicController extends Controller
{

public function __construct(){
        $this->middleware('auth')->except('homepage');
}

public function careers(){
    return view ('careers');
}


public function careersSubmit(Request $request) {
    $request->validate([
        'role' => 'required',
        'email' => 'required|email',
        'message' => 'required',
    ]);

    $role = $request->role;
    $email = $request->email;
    $message = $request->message;

    $user = Auth::user();

    switch ($role) {
        case 'admin':
            Mail::to('admin@theaulabpost.it')->send(new CareerRequestMail(compact('role', 'email', 'message')));
            break;
        case 'revisor':
            Mail::to('revisor@theaulabpost.it')->send(new CareerRequestMail(compact('role', 'email', 'message')));
            break;
        case 'writer':
            Mail::to('writer@theaulabpost.it')->send(new CareerRequestMail(compact('role', 'email', 'message')));
            break;
        default:
            // Ruolo non valido
            return redirect()->back()->with('error', 'Ruolo non valido.');
    }

    // Aggiornamento del ruolo dell'utente (se necessario)
    switch ($role) {
        case 'admin':
            $user->is_admin = true;
            $user->is_revisor = false;
            $user->is_writer = false;
            break;
        case 'revisor':
            $user->is_admin = false;
            $user->is_revisor = true;
            $user->is_writer = false;
            break;
        case 'writer':
            $user->is_admin = false;
            $user->is_revisor = false;
            $user->is_writer = true;
            break;
    }

    $user->save();

    return redirect(route('welcome'))->with('message', 'Grazie per averci contattato!');
}

public function welcome(){
    $articles = Article::where('is_accepted')->orderBy('created_at', 'desc')->take(4)->get();
    return view('welcome', compact('articles'));
}
}
