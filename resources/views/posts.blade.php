@extends('header')

<!-- memberikan judul di tab sesuai dengan judul artikel yang sedang dibaca -->
@section('title')
{{ $posts->title }}
@endsection

@section('main')
<div class="col-md-12">
  <div class="row">
    <div class="col-md-8 px-4 border-right py-5" style="min-height: calc(100vh - 75px);">
      <h5 class="text-center font-weight-bold">{{ $posts->title }}</h5>
      <div class="container px-0 pt-4">
        <div class="row">
          <div class="col-8 text-left">
            <button type="button" class="btn btn-sm btn btn-outline-secondary btn-circle" onclick="document.getElementById('files').click()" disabled>
              <span data-feather="user"></span>
            </button>
            <button type="button" class="btn btn-sm btn btn-white" onclick="document.getElementById('files').click()" disabled>
              By {{ $posts->author }}
            </button>
            <button type="button" class="btn btn-sm btn btn-outline-secondary btn-circle" onclick="document.getElementById('files').click()" disabled>
              <span data-feather="calendar"></span>
            </button>
            <button type="button" class="btn btn-sm btn btn-white" onclick="document.getElementById('files').click()" disabled>
              Posted {{ $posts->date }}
            </button>
          </div>
          <div class="col-4 text-right">
            <button type="button" class="px-0 btn btn-sm btn btn-white" onclick="document.getElementById('files').click()" disabled>
              {{$count_likes}}
            </button>
            @guest
            <button type="button" class="btn btn-sm btn btn-outline-success btn-circle" onclick="document.getElementById('files').click()" disabled>
              <span data-feather="heart"></span>
            </button>
            @endguest

            @auth
            @if ($liked == 1)
            <button type="button" class="btn btn-sm btn btn-outline-primary btn-circle" onclick="location.href='/unlike/{{ $posts->id_posts }}'">
              <span data-feather="heart"></span>
            </button>
            @elseif ($liked == 0)
            <button type="button" class="btn btn-sm btn btn-outline-secondary btn-circle" onclick="location.href='/like/{{ $posts->id_posts }}'">
              <span data-feather="heart"></span>
            </button>
            @endif
            @endauth
          </div>
        </div>
      </div>
      <br>
      <div id="lipsum" align="justify">
        <p class="text-justify">{{ $posts->title }}</p>
      </div>
      {!! $posts->content !!}
    </div>
    <div class="col-sm-4 bg-light px-4 py-5">
      <img src="{{ $posts->thumbnail }}" class="img-thumbnail img-fluid">
      <h5 class="font-weight-bold text-uppercase pt-3">Komentar</h5>

      @guest
      @foreach ($comments as $i => $comment)
      <h6 class="sidebar-heading d-flex justify-content-between align-items-center mt-4 mb-1 text-muted">
        <span>{{ $comment->date }}</span>
      </h6>
      <h6 class="font-weight-bold">{{ $comment->name }}</h6> <a>{{ $comment->content }}</a>
      @endforeach
      @endguest

      @auth
      @if ($commented == 0)
      <form method="post" action="/comment/{{ $posts->id_posts }}">
        @csrf
        <div class="form-group mb-2">
          <input type="hidden" value="{{ $posts->id_posts }}" name="id_posts">
          <textarea class="form-control" name="content" rows="2" placeholder="Tulis Komentar . . ."></textarea>
        </div>
        <input type="submit" class="btn btn-outline-primary w-100 mt-4" value="Beri Komentar">
      </form>
      @endif
      @foreach ($comments as $i => $comment)
      <h6 class="sidebar-heading d-flex justify-content-between align-items-center mt-4 mb-1 text-muted">
        <span>{{ $comment->date }}</span>
        @if (Auth::user()->id == $comment->id_users)
        <a class="d-flex align-items-center text-muted" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
          <span data-feather="more-vertical"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/uncomment/{{ $posts->id_posts }}">Hapus</a>
          <a class="dropdown-item" data-toggle="collapse" href="#edit_comment" role="button" aria-expanded="false" aria-controls="edit_comment">Edit</a>
        </div>
      </h6>
      <h6 class="font-weight-bold">{{ $comment->name }}</h6> <a>{{ $comment->content }}</a>
      <ul class="submenu collapse" id="edit_comment">
        <form method="post" action="/edit_comment/{{ $posts->id_posts }}">
          @csrf
          <div class="form-group">
            <input type="hidden" value="{{ $posts->id_posts }}" name="id_posts">
            <textarea class="form-control" name="content" rows="5" placeholder="Tulis Komentar . . .">
              {{ $comment->content }}</textarea>
              <input type="submit" class="form-control btn btn-primary" value="Update">
            </div>
          </form>
        </ul>
        @else
      </h6>
      <h6 class="font-weight-bold">{{ $comment->name }}</h6> <a>{{ $comment->content }}</a>
      @endif
      @endforeach
      @endauth

    </div>
  </div>
</div>
@endsection
