<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Http;
use SebastianBergmann\Type\VoidType;

class HomeController extends Controller
{

   public function index()
   {
if (Auth::id())
{
    $post=Post::where('post_status','active')->get();
    $usertype=Auth()->user()->usertype;
    if($usertype=='user')
    {
        return view('home.homepage',compact('post'));
    }
    else if($usertype=='admin')
    {
        return view('admin.adminhome');
    }
    else{
        return redirect()-> back();
    }

   }
}


public function homepage()
{
    $post = Post::where('post_status','active')->get();
    return view('home.homepage',compact('post'));

}


public function desc_page(Request $request, $id)
{
    $post = Post::find($id);
    return view('home.desc_page',compact('post'));

}

public function create_post() 
{
    return view('home.create_post');
}

public function user_post(Request $request) 
{

    $user=Auth()->user();
    $userid=$user->id;
    $name=$user->name;
    $usertype=$user->usertype; 
    
    $post= new Post;          
            $post->title=$request->title;
            $post->description=$request->description;
            $post->post_status='pending';
            $post->user_id=$userid;
            $post->name=$name;
            $post->usertype=$usertype;

            $image= $request->image;
            if($image){
            $imagename=time().'.'.$image->getClientOriginalExtension();
            $request->image->move('postimage',$imagename);
            $post->image=$imagename;
            }
            $post->save();
        
        return redirect()->back()->with('message','Post Added Successfully');
}

public function my_post() 
{
    if (Auth::check()) {
        $usertype = Auth::user()->usertype;
        if ($usertype == 'user') {
            $post = Post::where('user_id', '1')->get();
            return view('home.homepage', compact('post'));
        }
    }   
    return redirect()->route('login'); 
}

public function deletemenu($id)
{
    $data = post::find($id);
    $data->delete();
    return redirect()->back();
}


public function edit_page($id)
{
   $posts=Post::find($id);
    return view('home.edit_page',compact('posts'));
}

public function update_post(Request $request,$id)
{
   $data=Post::find($id);
   $data->title=$request->title;
   $data->description=$request->description;
   $image=$request->image;

   $oldImage = $data->image; // Get the old image file name
  



   if($image)
   {
    $imagename=time().'.'.$image->getClientOriginalExtension();
    $request->image->move('postimage',$imagename);
    $data->image=$imagename;
   

    if ($oldImage) {
        $oldImagePath = public_path('postimage/'.$oldImage);
        if (file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }
    }

   }
   
$data->save();


return redirect()->back()->with('message','Post updated');


    
}



}