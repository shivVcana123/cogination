@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Our Mssion Section</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Form</li>
                    </ol>
                </div>
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
    
                                    <div class="form-group col-md-6">
                                        <label for="image">Image</label>
                                        <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                        <img id="blah" src="{{asset($ourMissionSection[0]->image ?? '')}}" alt="Image Preview" style="width: 130px; display:{{empty($ourMissionSection[0]->image) ? 'none' : 'block'}}" />
                                        <input type="file" class="form-control" name="image" id="imgInp" accept="image/*">
                                        @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                            <input type="checkbox" id="status" name="status" {{ ($ourMissionSection[0]->status ?? '') === 'on' ? 'checked' : '' }}>
                            <label for="status">Show On Website</label>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    imgInp.onchange = evt => {
        const [file] = imgInp.files;
        if (file) {
            blah.src = URL.createObjectURL(file);
            blah.style.display = "block"; // Show the image
        } else {
            blah.style.display = "none"; // Hide the image if no file is selected
            blah.src = "#"; // Reset the src
        }
    };
    second_image.onchange = evt => {
        const [file] = second_image.files;
        if (file) {
            second_img.src = URL.createObjectURL(file);
            second_img.style.display = "block"; // Show the image
        } else {
            second_img.style.display = "none"; // Hide the image if no file is selected
            second_img.src = "#"; // Reset the src
        }
    };
</script>

@endsection