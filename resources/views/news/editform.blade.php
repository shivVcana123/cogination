@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Update News Section</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('news.index')}}">News</a></li>
                        <li class="breadcrumb-item active">Update Form</li>
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
                            <h3 class="card-title">Update News Details</h3>
                        </div>
                        <form action="{{ route('news.update',$newsData->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" value="{{old('title',$newsData->title)}}">
                                    @error('title')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                                </div>
                                <div class="form-group">
                                    <label for="title">Link</label>
                                    <input type="text" class="form-control" name="link" id="title" placeholder="Enter link"  value="{{old('link',$newsData->button_link)}}">
                                    @error('link')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                                </div>
                                <div class="form-group">
                                    <label for="title">Decription</label>
                                    <textarea type="text" class="form-control" name="description_1" id="description_1"> {{old('description_1',$newsData->description_1)}}</textarea>
                                    @error('description_1')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                                </div>

                                <div class="form-group">
                                    <label for="title">Background Color</label>
                                    <input type="color" class="form-control" name="background_color" id="background_color"  value="{{old('background_color',$newsData->background_color)}}">
                                    @error('background_color')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                                </div>
                                <div class="form-group">
                                <label for="image">Image</label>
                                <img id="blah" src="{{ asset(str_replace('storage/app/public', 'storage', $newsData->image)) }}" alt="Image Preview" style="width: 130px; display:none" />
                                <input type="file" class="form-control" name="image" id="imgInp" accept="image/*">
                                @error('image')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="background_image">Background Center Image</label>
                                <img id="bg_image" src="{{ asset(str_replace('storage/app/public', 'storage', $newsData->background_image)) }}" alt="Background Image Preview" style="width: 130px; display:none" />
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
