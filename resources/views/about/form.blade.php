@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add About Section</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('about.index')}}">About</a></li>
                        <li class="breadcrumb-item active">Add Form</li>
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
                    <div class="card-header" style="background-color:#0377ce">
                        <h3 class="card-title">Add About Details</h3>
                    </div>
                    <form action="{{ route('about.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" value="{{ old('title') }}" name="title" id="title" placeholder="Enter title">
                                @error('title')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="description_1">Description 1</label>
                                <textarea class="form-control" name="description_1" id="description_1" placeholder="Enter description">{{ old('description_1') }}</textarea>
                                @error('description_1')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description_2">Description 2</label>
                                <textarea class="form-control" name="description_2" id="description_2" placeholder="Enter description">{{ old('description_2') }}</textarea>
                                @error('description_2')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="button_content">Button Text</label>
                                <input type="text" class="form-control" value="{{ old('button_content') }}" name="button_content" id="button_content" placeholder="Enter Button Text">
                                @error('button_content')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="button_link">Button Link</label>
                                <input type="text" class="form-control" value="{{ old('button_link') }}" name="button_link" id="button_link" placeholder="Enter Button Link">
                                @error('button_link')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="background_color">Background Color</label>
                                <input type="color" class="form-control" value="{{ old('background_color') }}" name="background_color" id="background_color">
                                @error('background_color')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <img id="blah" src="#" alt="Image Preview" style="width: 130px; display:none" />
                                <input type="file" class="form-control" name="image" id="imgInp" accept="image/*">
                                @error('image')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="background_image">Background Center Image</label>
                                <img id="bg_image" src="#" alt="Background Image Preview" style="width: 130px; display:none" />
                                <input type="file" class="form-control" name="background_image" id="background_image" accept="image/*">
                                @error('background_image')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="card-footer">
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

    background_image.onchange = evt => {
        const [file] = background_image.files;
        if (file) {
            bg_image.src = URL.createObjectURL(file);
            bg_image.style.display = "block"; // Show the image
        } else {
            bg_image.style.display = "none"; // Hide the image if no file is selected
            bg_image.src = "#"; // Reset the src
        }
    };
</script>

@endsection