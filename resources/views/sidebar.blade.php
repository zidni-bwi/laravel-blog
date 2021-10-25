<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
@if(Route::current()->getName() == 'login'
or Route::current()->getName() == 'register')
@else
<nav id="sidebarMenu" class="col-lg-2 bg-light sidebar">
  <div class="sidebar-sticky py-5 px-4" style="height: calc(100vh - 96px);">
    @if(Route::current()->getName() == 'home')
    <h6 class="sidebar-heading d-flex justify-content-between align-items-center mb-1 text-muted pb-2">
      <span>Urutkan Postingan</span>
      <span data-feather="align-right"></span>
    </h6>
    <ul class="nav flex-column mb-2">
      @if( $_POST == 'a' )
      <li class="nav-item pb-2">
        <form method="post" action="/">
          @csrf
          <input name="orderby" style="display:none" value="a">
          <input type="submit" class="active form-control btn btn-outline-dark" value="Terbaru">
        </form>
      </li>
      @else
      <li class="nav-item pb-2">
        <form method="post" action="/">
          @csrf
          <input name="orderby" style="display:none" value="a">
          <input type="submit" class="form-control btn btn-outline-dark" value="Terbaru">
        </form>
      </li>
      @endif
      @if( $_POST == 'b' )
      <li class="nav-item">
        <form method="post" action="/">
          @csrf
          <input name="orderby" style="display:none" value="b">
          <input type="submit" class="active form-control btn btn-outline-dark" value="Terlama">
        </form>
      </li>
      @else
      <li class="nav-item">
        <form method="post" action="/">
          @csrf
          <input name="orderby" style="display:none" value="b">
          <input type="submit" class="form-control btn btn-outline-dark" value="Terlama">
        </form>
      </li>
      @endif
      @elseif(Route::current()->getName() == 'posts'
      or Route::current()->getName() == 'author')
      <div class="d-flex align-items-center justify-content-center h-100">
        <div>
          <h6 class="sidebar-heading px-3 mb-1 text-muted text-center pb-1">
            <span>Penulis :</span>
          </h6>
          <img class="rounded-circle w-50 img-responsive center-block d-block mx-auto" src="{{ $posts->author_photo }}">
          @if(Route::current()->getName() == 'posts')
          <a class="nav-link text-center text-uppercase" href="/author/{{ $posts->id_author }}">
            {{ $posts->author }}
          </a>
          @else
          <a class="nav-link text-center text-uppercase">
            {{ $posts->author }}
          </a>
          @endif
        </div>
      </div>
      @endif
      @if(Route::current()->getName() == 'dashboard'
      or Route::current()->getName() == 'm_posts'
      or Route::current()->getName() == 'accounts'
      or Route::current()->getName() == 'edit_accounts'
      or Route::current()->getName() == 'add_posts'
      or Route::current()->getName() == 'edit_posts'
      or Route::current()->getName() == 'members')
      <h6 class="sidebar-heading d-flex justify-content-between align-items-center mb-1 text-muted pb-2">
        <span>Menu Panel</span>
        <span data-feather="align-justify"></span>
      </h6>
      <ul class="nav flex-column mb-2">
        @if(Route::current()->getName() == 'dashboard')
        <li class="nav-item pb-2">
          <button type="button" class="active form-control btn btn-outline-dark btn-sm" onclick="location.href='/dashboard'">
            <span data-feather="home"></span> Dashboard
          </button>
        </li>
        @else
        <li class="nav-item pb-2">
          <button type="button" class="form-control btn btn-outline-dark btn-sm" onclick="location.href='/dashboard'">
            <span data-feather="home"></span> Dashboard
          </button>
        </li>
        @endif
        @if(Auth::user()->role == 'Member')
        @if(Route::current()->getName() == 'm_posts'
        or Route::current()->getName() == 'edit_posts'
        or Route::current()->getName() == 'add_posts')
        <li class="nav-item pb-5">
          <button type="button" class="active form-control btn btn-outline-dark btn-sm" onclick="location.href='/posts'">
            <span data-feather="edit-3"></span> Postingan
          </button>
        </li>
        @else
        <li class="nav-item pb-5">
          <button type="button" class="form-control btn btn-outline-dark btn-sm" onclick="location.href='/posts'">
            <span data-feather="edit-3"></span> Postingan
          </button>
        </li>
        @endif
        @endif

        @if(Auth::user()->role == 'Admin')
        @if(Route::current()->getName() == 'members')
        <li class="nav-item pb-5">
          <button type="button" class="active form-control btn btn-outline-dark btn-sm" onclick="location.href='/members'">
            <span data-feather="users"></span> Members
          </button>
        </li>
        @else
        <li class="nav-item pb-5">
          <button type="button" class="form-control btn btn-outline-dark btn-sm" onclick="location.href='/members'">
            <span data-feather="users"></span> Members
          </button>
        </li>
        @endif
        @endif

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center mb-1 text-muted pb-2">
          <span>Pengaturan</span>
          <span data-feather="settings"></span>
        </h6>
        @if(Route::current()->getName() == 'accounts'
        or Route::current()->getName() == 'edit_accounts')
        <li class="nav-item pb-2">
          <button type="button" class="active form-control btn btn-outline-dark btn-sm" onclick="location.href='/accounts'">
            <span data-feather="user"></span> Account
          </button>
        </li>
        @else
        <li class="nav-item pb-2">
          <button type="button" class="form-control btn btn-outline-dark btn-sm" onclick="location.href='/accounts'">
            <span data-feather="user"></span> Account
          </button>
        </li>
        @endif
        @endif
      </div>
  </nav>
  @endif
  <script>
  feather.replace()
</script>
