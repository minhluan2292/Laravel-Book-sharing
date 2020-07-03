<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Post;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show','index']]);
    }

    public function index()
    {
        if(\Auth::check())
        {
            $users = auth()->user()->following()->pluck('profiles.user_id');

            $posts = Post::whereIn('user_id',$users)->with('user')->latest()->paginate(3);
            
            return view('posts.index', compact('posts'));
        }
        else
        {

            $posts = Post::latest()->paginate(3);
            
            return view('posts.index', compact('posts'));
        }

    }

    public function create()
    {
        return view('posts.create');
    }

    public function store()
    {

        $data = request()->validate([
            'caption' => 'required',
            'image' => ['required', 'image']
        ]);

        // $imagePath = request('image')->store('uploads','public');
        // $image = Image::make(public_path("$imagePath"))->fit(1200,1200);
        // $image->save();

        

        //$file = request('image');


        //$fileName = time() . '-' . $file->getClientOriginalName();

        //$img=Image::make('public/uploads/', $file->getRealPath())->resize(320, 240)->save('public/uploads/',$fileName);
        //$file->move('uploads', $fileName);

        //$file->move('public/uploads', $fileName);
	//dd(request()->getHttpHost()."/public/uploads/{$fileName}");
	//$imgPath = request()->getHttpHost()."/public/uploads/{$fileName}";
//dd($file->getRealPath());
        //$image = Image::make($imgPath)->fit(1200,1200);
        //$image->save();
            
        // $img = Image::make($file->getRealPath())
        //     ->resize(1200, 1200)
        //     ->save('public/uploads/', $file->getClientOriginalName());
$originalImage= request('image');
        $thumbnailImage = Image::make($originalImage);
        $thumbnailPath = public_path().'/uploads/';
        $originalPath = public_path().'/images/';
        $thumbnailImage->save($originalPath.time().$originalImage->getClientOriginalName());
        $thumbnailImage->resize(1200,1200);
        $thumbnailImage->save($thumbnailPath.time().$originalImage->getClientOriginalName());

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $thumbnailImage->basename
        ]);

        return redirect('/profile/' . auth()->user()->id);
    }

    public function show(Post $post)
    {
        return view('posts.show',compact('post'));
    }
}
