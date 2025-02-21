@extends('layouts.guest')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Choose Logo</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
            <div class="col-md-12">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                         <form id="imageUploadForm" enctype="multipart/form-data" method="post" action="{{ route('saveChangeLogo') }}">
                         @csrf
                            <input type="hidden" name="submit" value="{{ $logo->id }}">
                            <div id="preview">
                                   @if($logo->logo)
                                        <img src="{{ asset($logo->logo) }}" alt="Logo" style="width: 100%; height: auto;">
                                    @else
                                        Choose an image
                                    @endif</div>
                           
                            <input type="file" id="imageInput" name="image" accept="image/*" style="display: none;">
                            <button type="button" id="chooseImageBtn" style="background-color:#17a2b8;color:white">Choose Image</button>
                            <button type="submit" id="upload" style="background-color:#17a2b8;color:white">Upload</button>
                            <button type="button" id="reset" style="background-color:#17a2b8;color:white">Reset</button>

                        </form>
                    </div>
                    <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
 <style>
    #preview {
      width: 227px;
      height: 200px;
      border: 2px dashed #ccc;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 10px;
    }
    #preview img {
      max-width: 100%;
      max-height: 100%;
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
$(document).ready(function () {
    let oldImage = "{{ $logo->logo ? asset($logo->logo) : '' }}"; // Store old image URL

    // Trigger file input when "Choose Image" is clicked
    $('#chooseImageBtn').on('click', function () {
        $('#imageInput').click();
    });

    // Update preview when a new file is selected
    $('#imageInput').on('change', function (e) {
        let file = e.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function (e) {
                $('#preview').html('<img id="previewImage" src="' + e.target.result + '" alt="Logo" style="width: 100%; height: auto;">');
            };
            reader.readAsDataURL(file);
        }
    });

    // Reset preview and file input when "Reset" is clicked
    $('#reset').on('click', function (e) {
        e.preventDefault(); // Prevent unintended behavior
        $('#imageInput').val(''); // Clear file input

        if (oldImage) {
            // If old image exists, restore it
            $('#preview').html('<img id="previewImage" src="' + oldImage + '" alt="Logo" style="width: 100%; height: auto;">');
        } else {
            // If no old image, show default text
            $('#preview').html('<span id="previewText">Choose an image</span>');
        }
    });
});
</script>

@endsection