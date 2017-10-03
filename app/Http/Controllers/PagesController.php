<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Импорт модели - Post
use App\Post;
// --Дополнительно-- для импорта данных через SQL команды
use DB;
Use Illuminate\Support\Facades\Storage;

class PagesController extends Controller
{


    public function index() {
        $posts = Post::orderBy('created_at','desc')->paginate(3);
        // return view('pages.index', compact('title'));
        return view('pages.index')->with('posts', $posts);
    }

    public function about() {
        $title = 'About Us';
        return view('pages.about')->with('title', $title);
    }

    public function contacts() {
        $title = 'Contact Us';

        return view('pages.contacts')->with('title', $title);
    }

    public function news() {
        $posts = Post::orderBy('created_at','desc')->paginate(10);

        return view('pages.news')->with('posts', $posts);
    }

    public function products() {
        $title = 'Our Products';
        $data = array(
            'title' => 'Services',
            'services' => ['Web Design', 'Programming', 'SEO']
        );
        return view('pages.products')->with('title', $title);
    }
}
