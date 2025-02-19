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
                                            <i class="fas fa-info-circle" title="Provide a brief title that complements the main title of this section."></i>
                                            <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $subscribeNewsletter->title ?? '') }}" placeholder="Enter Title">
                                            @error('title')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="button_content">Button Text</label>
                                            <i class="fas fa-info-circle" title="Provide a brief button text of this section."></i>
                                            <input type="text" class="form-control" name="button_content" id="button_content" placeholder="Enter Button Text" value="{{ old('button_content', $subscribeNewsletter->button_content ?? '') }}">
                                            @error('button_content')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <!-- Pointers Section -->
                                <h5>Card Icon</h5>
                                <div id="Pointers-container">
                                    @if(isset($subscribeNewsletter->pointers) && is_array(json_decode($subscribeNewsletter->pointers, true)))
                                    @foreach(json_decode($subscribeNewsletter->pointers, true) as $key => $pointer)
                                    <div class="form-group url-group">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Media Icon</label>
                                                <i class="fas fa-info-circle" title="Provide a brief media icon of this section."></i>
                                                <img class="media-icon" id="blah" src="{{asset($pointer['image'])}}" alt="Image Preview" style="width: auto; display:{{empty($pointer['image']) ? 'none' : 'block'}};" />
                                                <input type="file" name="image[{{ $key }}]" id="imgInp" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Media Link</label>
                                                <i class="fas fa-info-circle" title="Provide a brief media link of this section."></i>
                                                <input type="text" name="link[{{ $key }}]" class="form-control" value="{{ $pointer['link'] ?? '' }}" placeholder="Enter Media Link" required>
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
                                                <i class="fas fa-info-circle" title="Provide a brief media icon of this section."></i>
                                                <img class="media-icon" id="blah" src="#" alt="Image Preview" style="width: auto; display:none;" />
                                                <input type="file" name="image[]" id="imgInp" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Media Link</label>
                                                <i class="fas fa-info-circle" title="Provide a brief media link of this section."></i>
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
<!-- <script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('subscribeNewsletterForm');
    const addPointersButton = document.getElementById('add-Pointers');
    const submitButton = document.getElementById('form-submit-button');
    
    // Function to add a new pointer
    addPointersButton.addEventListener('click', function () {
        const newPointerHTML = `
            <div class="form-group url-group">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Media Icon</label>
                        <i class="fas fa-info-circle" title="Provide a brief media icon of this section."></i>
                                                <img class="media-icon" id="blah" src="#" alt="Image Preview" style="width: auto; display:none;" />

                        <input type="file" name="image[]" id="imgInp" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Media Link</label>
                        <i class="fas fa-info-circle" title="Provide a brief media link of this section."></i>
                        <input type="text" name="link[]" class="form-control" placeholder="Enter Media Link">
                    </div>
                </div>
                <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
            </div>
        `;
        const pointersContainer = document.getElementById('Pointers-container');
        pointersContainer.insertAdjacentHTML('beforeend', newPointerHTML);
    });

    // Event delegation for "Remove" button
    document.getElementById('Pointers-container').addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('remove-Pointers')) {
            event.target.closest('.url-group').remove();
        }
    });

    // Add event listener to the submit button
    submitButton.addEventListener('click', function(event) {
        let isValid = true;

        // Check if all required fields are filled
        const urlGroups = document.querySelectorAll('.url-group');
        urlGroups.forEach(group => {
            const imageInput = group.querySelector('input[type="file"]');
            const linkInput = group.querySelector('input[type="text"]');
            const errorMessage = group.querySelector('.error-message');

            // Validate that at least one field is not empty
            if (!imageInput.value.trim() && !linkInput.value.trim()) {
                errorMessage.style.display = 'block'; // Show error message
                isValid = false;
            } else {
                errorMessage.style.display = 'none'; // Hide error message
            }
        });

        // Prevent form submission if validation fails
        if (!isValid) {
            event.preventDefault(); // Prevent form from submitting
            alert("Please fill out all required fields.");
        }
    });
});
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('Pointers-container').addEventListener('change', function (event) {
        if (event.target.type === "file") {
            const fileInput = event.target;
            const imagePreview = fileInput.closest('.url-group').querySelector('.media-icon');
            const [file] = fileInput.files;
            if (file) {
                imagePreview.src = URL.createObjectURL(file);
                imagePreview.style.display = "block";
            } else {
                imagePreview.style.display = "none";
                imagePreview.src = "#";
            }
        }
    });
});

</script> -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('subscribeNewsletterForm');
        const addPointersButton = document.getElementById('add-Pointers');
        const submitButton = document.getElementById('form-submit-button');
        const pointersContainer = document.getElementById('Pointers-container');

        // Function to add a new pointer
        addPointersButton.addEventListener('click', function() {
            const newPointerHTML = `
            <div class="form-group url-group">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Media Icon</label>
                        <i class="fas fa-info-circle" title="Provide a brief media icon of this section."></i>
                        <img class="media-icon" src="#" alt="Image Preview" style="width: auto; display:none;" />
                        <input type="file" name="image[]" class="form-control">
                        <span class="error-message text-danger" style="display:none;">This field is required.</span>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Media Link</label>
                        <i class="fas fa-info-circle" title="Provide a brief media link of this section."></i>
                        <input type="text" name="link[]" class="form-control" placeholder="Enter Media Link">
                        <span class="error-message text-danger" style="display:none;">This field is required.</span>
                    </div>
                </div>
                <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
            </div>
        `;
            pointersContainer.insertAdjacentHTML('beforeend', newPointerHTML);
        });

        // Event delegation for "Remove" button
        pointersContainer.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-Pointers')) {
                event.target.closest('.url-group').remove();
            }
        });

        // Show preview for selected image & hide (Optional) label
        pointersContainer.addEventListener('change', function(event) {
            if (event.target.type === "file") {
                const fileInput = event.target;
                const imagePreview = fileInput.closest('.url-group').querySelector('.media-icon');
                const [file] = fileInput.files;
                if (file) {
                    imagePreview.src = URL.createObjectURL(file);
                    imagePreview.style.display = "block";
                } else {
                    imagePreview.style.display = "none";
                    imagePreview.src = "#";
                }
            }

            if (event.target.type === "text" || event.target.type === "file") {
                const errorMessage = event.target.closest('.form-group').querySelector('.error-message');
                if (event.target.value.trim() !== "") {
                    errorMessage.style.display = "none"; // Hide error message when user enters data
                }
            }
        });

        // Form submission validation
        submitButton.addEventListener('click', function(event) {
            let isValid = true;

            document.querySelectorAll('.url-group').forEach(group => {
                const imageInput = group.querySelector('input[type="file"]');
                const linkInput = group.querySelector('input[type="text"]');
                const errorMessages = group.querySelectorAll('.error-message');

                // Validate that at least one field is not empty
                if (!imageInput.value.trim() && !linkInput.value.trim()) {
                    errorMessages.forEach(msg => msg.style.display = 'block');
                    isValid = false;
                }
            });

            // Prevent form submission if validation fails
            if (!isValid) {
                event.preventDefault();
                // alert("Please fill out all required fields before submitting.");
            }
        });
    });
</script>

@endsection