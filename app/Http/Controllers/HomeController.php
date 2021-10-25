<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;
class HomeController extends Controller
{

  private function is_login()
  {
    if(Auth::user()) {
      return true;
    }
    else
    {
      return false;
    }
  }

  public function index(Request $input)
  {
    if($input->orderby == 'a'){
      if($this->is_login()){
        $notification = $this->notification();
        $posts = DB::table('posts')->orderby('posts.created_at', 'desc')->get();
        $_POST = 'a';
        return view('index', ['posts'=>$posts, 'notifications'=>$notification]);
      }
      else {
        $posts = DB::table('posts')->orderby('posts.created_at', 'desc')->get();
        $_POST = 'a';
        return view('index', ['posts'=>$posts]);
      }
    }
    elseif($input->orderby == 'b'){
      if($this->is_login()){
        $notification = $this->notification();
        $posts = DB::table('posts')->orderby('posts.created_at', 'asc')->get();
        $_POST = 'b';
        return view('index', ['posts'=>$posts, 'notifications'=>$notification]);
      }
      else {
        $posts = DB::table('posts')->orderby('posts.created_at', 'asc')->get();
        $_POST = 'b';
        return view('index', ['posts'=>$posts]);
      }
    }
    else{
      if($this->is_login()){
        $notification = $this->notification();
        $posts = DB::table('posts')->inRandomOrder()->get();
        return view('index', ['posts'=>$posts, 'notifications'=>$notification]);
      }
      else {
        $posts = DB::table('posts')->inRandomOrder()->get();
        return view('index', ['posts'=>$posts]);
      }
    }
  }

  public function notification()
  {
    $id_user = Auth::user()->id;
    $notification = DB::table('notification')->select('b.name AS name', 'notification.id_likes AS like', 'notification.id_comments AS comment', 'notification.id_posts AS id_posts', 'notification.created_at AS date')->leftjoin('posts AS a', 'a.id', '=', 'notification.id_posts')->leftjoin('users AS b', 'a.id_users', '=', 'b.id')->orderby('notification.created_at','desc')->where('a.id_users', '=', $id_user)->get();
    return $notification;
  }

  public function posts($input)
  {
    if($this->is_login()){
      $post = DB::table('posts')
      ->select('posts.title AS title', 'posts.content AS content', 'a.name AS author', 'a.photo AS author_photo', 'a.id AS id_author', 'posts.id AS id_posts', 'posts.created_at AS date', 'posts.thumbnail AS thumbnail')
      ->leftjoin('users AS a','a.id','=','posts.id_users')
      ->where('posts.id', $input)
      ->first();
      $id_user = Auth::user()->id;
      $notification = $this->notification();
      $comment = DB::table('comments')
      ->select('a.name AS name', 'comments.created_at AS date', 'comments.content AS content', 'comments.id_users AS id_users')
      ->leftjoin('users AS a','a.id','=','comments.id_users')
      ->orderbyRaw('comments.created_at','comments.id_users = $id_users')
      ->where('comments.id_posts', '=', $input)
      ->get();
      $count_like = count(DB::table('likes')->where('likes.id_posts', '=', $input)->get());
      $liked = count(DB::table('likes')->where('likes.id_posts', '=', $input)->where('likes.id_users', '=', $id_user)->get());
      $commented = count(DB::table('comments')->where('comments.id_posts', '=', $input)->where('comments.id_users', '=', $id_user)->get());
      return view('posts', ['posts'=>$post, 'comments'=>$comment, 'count_likes'=>$count_like, 'liked'=>$liked, 'commented'=>$commented, 'notifications'=>$notification]);
    }
    else {
      $count_like = count(DB::table('likes')->where('likes.id_posts', '=', $input)->get());
      $comment = DB::table('comments')->select('a.name AS name', 'comments.created_at AS date', 'comments.content AS content', 'comments.id_users AS id_users')->leftjoin('users AS a','a.id','=','comments.id_users')->orderby('comments.created_at','desc')->where('comments.id_posts', '=', $input)->get();
      $post = DB::table('posts')->select('posts.thumbnail AS thumbnail', 'posts.title AS title', 'posts.content AS content', 'a.name AS author', 'a.id AS id_author', 'posts.created_at AS date', 'a.photo AS author_photo')->leftjoin('users AS a','a.id','=','posts.id_users')->where('posts.id', $input)->first();
      return view('posts', ['posts'=>$post, 'count_likes'=>$count_like, 'comments'=>$comment]);
    }
  }

  public function author($id)
  {
    if($this->is_login()){
      $notification = $this->notification();
      $post = DB::table('posts')->select('a.photo AS author_photo', 'a.name AS author', 'posts.title AS title','posts.id AS id', 'a.id AS id_author', 'posts.thumbnail AS thumbnail', 'posts.content AS content')->leftjoin('users AS a','a.id','=','posts.id_users')->where('posts.id_users', $id)->orderby('posts.created_at', 'desc')->get();
      return view('author', ['posts'=>$post, 'notifications'=>$notification]);
    }
    else {
      $post = DB::table('posts')->select('a.photo AS author_photo', 'a.name AS author', 'posts.title AS title','posts.id AS id', 'a.id AS id_author', 'posts.thumbnail AS thumbnail', 'posts.content AS content')->leftjoin('users AS a','a.id','=','posts.id_users')->where('posts.id_users', $id)->orderby('posts.created_at', 'desc')->get();
      return view('author', ['posts'=>$post]);
    }
  }

  public function like($id_post)
  {
    $id_user = Auth::user()->id;
    DB::table('likes')->insert(['id_users'=>$id_user,'id_posts'=>$id_post]);
    $likes = DB::table('likes')->where('id_users', '=', $id_user)->where('id_posts', '=', $id_post)->first();
    $id_likes = DB::table('likes')->where('id_users', '=', $id_user)->where('id_posts', '=', $id_post)->first();
    DB::table('notification')->insert(['id_users'=>$id_user, 'id_posts'=>$id_post, 'id_likes'=>$likes->id]);
    return redirect()->action('HomeController@posts',['id' => $id_post]);
  }

  public function unlike($id_post)
  {
    $id_user = Auth::user()->id;
    DB::table('likes')->where('id_users', '=', $id_user)->where('id_posts', '=', $id_post)->delete();
    return redirect()->action('HomeController@posts',['id' => $id_post]);
  }

  public function uncomment($id_post)
  {
    $id_user = Auth::user()->id;
    DB::table('comments')->where('id_users', '=', $id_user)->where('id_posts', '=', $id_post)->delete();
    return redirect()->action('HomeController@posts',['id' => $id_post]);
  }

  public function comment(Request $input)
  {
    $id_user = Auth::user()->id;
    $id_post = $input->id_posts;
    $content = $input->content;
    DB::table('comments')->insert(['id_users'=>$id_user, 'id_posts'=>$id_post, 'content'=>$content]);
    $comment = DB::table('comments')->where('id_users', '=', $id_user)->where('id_posts', '=', $id_post)->first();
    DB::table('notification')->insert(['id_users'=>$id_user, 'id_posts'=>$id_post, 'id_comments'=>$comment->id]);

    return redirect()->action('HomeController@posts',['id' => $id_post]);
  }

  public function edit_comment(Request $input)
  {
    $id_post = $input->id_posts;
    $id_user = Auth::user()->id;
    $comment = DB::table('comments')->where('id_users', '=', $id_user)->where('id_posts', '=', $id_post)->first();
    $id_comment = $comment->id;

    DB::table('comments')->where('id_posts', '=', $id_post)->where('id_users', '=', $id_user)->update(['content' => $input->content]);
    return redirect()->action('HomeController@posts',['id' => $id_post]);
  }

}
