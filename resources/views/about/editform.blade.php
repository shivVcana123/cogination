@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Update About Data</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('about.index')}}">About</a></li>
                        <li class="breadcrumb-item active">About Update Form</li>
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
                        <form action="{{ route('about.update', $about->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" value="{{old('title',$about->title)}}" name="title" id="title" placeholder="Enter title">
                                    @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="title">Decription 1</label>
                                    <textarea type="text" class="form-control" name="description_1" id="description_1">{{old('description_1',$about->description_1)}}</textarea>
                                    @error('description_1')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="title">Decription 2</label>
                                    <textarea type="text" class="form-control" name="description_2" id="description_2">{{old('description_2',$about->description_2)}}</textarea>
                                    @error('description_2')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="title">Button Text</label>
                                    <input type="text" class="form-control" value="{{old('button_content',$about->button_content)}}" name="button_content" id="button_content" placeholder="Enter Button Text">
                                    @error('button_content')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="title">Button Link</label>
                                    <input type="text" class="form-control" value="{{old('button_link',$about->button_link)}}" name="button_link" id="button_link" placeholder="Enter Button Link">
                                    @error('button_link')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="title">Background Color</label>
                                    <input type="color" class="form-control" value="{{old('background_color',$about->id)}}" name="background_color" id="background_color">
                                    @error('background_color')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <img id="blah"  src="{{ asset(str_replace('storage/app/public', 'storage', $about->image)) }}" alt="your image" style="width: 130px;" />
                                    <input type="file" class="form-control" name="image" id="imgInp">
                                    @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="background_image">Background Image</label>
                                    <img id="bg_image" src="{{ asset(str_replace('storage/app/public', 'storage', $about->background_image)) }}" style="width: 130px;" />
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