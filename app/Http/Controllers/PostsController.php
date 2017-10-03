<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Импорт модели - Post
use App\Post;
// --Дополнительно-- для импорта данных через SQL команды
use DB;
Use Illuminate\Support\Facades\Storage;



class PostsController extends Controller
{

      /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show'] ]);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $posts = Post::all();
        
        // Single query
        // $posts = Post::where('title', 'Post Two')->get();

        // Mysql Simple Queries
        // $posts = DB::select('SELECT * FROM posts');

        // Filtering data (1st parameter attirube, 2nd attribude type and then method)
        
        // $posts = Post::orderBy('title', asc)->get();

        // Limiting fetched data by method take(n - number of data)
        // $posts = Post::orderBy('title', 'asc')->take(1)->get();

        // Pagination - setting number of fetched data per page - paginate(number) - seperating data for pages with method {{$posts->links()}}
        $posts = Post::orderBy('created_at','desc')->paginate(10);

        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Валидация формы для добавления поста
        $this -> validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

       // Загрузка файла
       if($request->hasFile('cover_image')) {
           // Запрос имя файла и расширение
           $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
          // Запрос имени файла
           $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
           // Запрос расширения файла 
           $extension = $request->file('cover_image')->getClientOriginalExtension();
           // Сохранение файла
           $fileNameToStore = $filename.'_'.time().'.'.$extension;
           // Загрузка файла в корневую папку - public/cover_images
           $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
       } else {
           $fileNameToStore = 'noimage.jpg';
       }

       // Добавление поста
       $post = new Post;
       $post->title = $request->input('title');
       $post->body = $request->input('body');
       $post->user_id = auth()->user()->id;
       $post->cover_image = $fileNameToStore;
       $post->save();

       return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Fetching data by id
        $post =  Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $post = Post::find($id);

        // Для проверки разрешения пользователя
        if(auth()->user()->id != $post->user_id) {
            return redirect('/posts')->with('error', 'Unaunthorized Page');
        } 
        return view('posts.edit')->with('post', $post);
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
         // Validation adding post form
        $this -> validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

       // Hande File Upload
       if($request->hasFile('cover_image')) {
           // Get filename with the extension
           $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
           // Get just filename
           $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
           // Get just extension 
           $extension = $request->file('cover_image')->getClientOriginalExtension();
           // Filename to store
           $fileNameToStore = $filename.'_'.time().'.'.$extension;
           // Upload image
           $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
       }

       // Create Post
       $post = Post::find($id);
       $post->title = $request->input('title');
       $post->body = $request->input('body');
       if($request->hasFile('cover_image')) {
            $post->cover_image = $fileNameToStore;
       }
        if(auth()->user()->id != $post->user_id) {
            return redirect('/posts')->with('error', 'Unaunthorized Page');
        } 
       $post->save();

       return redirect('/posts')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
         if(auth()->user()->id != $post->user_id) {
            return redirect('/posts')->with('error', 'Unaunthorized Page');
        } 

        if($post->cover_image != 'noimage.jpg') {
            // Delete Image
            
            Storage::delete('public/cover_images/'.$post->cover_image);
            
        }

        $post->delete();

        return redirect('/dashboard')->with('success', 'Post Removed');
    }
}
