<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Post;
use App\Category;
use App\Tag;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title'=>'required|max:250',
            'content'=>'required|min:5',
            'category_id'=>'required|exists:categories,id',
            'tags[]'=>'exists:tags,id',
            'image'=>'nullable|image'

        ], [
            'title.required' => 'Titolo deve essere valorizzato',
            'content.required' => ':attribute deve essere compilato',
            'category_id.exists' => 'La categoria selezionata non esiste',
            'tag[]' => 'Il tag non esiste',
            'image' =>'Il file deve essere un\'immagine'
        ]);

        $postData = $request->all();

        //img e faccio il controllo se esiste già
        if(array_key_exists('image', $postData)){
            $img_path = Storage::put('uploads', $postData['image']);
            //1° metodo => aggiungo in Post $fillabe 'cover' => $postData['cover'] = $img_path
        }



        $newPost = new Post();

        $newPost->cover = $img_path; //salvo l'img 2° metodo

        $newPost->fill($postData);

        //slug
        $slug=Str::slug($newPost->title);
        $alternativeSlug = $slug;

        $postFound = Post::where('slug', $slug)->first();
        $counter = 1;
        while($postFound){
            $alternativeSlug = $slug . '_' . $counter;
            $counter ++;
            $postFound = Post::where('slug', $alternativeSlug)->first();
        }
        $newPost->slug = $alternativeSlug;
        $newPost->save();
        //add tag
        if(array_key_exists('tags', $postData)){
            $newPost->tags()->sync($postData['tags']);
        }

        $newPost->save();
        return redirect()->route('admin.posts.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $post = Post::find($id);
        $category = Category::find($post->category_id);
        if($post){
            return view('admin.posts.show', compact('post', 'category'));
        }else{
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post = Post::findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();



        return view('admin.posts.edit', compact('post', 'categories', 'tags'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'title'=>'required|max:250',
            'content'=>'required',
            'category_id'=>'required|exists:categories,id',


        ]);
        $post = Post::findOrFail($id);
        $postData = $request->all();

        //img
        if(array_key_exists('image', $postData)){
            Storage::delete($post->cover);
            $img_path = Storage::put('uploads', $postData['image']);
            $postData['cover'] = $img_path; //1° metodo => aggiungo in Post $fillabe 'cover' =>
        }

        //$post->cover = $img_path; //salvo l'img 2° metodo

        //$post = new Post();
        $post->fill($postData);
    //slug
        $slug=Str::slug($post->title);
        $alternativeSlug = $slug;

        $postFound = Post::where('slug', $slug)->first();
        $counter = 1;
        while($postFound){
            $alternativeSlug = $slug . '_' . $counter;
            $counter ++;
            $postFound = Post::where('slug', $alternativeSlug)->first();
        }
        $post->slug = $alternativeSlug;
    //fine slug

        //add tag
        if(array_key_exists('tags', $postData)){
            $post->tags()->sync($postData['tags']);
        }

        $post->update();
        return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $post = Post::find($id);
        $post->tags()->sync([]);
        $post->delete();
        return redirect()->route('admin.posts.index');
    }
}
