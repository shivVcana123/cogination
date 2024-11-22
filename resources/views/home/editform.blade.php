@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Update Home Data</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home.index')}}">Home</a></li>
                        <li class="breadcrumb-item active">Home Update Form</li>
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
                        <div class="card-header">
                            <h3 class="card-title">Update Details</h3>
                        </div>
                        <form action="{{ route('home.update', $homeData->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" value="{{ old('title', $homeData->title ?? '') }}">
                                    @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="subtitle">Subtitle</label>
                                    <input type="text" class="form-control" name="subtitle" id="subtitle" placeholder="Enter Subtitle" value="{{ old('subtitle', $homeData->subtitle ?? '') }}">
                                    @error('subtitle')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description_1">Description 1</label>
                                    <textarea class="form-control" name="description_1" id="description_1">{{ old('description_1', $homeData->description_1 ?? '') }}</textarea>
                                    @error('description_1')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="button_content">Button Text</label>
                                    <input type="text" class="form-control" name="button_content" id="button_content" placeholder="Enter Button Text" value="{{ old('button_content', $homeData->button_content ?? '') }}">
                                    @error('button_content')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="button_link">Button Link</label>
                                    <input type="text" class="form-control" name="button_link" id="button_link" placeholder="Enter Button Link" value="{{ old('button_link', $homeData->button_link ?? '') }}">
                                    @error('button_link')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="background_color">Background Color</label>
                                    <input type="color" class="form-control" name="background_color" id="background_color" value="{{ old('background_color', $homeData->background_color ?? '') }}">
                                    @error('background_color')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="image">Image</label>
                                    {{ dd($homeData->image) }}
                                    <img
                                        id="blah"
                                        src="{{ asset(str_replace('storage/app/public', 'storage', $homeData->image)) }}"
                                        alt="your image"
                                        style="width: 130px;" />
                                    <input type="file" class="form-control" name="image" id="imgInp">
                                    @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="background_image">Home Background Image</label>
                                    <img id="bg_image" src="{{ asset(str_replace('storage/app/public', 'storage', $homeData->background_image)) }}" style="width: 130px;" />
                                    <input type="file" class="form-control" name="background_image" id="background_image">
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
        const [file] = imgInp.files
        if (file) {
            blah.src = URL.createObjectURL(file)
        }
    }

    background_image.onchange = evt => {
        const [file] = background_image.files
        if (file) {
            bg_image.src = URL.createObjectURL(file)
        }
    }
</script>

@endsection