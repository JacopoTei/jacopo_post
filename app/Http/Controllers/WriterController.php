<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WriterController extends Controller
{
    public function dashboard(){
        $acceptedArticles = Article::where('user_id', Auth::user()->id)->where('is_accepted', true)->orderBy('created_at', 'desc')->get();
        $rejectedArticles = Article::where('user_id', Auth::user()->id)->where('is_accepted', false)->orderBy('created_at', 'desc')->get();
        $unrevisionedArticles = Article::where('user_id', Auth::user()->id)->where('is_accepted', NULL)->orderBy('created_at', 'desc')->get();

        return view('writer.dashboard', compact('acceptedArticles', 'rejectedArticles', 'unrevisionedArticles'));
    }

    public function edit(Article $article){
        return view ('article.edit' , compact('article'));
    }

    public function update(Request $request, Article $article)
{
    $request->validate([
        'title' => 'required|min:5|unique:articles,title,' . $article->id,
        'subtitle' => 'required|min:5|unique:articles,subtitle,' . $article->id,
        'body' => 'required|min:10',
        'image' => 'image',
        'category' => 'required',
        'tags' => 'required',
    ]);

    $article->update([
        'title' => $request->title,
        'subtitle' => $request->subtitle,
        'body' => $request->body,
        'category_id' => $request->category,
    ]);

    if ($request->image) {
        Storage::delete($article->image);
        $article->update([
            'image' => $request->file('image')->store('public/images'),
        ]);
    }

    $tags = explode(',', $request->tags);
    $newTags = [];
    foreach ($tags as $tag) {
        $newTag = Tag::updateOrCreate(['name' => $tag]);
        $newTags[] = $newTag->id;
    }

    $article->tags()->sync($newTags);

    return redirect(route('writer.dashboard'))->with('message', 'Hai correttamente aggiornato l\'articolo scelto');
}

public function destroy(Article $article)
{
    foreach ($article->tags as $tag) {
        $article->tags()->detach($tag->id);
    }
    $article->delete();

    return redirect(route('writer.dashboard'))->with('message', 'Hai correttamente cancellato l\'articolo scelto');
}

}
