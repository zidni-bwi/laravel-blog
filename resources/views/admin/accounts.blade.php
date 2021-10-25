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
              @if($accounts->photo == NULL)
              <img src="data:image/png;base64,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" class="card-img-top card-img-top rounded-circle w-75 img-responsive center-block d-block mx-auto">
              @else
              <img src="{{ $accounts->photo }}" class="card-img-top card-img-top rounded-circle w-75 img-responsive center-block d-block mx-auto" alt="gambar" >
              @endif
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
                    @if($accounts->photo == NULL)
                    <img src="data:image/png;base64,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" id="uploaded_image" class="img-responsive card-img-top rounded-circle w-75 img-responsive center-block d-block mx-auto" />
                    @else
                    <img src="{{ $accounts->photo }}" id="uploaded_image" class="img-responsive card-img-top rounded-circle w-75 img-responsive center-block d-block mx-auto" />
                    @endif
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
