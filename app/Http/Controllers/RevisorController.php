<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RevisorController extends Controller
{
    public function dashboard()
{
    $unrevisionedArticles = Article::whereNull('is_accepted')->get();
    $acceptedArticles = Article::where('is_accepted', true)->get();
    $rejectedArticles = Article::where('is_accepted', false)->get();

    return view('revisor.dashboard', compact('unrevisionedArticles', 'acceptedArticles', 'rejectedArticles'));
}

    public function acceptArticle (User $user) {
    $article->update([
        'is_accepted' => true,
    ]);
    
    return redirect(route('revisor.dashboard'))->with('message' , 'Hai accettato l\'articolo scelto');
    
}

    public function rejectArticle (User $user) {
    $article->update([
        'is_accepted' => false,
    ]);
    
    return redirect(route('revisor.dashboard'))->with('message' , 'Hai rifiutato l\'articolo scelto');
    
}


    public function undoArticle (User $user) {
    $article->update([
        'is_accepted' => NULL,
    ]);
    
    return redirect(route('revisor.dashboard'))->with('message' , 'Hai riportato l\'articolo in revisione');
    
} 
}
