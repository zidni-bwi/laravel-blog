<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Session;
use Auth;
class MenuController extends Controller
{

  private function is_admin()
  {
    if(Auth::user()) {
      if(Auth::user()->role == 'Admin') {
        return true;
      }
      else {
        return false;
      }
    }
    else {
      return false;
    }
  }

  private function is_members()
  {
    if(Auth::user()) {
      if(Auth::user()->role == 'Member') {
        return true;
      }
      else {
        return false;
      }
    }
    else {
      return false;
    }
  }

  public function notification()
  {
    $id_user = Auth::user()->id;
    $notification = DB::table('notification')->select('b.name AS name', 'notification.id_likes AS like', 'notification.id_comments AS comment', 'notification.id_posts AS id_posts', 'notification.created_at AS date')->leftjoin('posts AS a', 'a.id', '=', 'notification.id_posts')->leftjoin('users AS b', 'a.id_users', '=', 'b.id')->orderby('notification.created_at','desc')->where('a.id_users', '=', $id_user)->get();
    return $notification;
  }

  public function dashboard()
  {
    if($this->is_admin())
    {
      $total_member = count(DB::table('users')->where('role', '=', 'Member')->get());
      $total_post = count(DB::table('posts')->get());
      $most_post = DB::table('users')->select('users.id AS id', 'users.name AS name', 'users.email AS email', DB::raw('count(a.id) as postis'))->leftjoin('posts AS a','a.id_users','=','users.id')->groupby('users.id')->having('users.id', '>' ,1)->orderby('postis','desc')->first();
      $post_like = DB::table('posts')->select('posts.title AS title', DB::raw('count(a.id_posts) as postis'), 'posts.id AS id')->leftjoin('likes AS a','a.id_posts','=','posts.id')->groupby('posts.id')->orderby('postis','desc')->first();
      $post_comment = DB::table('posts')->select('posts.title', DB::raw('count(a.id_posts) as postis'), 'posts.id AS id')->leftjoin('comments AS a','a.id_posts','=','posts.id')->groupby('posts.id')->orderby('postis','desc')->first();
      $notification = $this->notification();
      return view('admin/dashboard', ['notifications'=>$notification, 'total_members'=>$total_member, 'total_posts'=>$total_post, 'most_posts'=>$most_post, 'post_likes'=>$post_like, 'post_comments'=>$post_comment]);
    }
    elseif($this->is_members())
    {
      $id_m = Auth::user()->id;
      $total_post = count(DB::table('posts')->where('posts.id_users', '=', $id_m)->get());
      $total_like = count(DB::table('posts')->select('a.id_posts')->leftjoin('likes AS a', 'a.id_posts', '=', 'posts.id')->where('posts.id', '=', 'a.id_posts')->where('posts.id_users', '=', $id_m)->groupby('a.id_posts')->get());
      $total_comment = count(DB::table('posts')->select('a.id_posts')->leftjoin('comments AS a', 'a.id_posts', '=', 'posts.id')->where('posts.id', '=', 'a.id_posts')->where('posts.id_users', '=', $id_m)->groupby('a.id_posts')->get());
      $post_like = DB::table('posts')->select('posts.title AS title', DB::raw('count(a.id_posts) as postis'), 'posts.id AS id')->leftjoin('likes AS a','a.id_posts','=','posts.id')->where('posts.id_users', '=', $id_m)->groupby('posts.id')->orderby('postis','desc')->first();
      $post_comment = DB::table('posts')->select('posts.title', DB::raw('count(a.id_posts) as postis'), 'posts.id AS id')->leftjoin('comments AS a','a.id_posts','=','posts.id')->where('posts.id_users', '=', $id_m)->groupby('posts.id')->orderby('postis','desc')->first();
      $notification = $this->notification();
      return view('members/dashboard', ['notifications'=>$notification, 'total_posts'=>$total_post, 'total_likes'=>$total_like, 'total_comments'=>$total_comment, 'post_likes'=>$post_like, 'post_comments'=>$post_comment]);
    }
    else
    {
      return redirect('/login');
    }
  }

  public function delete_members($input)
  {
    if($this->is_admin())
    {
      DB::table('users')->where('id', $input)->delete();
      Session::flash('success', 'Member berhasil dihapus');
      return redirect()->action('MenuController@members');
    }
    else
    {
      return redirect('/login');
    }
  }

  public function posts()
  {
    if($this->is_admin())
    {
      $id_m = Auth::user()->id;
      $articles = DB::table('artikel')->orderby('id', 'desc')->where('id_m', '=', $id_m)->get();
      return view('members/posts', ['articles'=>$articles]);
    }
    elseif($this->is_members())
    {
      $notification = $this->notification();
      $id_users = Auth::user()->id;
      $posts = DB::table('posts')->orderby('id', 'desc')->where('id_users', '=', $id_users)->get();
      return view('members/posts', ['posts'=>$posts, 'notifications'=>$notification]);
    }
    else {
      return redirect('/login');
    }
  }

  public function members()
  {
    if($this->is_admin())
    {
      $notification = $this->notification();
      $member = DB::table('users')->select('users.id AS id', 'users.name AS name', 'users.email AS email', DB::raw('count(a.id) as postis'))->leftjoin('posts AS a','a.id_users','=','users.id')->groupby('users.id')->having('users.id', '>' ,1)->get();
      return view('admin/members', ['members'=>$member, 'notifications'=>$notification]);
    }
    else
    {
      return redirect('/login');
    }
  }

  public function add_posts()
  {
    if($this->is_members())
    {
      $notification = $this->notification();
      return view('members/add_posts',['notifications'=>$notification]);
    }
    else
    {
      return redirect('/login');
    }
  }

  public function add_posts_process(Request $posts)
  {
    $id_users = Auth::user()->id;
    DB::table('posts')->insert([
      'title'=>$posts->title,
      'content'=>$posts->content,
      'id_users'=>$id_users,
      'thumbnail'=>$posts->thumbnail
    ]);
    Session::flash('success', 'Artikel berhasil dibuat');
    return redirect()->action('MenuController@posts');
  }

  public function edit_posts($id)
  {
    $notification = $this->notification();
    $post = DB::table('posts')->where('id', $id)->first();
    return view('members/edit_posts', ['posts'=>$post, 'notifications'=>$notification]);
  }

  public function edit_posts_process(Request $article)
  {
    $id = $article->id;
    $judul = $article->title;
    $deskripsi = $article->content;
    $thumbnail = $article->thumbnail;
    DB::table('posts')->where('id', $id)->update(['title' => $judul, 'content' => $deskripsi, 'thumbnail' => $thumbnail]);
    Session::flash('success', 'Artikel berhasil diedit');
    return redirect()->action('MenuController@posts');
  }

  public function delete_posts($id)
  {
    if($this->is_members())
    {
      DB::table('posts')->where('id', $id)->delete();
      Session::flash('success', 'Postingan berhasil dihapus');
      return redirect()->action('MenuController@posts');
    }
    else
    {
      return redirect('/login');
    }
  }

  public function accounts()
  {
    if($this->is_admin())
    {
      $notification = $this->notification();
      $id = Auth::user()->id;
      $accounts = DB::table('users')->where('id', '=', $id)->first();
      return view('admin/accounts', ['accounts'=>$accounts, 'notifications'=>$notification]);
    }
    elseif($this->is_members())
    {
      $notification = $this->notification();
      $id = Auth::user()->id;
      $accounts = DB::table('users')->where('id', '=', $id)->first();
      return view('members/accounts', ['accounts'=>$accounts, 'notifications'=>$notification]);
    }
    else {
      return redirect('/login');
    }
  }

  public function edit_accounts_process(Request $input)
  {
    $id = Auth::user()->id;
    $name = $input->name;
    $email = $input->email;
    $photo = $input->photo;
    $password = Hash::make($input->password);
    DB::table('users')->where('id', $id)->update(['name' => $name, 'email' => $email, 'photo' => $photo, 'password' => $password, 'updated_at' => now()]);
    return redirect()->action('MenuController@accounts');
  }

  public function edit_accounts()
  {
    if($this->is_admin())
    {
      $notification = $this->notification();
      $id = Auth::user()->id;
      $accounts = DB::table('users')->where('id', '=', $id)->first();
      return view('admin/accounts', ['accounts'=>$accounts, 'notifications'=>$notification]);
    }
    elseif($this->is_members())
    {
      $notification = $this->notification();
      $id = Auth::user()->id;
      $accounts = DB::table('users')->where('id', '=', $id)->first();
      return view('members/accounts', ['accounts'=>$accounts, 'notifications'=>$notification]);
    }
    else {
      return redirect('/login');
    }
  }

}
