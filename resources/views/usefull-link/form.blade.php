@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Link Section</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('link.index')}}">Links</a></li>
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
                            <h3 class="card-title">Add Link Details</h3>
                        </div>
                        <form action="{{ route('link.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                            <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Enter title"
                                    value="{{old('title')}}">
                                    @error('title')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                                </div>
                                <div id="Pointers-container">
                                    @foreach(old('url_content', ['']) as $index => $content)
                                    <div class="form-group url-group">
                                        <label>Url Content</label>
                                        <div class="input-group mb-2">
                                            <input type="text" name="url_content[]" class="form-control" value="{{ $content }}" placeholder="Enter Url Content">
                                        </div>
                                        @error("url_content.{$index}")
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="input-group mb-2">
                                            <input type="text" name="url_link[]" class="form-control" value="{{ old('url_link')[$index] ?? '' }}" placeholder="Enter Url Link">
                                        </div>
                                        @error("url_link.{$index}")
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                    </div>
                                    @endforeach
                                </div>

                                <button type="button" class="btn btn-success" id="add-Pointers">Add More Link</button>

                                <div class="form-group">
                                    <label for="background_color">Background Color</label>
                                    <input type="color" class="form-control" name="background_color" id="background_color" value="{{ old('background_color') }}">
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
    function updateRemoveButtonVisibility() {
        const urlGroups = document.querySelectorAll('.url-group');
        urlGroups.forEach((group, index) => {
            const removeButton = group.querySelector('.remove-Pointers');
            if (urlGroups.length > 1) {
                removeButton.style.display = 'inline-block';
            } else {
                removeButton.style.display = 'none';
            }
        });
    }

    document.getElementById('add-Pointers').addEventListener('click', function() {
        const container = document.getElementById('Pointers-container');
        const newInputGroup = document.createElement('div');
        newInputGroup.classList.add('form-group', 'url-group');
        newInputGroup.innerHTML = `
            <label>Url Content</label>
            <div class="input-group mb-2">
                <input type="text" name="url_content[]" class="form-control" placeholder="Enter Url Content">
            </div>
            <div class="input-group mb-2">
                <input type="text" name="url_link[]" class="form-control" placeholder="Enter Url Link">
            </div>
            <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
        `;
        container.appendChild(newInputGroup);
        updateRemoveButtonVisibility();
    });

    document.getElementById('Pointers-container').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-Pointers')) {
            const urlGroups = document.querySelectorAll('.url-group');
            if (urlGroups.length > 1) {
                event.target.closest('.url-group').remove();
                updateRemoveButtonVisibility();
            }
        }
    });

    // Initial visibility check when the page loads
    document.addEventListener('DOMContentLoaded', function() {
        updateRemoveButtonVisibility();
    });

    imgInp.onchange = evt => {
        const [file] = imgInp.files;
        if (file) {
            blah.src = URL.createObjectURL(file);
            blah.style.display = "block";
        } else {
            blah.style.display = "none";
            blah.src = "#";
        }
    };

    background_image.onchange = evt => {
        const [file] = background_image.files;
        if (file) {
            bg_image.src = URL.createObjectURL(file);
            bg_image.style.display = "block";
        } else {
            bg_image.style.display = "none";
            bg_image.src = "#";
        }
    };
</script>


@endsection
