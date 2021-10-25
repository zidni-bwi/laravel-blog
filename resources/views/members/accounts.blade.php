@extends('header')

@section('title', 'Profile')

@section('main')
<style>
.fill {
  min-height: 100%;
  height: 100%;
}

</style>
<div class="col-md-12 bg-white px-4 py-5" style="min-height: calc(100vh - 75px);">
  @if(Route::current()->getName() == 'accounts')
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-header">
          Pengaturan Profile
        </div>
        <div class="card-body">
          <div class="row d-flex align-items-center justify-content-center h-100">
            <div class="col">
              <div class="form-group">
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center py-2 text-muted">
                  <span>Nama</span>
                  <span class="font-weight-bold text-dark">{{ $accounts->name }}</span>
                </h6>
              </div>
              <div class="form-group">
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center py-2 text-muted">
                  <span>Email</span>
                  <span class="font-weight-bold text-dark">{{ $accounts->email }}</span>
                </h6>
              </div>
              <div class="form-group">
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center py-2 text-muted">
                  <span>Tanggal Registrasi</span>
                  <span class="font-weight-bold text-dark">{{ $accounts->created_at }}</span>
                </h6>
              </div>
              <div class="form-group">
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center py-2 text-muted">
                  <span>Terakhir Di Ubah</span>
                  <span class="font-weight-bold text-dark">{{ $accounts->updated_at }}</span>
                </h6>
              </div>
            </div>
            <div class="col">
              <img src="{{ $accounts->photo }}" class="card-img-top card-img-top rounded-circle w-75 img-responsive center-block d-block mx-auto" alt="gambar" >
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col text-center">
              <button type="button" class=" form-control btn btn-sm btn-outline-secondary" onclick="window.location.href='/edit_accounts'">
                <span data-feather="edit-3">
                </span> Edit Profile
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @elseif(Route::current()->getName() == 'edit_accounts')

  <style>

  .image_area {
    position: relative;
  }

  .preview {
    overflow: hidden;
    width: 160px;
    height: 160px;
    margin: 10px;
    border: 1px solid red;
  }

  .modal-lg{
    max-width: 1000px !important;
  }

  .overlay {
    position: absolute;
    bottom: 15px;
    left: 0;
    right: 0;
    background-color: rgba(255, 255, 255, 0.5);
    overflow: hidden;
    height: 0;
    transition: .3s ease;
    width: 100%;
  }

  .image_area:hover .overlay {
    height: 50%;
    cursor: pointer;
  }

  .text {
    color: #333;
    font-size: 20px;
    position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    text-align: center;
  }

  .cropper-crop-box, .cropper-view-box {
    border-radius: 50%;
  }

  .cropper-view-box {
    box-shadow: 0 0 0 1px #39f;
    outline: 0;
  }

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

  </style>

  <script>

  $(document).ready(function(){
    var $modal = $('#modal');
    var image = document.getElementById('sample_image');
    var cropper;

    $('#upload_image').change(function(event){
      var files = event.target.files;
      var done = function(url){
        image.src = url;
        $('#crop').attr('disabled',false);
        $('#crop').html('Crop');
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
      $('#crop').attr('disabled','disabled');
      $('#crop').html('<i class="fa fa-circle-o-notch fa-spin"></i> Wait...');
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
          $modal.modal('hide');
          $('#uploaded_image').attr('src', base64data);
          $('#preview').attr('src', base64data);
          $('#base64').attr('value', base64data);

        };
      });
    });
  });
  </script>


  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-header">
          Pengaturan Profile
        </div>
        <div class="card-body">
          <form method="post" action="/edit_accounts_process">
            @csrf
            <div class="row d-flex align-items-center justify-content-center h-100">
              <div class="col">
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" class="form-control" value="{{ $accounts->name }}" name="name" placeholder="Nama">
                </div>
                <div class="form-group">
                  <label>E-Mail</label>
                  <input type="text" class="form-control" value="{{ $accounts->email }}" name="email" placeholder="E-Mail">
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input type="password" class="form-control" name="password">
                </div>
              </div>
              <div class="col">
                <div class="image_area">
                  <label for="upload_image">
                    <img src="{{ $accounts->photo }}" id="uploaded_image" class="img-responsive card-img-top rounded-circle w-75 img-responsive center-block d-block mx-auto" />
                    <div class="overlay">
                      <div class="text"><span class="feather-32" data-feather="camera"></div>
                      </div>
                      <input type="file" name="image" class="image" id="upload_image" style="display:none" />
                    </label>
                  </div>
                  <input type="hidden" id="base64" rows="5" name="photo" value="{{ $accounts->photo }}">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col text-center">
                  <input type="submit" class="form-control btn btn-outline-dark" value="Update">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Crop Image Before Upload</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="img-container">
              <div class="row">
                <div class="col-md-8">
                  <img src="" id="sample_image" style="display: block; max-width: 100%;">
                </div>
                <div class="col-md-4">
                  <div class="preview"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="crop" class="btn btn-primary">Crop</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>

    @endif
  </div>
  @endsection
