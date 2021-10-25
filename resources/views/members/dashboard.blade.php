<!-- menggunakan kerangka dari master.blade.php -->


@extends('header')

@section('title', 'Dashboard')

@section('main')
<div class="col-md-12 px-4 pt-5 bg-white py-5 px-4" style="min-height: calc(100vh - 75px);">
  <div class="row">
    <div class="col-sm">
      <div class="card">
        <div class="card-header bg-secondary text-white py-2">
          <h5 class="card-title my-0">Total Postingan</h5>
        </div>
        <div class="card-body">
          <h1 class="text-center display-5 my-0 py-0 align-middle">{{ $total_posts }}</h1>
        </div>
      </div>
    </div>
    <div class="col-sm">
      <div class="card">
        <div class="card-header bg-secondary text-white py-2">
          <h5 class="card-title my-0">Total Like</h5>
        </div>
        <div class="card-body">
          <h1 class="text-center display-5 my-0 py-0 align-middle">{{ $total_likes }}</h1>
        </div>
      </div>
    </div>
    <div class="col-sm">
      <div class="card">
        <div class="card-header bg-secondary text-white py-2">
          <h5 class="card-title my-0">Total Komentar</h5>
        </div>
        <div class="card-body">
          <h1 class="text-center display-5 my-0 py-0 align-middle">{{ $total_comments }}</h1>
        </div>
      </div>
    </div>
  </div>
  <div class="row py-4">
    <div class="col-sm">
      <div class="card">
        <div class="card-header bg-secondary text-white py-2">
          <h5 class="card-title my-0">Postingan Dengan Like Terbanyak</h5>
        </div>
        <div class="card-body">
          @if($post_likes->postis == 0)
          <p class="text-center my-0 py-0 align-middle">Belum Ada</p>
          @else
          <table class="table">
            <thead>
              <tr>
                <th scope="col" class="border-top-0">Judul</th>
                <th scope="col" class="border-top-0">Jumlah Like</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><a href="/posts/{{ $post_likes->id }}">{{ $post_likes->title }}</a></td>
                <td>{{ $post_likes->postis }}</td>
              </tr>
            </tbody>
          </table>
          @endif
        </div>
      </div>
    </div>
    <div class="col-sm">
      <div class="card">
        <div class="card-header bg-secondary text-white py-2">
          <h5 class="card-title my-0">Postingan Dengan Komentar Terbanyak</h5>
        </div>
        <div class="card-body">
          @if($post_comments->postis == 0)
          <p class="text-center my-0 py-0 align-middle">Belum Ada</p>
          @else
          <table class="table">
            <thead>
              <tr>
                <th scope="col" class="border-top-0">Judul</th>
                <th scope="col" class="border-top-0">Jumlah Komen</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><a href="/posts/{{ $post_likes->id }}">{{ $post_comments->title }}</a></td>
                <td>{{ $post_comments->postis }}</td>
              </tr>
            </tbody>
          </table>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
