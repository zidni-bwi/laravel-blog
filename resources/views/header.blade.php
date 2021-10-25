<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
  <title>@yield('title')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="{{ asset('js/app.js') }}" defer></script>
  <script src="https://unpkg.com/feather-icons"></script>

  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

  <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>
  <script src="https://unpkg.com/cropperjs"></script>
  <link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css" />
  <script src="https://unpkg.com/dropzone"></script>

  <style>
  .feather-16{
    width: 16px;
    height: 16px;
  }
  .feather-24{
    width: 24px;
    height: 24px;
  }
  .feather-32{
    width: 32px;
    height: 32px;
  }

  .xyz {
    background-size: auto;
    text-align: center;
    padding-top: 100px;
  }
  .btn-circle.btn-sm {
    width: 30px;
    height: 30px;
    padding: 6px 0px;
    border-radius: 15px;
    font-size: 8px;
    text-align: center;
  }
</style>

<script>
feather.replace()
</script>

</head>
<body>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0 text-center" href="/">Blog Sederhana</a>
    <ul class="navbar-nav mr-auto">
    </ul>
    <ul class="navbar-nav px-3">
      @guest
      @if(Route::current()->getName() == 'login'
      or Route::current()->getName() == 'register')
      @else
      <button type="button" class="btn btn-outline-light font-weight-bold text-uppercase mr-2" onclick="document.location='{{ route('login') }}'">{{ __('Login') }}</button>
      <button type="button" class="btn btn-success font-weight-bold text-uppercase" onclick="document.location='{{ route('register') }}'">{{ __('Register') }}</button>
      @endif
      @else
      <li class="nav-item dropdown">
        <a class="nav-link text-light font-weight-bold" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
          <span data-feather="bell"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          @foreach ($notifications as $i => $notification)
          <a class="dropdown-item btn-sm" href="/posts/{{ $notification->id_posts }}">
            @if ($notification->like == NULL)
            <span data-feather="message-square"></span> {{ $notification->name }} Mengomentari Postingan Anda
            @else
            <span data-feather="heart"></span> {{ $notification->name }} Menyukai Postingan Anda
            @endif
          </a>
          @endforeach
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-light font-weight-bold text-uppercase" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
          {{ Auth::user()->name }}
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <center><img src="{{ Auth::user()->photo }}" class="rounded-circle mt-4 mb-3" style="height: 50px;"></center>
          @if (Route::current()->getName() == 'home')
          <a class="dropdown-item btn-sm d-flex justify-content-between align-items-center" href="/dashboard">
            {{ __('Panel Menu') }} <span data-feather="calendar"></span>
          </a>
          @elseif (Route::current()->getName() == 'posts')
          <a class="dropdown-item btn-sm d-flex justify-content-between align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            {{ __('Panel Menu') }} <span data-feather="calendar"></span>
          </a>
          @endif
          <a class="dropdown-item btn-sm d-flex justify-content-between align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            {{ __('Logout') }}<span data-feather="calendar"></span>
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        </div>
      </li>
      @endguest
    </ul>
  </nav>
  @extends('sidebar')
  @if(Route::current()->getName() == 'login'
  or Route::current()->getName() == 'register')
  <main role="main" class="col-md-12 vh-100 bg-white">
    @else
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 bg-white">
      @endif
      <div class="row">
        @yield('main')
        <footer class="px-0 w-100">
        <div class="text-right border-top px-4 btn-sm">
        © 2021 <span data-feather="github"></span> Github: <a class="text-dark" href="https://github.com/zidni-bwi">zidni-bwi</a>
      </div>
    </footer>
      </div>
    </main>
  </body>
  </html>

  <script>
  if (window.File && window.FileReader && window.FileList && window.Blob) {
    document.getElementById('files').addEventListener('change', handleFileSelect, false);
  } else {
    alert('The File APIs are not fully supported in this browser.');
  }
  function handleFileSelect(evt) {
    var f = evt.target.files[0];
    var reader = new FileReader();
    reader.onload = (function(theFile) {
      return function(e) {
        var binaryData = e.target.result;
        var base64String = window.btoa(binaryData);
        document.getElementById('base64').value = "data:image/jpeg;base64,"+ base64String;
        document.getElementById('preview').src = "data:image/jpeg;base64,"+ base64String;
      };
    })(f);
    reader.readAsBinaryString(f);
  }
  </script>

  <script>
  $(document).ready(function(){
    var $modal = $('#modal');
    var image = document.getElementById('sample_image');
    var cropper;
    $('#upload_image').change(function(event){
      var files = event.target.files;
      var done = function(url){
        image.src = url;
        $modal.modal('show');
      };
      if(files && files.length > 0)
      {
        reader = new FileReader();
        reader.onload = function(event)
        {
          done(reader.result);
        };
        reader.readAsDataURL(files[0]);
      }
    });
    $modal.on('shown.bs.modal', function() {
      cropper = new Cropper(image, {
        aspectRatio: 1,
        viewMode: 3,
        preview:'.preview'
      });
    }).on('hidden.bs.modal', function(){
      cropper.destroy();
      cropper = null;
    });
    $('#crop').click(function(){
      canvas = cropper.getCroppedCanvas({
        width:400,
        height:400
      });
      canvas.toBlob(function(blob){
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
        reader.readAsDataURL(blob);
        reader.onloadend = function(){
          var base64data = reader.result;
          $.ajax({
            url:'upload.php',
            method:'POST',
            data:{image:base64data},
            success:function(data)
            {
              $modal.modal('hide');
              $('#uploaded_image').attr('src', data);
            }
          });
        };
      });
    });
  });
  </script>
