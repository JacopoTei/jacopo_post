<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(){
        $this->middleware('auth')->except('index', 'show');
    }
    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->get();
        return view('article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('article.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|unique:articles|min:5',
        'subtitle' => 'required|unique:articles|min:5',
        'body' => 'required|min:10',
        'image' => 'image|required',
        'category' => 'required',
    ]);

    $article = new Article();
    $article->title = $request->title;
    $article->subtitle = $request->subtitle;
    $article->body = $request->body;
    $article->category_id = $request->category;
    $article->user_id = Auth::user()->id;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('public/images');
        $article->image = $imagePath;
    }

    $article->save();

    return redirect(route('welcome'))->with('message', 'Articolo creato correttamente');
}

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('article.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        //
    }

    public function byCategory(Category $category)
    {
        $articles = $category->articles->sortByDesc('created_at');
        return view('article.byCategory', compact('category'), ('articles'));
    }
}