<!-- menggunakan kerangka dari master.blade.php -->


@extends('header')

@section('title', 'Dashboard')

@section('main')
<div class="col-md-12 px-4 pt-5 bg-white pt-5 px-4" style="min-height: calc(100vh - 75px);">
  <div class="row">
    <div class="col-sm">
      <div class="card">
        <div class="card-header bg-secondary text-white py-2">
          <h5 class="card-title my-0">Total Member</h5>
        </div>
        <div class="card-body">
          @if($most_posts->postis == 0)
          <p class="text-center my-0 py-0 align-middle">Belum Ada</p>
          @else
          <table class="table my-0">
            <thead>
              <tr>
                <th scope="col" class="border-top-0">Akumulasi Members</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{ $total_members }}</td>
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
          <h5 class="card-title my-0">Total Postingan</h5>
        </div>
        <div class="card-body">
          @if($most_posts->postis == 0)
          <p class="text-center my-0 py-0 align-middle">Belum Ada</p>
          @else
          <table class="table my-0">
            <thead>
              <tr>
                <th scope="col" class="border-top-0">Akumulasi Postingan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{ $total_posts }}</td>
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
          <h5 class="card-title my-0">Member Dengan Post Terbanyak</h5>
        </div>
        <div class="card-body">
          @if($most_posts->postis == 0)
          <p class="text-center my-0 py-0 align-middle">Belum Ada</p>
          @else
          <table class="table my-0">
            <thead>
              <tr>
                <th scope="col" class="border-top-0">Nama Member</th>
                <th scope="col" class="border-top-0">Jumlah Postingan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><a href="/author/{{ $most_posts->id }}">{{ $most_posts->name }}</a></td>
                <td>{{ $most_posts->postis }}</td>
              </tr>
            </tbody>
          </table>
          @endif
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
          <table class="table my-0">
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
          <table class="table my-0">
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
