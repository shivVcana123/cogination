@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Home Section</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home.index')}}">Banner</a></li>
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
                            <h3 class="card-title">Add Banner Detail</h3>
                        </div>
                        <form action="{{ isset($banner) ? route('banner.update', $banner->id) : route('banner.store') }}" method="POST">

                            @csrf
                            @if(isset($banner))
                                @method('PUT') <!-- For update requests -->
                            @endif
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="title">Chose Page For Entering data</label><i class="fas fa-info-circle" title="Enter a title for Banner Section ."></i>
                                    <select class="form-control" style="width: 100%;" name="type">
                                        @foreach ($headerData as $header)
                                        <option value="{{ $header->category }}">{{ $header->category }}</option>
                                            
                                        @endforeach
                                    </select>
                                    @error('page')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="title">Title</label><i class="fas fa-info-circle" title="Enter a title for Banner Section ."></i>
                                    <input type="text" class="form-control" name="heading" id="title" placeholder="Enter title" value="{{ old('title', $banner->title) }}">
                                    @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="description_1">Description</label><i class="fas fa-info-circle" title="Enter a Description for Banner Section."></i>
                                    <textarea class="form-control" name="description" id="description_1">{{ old('description', $banner->description) }}</textarea>
                                    @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="button_content">Button Text</label><i class="fas fa-info-circle" title="Enter a Button text for Banner Section."></i>
                                    <input type="text" class="form-control" name="button_text" id="button_text" placeholder="Enter Button Text" value="{{ old('button_text', $banner->button_text) }}">
                                    @error('button_text')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="button_link">Button Link</label><i class="fas fa-info-circle" title="Enter a Button link for Banner Section."></i>
                                    <input type="text" class="form-control" name="button_link" id="button_link" placeholder="Enter Button Link" value="{{ old('button_link', $banner->button_link) }}">
                                    @error('button_link')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>




                                <div class="form-group"><i class="fas fa-info-circle" title="Select image for Banner section background."></i>
                                <label for="image">Image</label>
                               @if($banner->image)
                                <img id="blah" src="{{ asset($banner->image) }}" alt="Image Preview" style="width: 130px;" />
                                @endif
                                <input type="file" class="form-control" name="image" id="imgInp" accept="image/*">
                                @error('image')
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