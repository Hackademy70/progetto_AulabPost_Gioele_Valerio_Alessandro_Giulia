<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->get();
        return view('article.index', compact('articles'));
    }

    public function __construct(){
        $this->middleware('auth')->except('index', 'show','byCategory','byUser');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Route::get('article/create', [ArticleController::class, 'create'])->name('article.create');
        return view('article.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:articles|min:10',
            'subtitle' => 'required|unique:articles|min:15',
            'body' => 'required|min:25',
            'image' => 'image|required',
            'category' => 'required',
        ]);

        Article::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'body' => $request->body,
            'image' => $request->file('image')->store('public/images'),
            'category_id' => $request->category,
            'user_id' => Auth::user()->id,
        ]);

        return redirect(route('home'))->with('message', 'Articolo creato correttamente!');
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

    
    public function byCategory($categoryName){
        $category = Category::where('name', $categoryName)->firstOrFail();
        $articles = $category->articles->sortByDesc('created_at');
        return view('article.category', compact('category', 'articles'));
}


    public function byUser(User $user){
        
        $articles = $user->articles->sortByDesc('created_at');
        return view('article.user', compact('user', 'articles'));
    }
   
}
