@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Newsletter Section</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"> Form</li>
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
                            <h3 class="card-title">{{ isset($subscribeNewsletter->id) ? 'Edit Newsletter Details' : 'Add Newsletter Details' }}</h3>
                        </div>

                        <form action="{{ route('news-letter-save') }}" method="POST" enctype="multipart/form-data" id="subscribeNewsletterForm">
                            @csrf
                            <input type="hidden" name="hidden_id" value="{{ $subscribeNewsletter->id ?? '' }}">
                            <div class="card-body">
                                <!-- Title Section -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $subscribeNewsletter->title ?? '') }}" placeholder="Enter Title">
                                            @error('title')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                          
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="button_content">Button Text</label>
                                            <input type="text" class="form-control" name="button_content" id="button_content" placeholder="Enter Button Text" value="{{ old('button_content', $subscribeNewsletter->button_content ?? '') }}">
                                            @error('button_content')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="button_link">Button Link</label>
                                            <input type="text" class="form-control" name="button_link" id="button_link" value="{{ old('button_link', $subscribeNewsletter->button_link ?? '') }}" placeholder="Enter Button Link">
                                            @error('button_link')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div> -->
                                </div>

                                <hr>

                                <!-- Pointers Section -->
                                <label for="">Card Icon</label>
                                <div id="Pointers-container">
                                    @if(isset($subscribeNewsletter->pointers) && is_array(json_decode($subscribeNewsletter->pointers, true)))
                                    @foreach(json_decode($subscribeNewsletter->pointers, true) as $key => $pointer)
                                   
                                    <div class="form-group url-group">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Media Icon</label>
                                                <img class="media-icon" id="blah" src="{{asset($pointer['image'])}}" alt="Image Preview" style="width: auto; display:{{empty($pointer['image']) ? 'none' : 'block'}};" />
                                                <input type="file" name="image[{{ $key }}]" id="imgInp" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Media Link</label>
                                                <input type="text" name="link[{{ $key }}]" class="form-control" value="{{ $pointer['link'] ?? '' }}" placeholder="Enter Media Link">
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="form-group url-group">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Media Icon</label>
                                                <img class="media-icon" id="blah" src="#" alt="Image Preview" style="width: auto; display:none;" />
                                                <input type="file" name="image[]" id="imgInp" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Media Link</label>
                                                <input type="text" name="link[]" class="form-control" placeholder="Enter Media Link">
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                    </div>
                                    @endif
                                </div>

                                <!-- Add Pointer Button -->
                                <button type="button" class="btn btn-success" id="add-Pointers">Add Icon</button>

                                <!-- Submit Button -->
                                <div class="card-footer">
                                    <input type="checkbox" id="status" name="status" {{ ($subscribeNewsletter->status ?? '') === 'on' ? 'checked' : '' }}>
                                    <label for="status">Show On Website</label>
                                    <button type="submit" id="form-submit-button" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('java_script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const pointersContainer = document.getElementById('Pointers-container');
    const addPointersButton = document.getElementById('add-Pointers');

    // Add Pointer
    addPointersButton.addEventListener('click', () => {
        const newPointer = document.createElement('div');
        newPointer.classList.add('form-group', 'url-group');
        const uniqueId = Date.now(); // Generate a unique ID for the image and input
        newPointer.innerHTML = `
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Media Icon</label>
                    <img class="media-icon" id="img-preview-${uniqueId}" src="#" alt="Image Preview" style="width: auto; display:none;" />
                    <input type="file" name="image[]" id="file-input-${uniqueId}" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label>Media Link</label>
                    <input type="text" name="link[]" class="form-control" placeholder="Enter Media Link">
                </div>
            </div>
            <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
        `;
        pointersContainer.appendChild(newPointer);

        // Add onchange event for the new input
        const fileInput = document.getElementById(`file-input-${uniqueId}`);
        const imgPreview = document.getElementById(`img-preview-${uniqueId}`);
        fileInput.addEventListener('change', function () {
            const [file] = fileInput.files;
            if (file) {
                imgPreview.src = URL.createObjectURL(file);
                imgPreview.style.display = "block";
            } else {
                imgPreview.style.display = "none";
                imgPreview.src = "#";
            }
        });

        // Attach remove event to the new button
        newPointer.querySelector('.remove-Pointers').addEventListener('click', function () {
            newPointer.remove();
        });
    });

    // Existing file input preview functionality
    pointersContainer.addEventListener('change', function (e) {
        if (e.target.type === 'file') {
            const imgPreview = e.target.closest('.url-group').querySelector('.media-icon');
            const [file] = e.target.files;
            if (file) {
                imgPreview.src = URL.createObjectURL(file);
                imgPreview.style.display = "block";
            } else {
                imgPreview.style.display = "none";
                imgPreview.src = "#";
            }
        }
    });
});


</script>

@endsection