@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Our Mssion Section</h1>
                </div>
                <!-- <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Form</li>
                    </ol>
                </div> -->
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header" style="background-color:#0476b4">
                            <h3 class="card-title">{{ empty($ourMissionSection) || !isset($ourMissionSection[0]) ? 'Add' : 'Edit' }} Our Mssion Details</h3>
                        </div>
                        <form action="{{ route('save-our-mission-section') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ old('id', $ourMissionSection[0]->id ?? '') }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="title">Title</label>
                                        <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                        <input type="text" class="form-control" name="title" id="title"
                                            placeholder="Enter first title" value="{{ old('title',$ourMissionSection[0]->title ?? '') }}" required>
                                        @error('title')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- <div class="form-group col-md-6">
                                        <label for="image">Image</label>
                                        <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                        <img id="blah" src="{{asset($ourMissionSection[0]->image ?? '')}}" alt="Image Preview" style="width: 130px; display:{{empty($ourMissionSection[0]->image) ? 'none' : 'block'}}" />
                                        <input type="file" class="form-control" name="image" id="imgInp" accept="image/*">
                                        @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div> -->
                                    
                                    <div class="form-group col-md-6">
                                        <label for="file">Upload Image/Video</label>
                                        <i class="fas fa-info-circle" title="Upload an image or video that visually represents this section."></i>

                                        <!-- Image Preview -->
                                        <img id="imagePreview"
                                            src="{{ asset($ourMissionSection[0]->image ?? '') }}"
                                            alt="Image Preview"
                                            style="width: 130px; display: none;" />

                                        <!-- Video Preview -->
                                        <video id="videoPreview" controls style="width: 130px; display: none;">
                                            <source id="videoSource" src="{{ asset($ourMissionSection[0]->image ?? '') }}" type="video/mp4">
                                        </video>

                                        <!-- File Input -->
                                        <input type="file" class="form-control" name="file" id="fileInput"
                                            accept="image/*,video/mp4,video/mov,video/avi,video/wmv"
                                            onchange="previewFile()">

                                        @error('file')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <input type="checkbox" id="status" name="status" {{ ($ourMissionSection[0]->status ?? '') === 'on' ? 'checked' : '' }}>
                                <label for="status">Show On Website</label>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    // imgInp.onchange = evt => {
    //     const [file] = imgInp.files;
    //     if (file) {
    //         blah.src = URL.createObjectURL(file);
    //         blah.style.display = "block"; // Show the image
    //     } else {
    //         blah.style.display = "none"; // Hide the image if no file is selected
    //         blah.src = "#"; // Reset the src
    //     }
    // };
    // function previewFile() {
    //     const fileInput = document.getElementById('fileInput');
    //     const imagePreview = document.getElementById('imagePreview');
    //     const videoPreview = document.getElementById('videoPreview');
    //     const file = fileInput.files[0];

    //     if (file) {
    //         const fileType = file.type.split('/')[0];

    //         if (fileType === 'image') {
    //             const reader = new FileReader();
    //             reader.onload = function(e) {
    //                 imagePreview.src = e.target.result;
    //                 imagePreview.style.display = 'block';
    //                 videoPreview.style.display = 'none';
    //             };
    //             reader.readAsDataURL(file);
    //         } else if (fileType === 'video') {
    //             const videoURL = URL.createObjectURL(file);
    //             videoPreview.src = videoURL;
    //             videoPreview.style.display = 'block';
    //             imagePreview.style.display = 'none';
    //         }
    //     }
    // }
    function previewFile() {
        let fileInput = document.getElementById("fileInput");
        let imagePreview = document.getElementById("imagePreview");
        let videoPreview = document.getElementById("videoPreview");
        let videoSource = document.getElementById("videoSource");

        if (fileInput.files.length > 0) {
            let file = fileInput.files[0];
            let fileType = file.type.split("/")[0]; // Get 'image' or 'video'
            let fileURL = URL.createObjectURL(file);

            if (fileType === "image") {
                imagePreview.src = fileURL;
                imagePreview.style.display = "block";
                videoPreview.style.display = "none";
            } else if (fileType === "video") {
                videoSource.src = fileURL;
                videoPreview.load(); // Reload video source
                videoPreview.style.display = "block";
                imagePreview.style.display = "none";
            }
        }
    }

    // Auto-detect existing file type (for loaded image/video)
    document.addEventListener("DOMContentLoaded", function() {
        let imagePreview = document.getElementById("imagePreview");
        let videoPreview = document.getElementById("videoPreview");
        let videoSource = document.getElementById("videoSource");

        let filePath = "{{ asset($ourMissionSection[0]->image ?? '') }}";
        if (filePath) {
            let extension = filePath.split('.').pop().toLowerCase();
            let videoExtensions = ["mp4", "mov", "avi", "wmv"];

            if (videoExtensions.includes(extension)) {
                videoSource.src = filePath;
                videoPreview.load();
                videoPreview.style.display = "block";
                imagePreview.style.display = "none";
            } else {
                imagePreview.src = filePath;
                imagePreview.style.display = "block";
                videoPreview.style.display = "none";
            }
        }
    });
</script>

@endsection