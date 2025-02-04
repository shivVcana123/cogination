@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>How It Works Section</h1>
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
                            <h3 class="card-title">
                                {{ empty($howItWorkSection) || !isset($howItWorkSection[0]) ? 'Add' : 'Edit' }} How It Works Details
                            </h3>
                        </div>


                        <form action="{{ route('save-how-it-works-section') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ old('id', $howItWorkSection[0]->id ?? '') }}">

                            <div class="card-body">
                                <div class="row">
                                    <!-- Title Field -->
                                    <div class="form-group col-md-6">
                                        <label for="title">Title</label>
                                        <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                        <input type="text" class="form-control" name="title" id="title"
                                            placeholder="Enter title" value="{{ old('title', $howItWorkSection[0]->title ?? '') }}">
                                        @error('title')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="image">Image</label>
                                        <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                        <img id="blah" src="{{asset($howItWorkSection[0]->image ?? '')}}" alt="Image Preview" style="width: 130px; display:{{empty($howItWorkSection[0]->image) ? 'none' : 'block'}}" />
                                        <input type="file" class="form-control" name="image" id="imgInp" accept="image/*">
                                        @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>



                                @php
                                // Check if the $howItWorkSection exists and contains data before attempting to decode
                                $pointers = isset($howItWorkSection[0]) && !empty($howItWorkSection[0]->pointers)
                                ? json_decode($howItWorkSection[0]->pointers)
                                : [];
                                @endphp


                                <!-- Pointers Section -->
                                <label for="">Card Details</label>
                                <div id="Pointers-container">

                                    @if(!empty($pointers) && is_array($pointers))
                                    <!-- Loop through each pointer and display -->
                                    @foreach($pointers as $index => $pointer)
                                    <div class="form-group url-group">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label> Title</label>
                                                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                                <input type="text" name="sub_title[]" class="form-control" value="{{$pointer->sub_title}}" placeholder="Enter title" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label> Description</label>
                                                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                                <input type="text" name="sub_description[]" class="form-control" value="{{$pointer->sub_description}}" placeholder="Enter description" required>
                                            </div>

                                        </div>
                                        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                    </div>
                                    @endforeach
                                    @else

                                    <!-- Default empty field when no pointers exist -->
                                    <div class="form-group url-group">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label> Title</label>
                                                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                                <input type="text" name="sub_title[]" class="form-control" value="" placeholder="Enter title">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label> Description</label>
                                                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                                <input type="text" name="sub_description[]" class="form-control" value="" placeholder="Enter description">
                                            </div>

                                        </div>
                                        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                    </div>
                                    @endif
                                </div>
                                <!-- Add Pointer Button -->
                                <button type="button" class="btn btn-success" id="add-Pointers">Add Card</button>


                            </div>

                            <div class="card-footer">
                            <input type="checkbox" id="status" name="status" {{ ($howItWorkSection[0]->status ?? '') === 'on' ? 'checked' : '' }}>
                            <label for="status">Show On Website</label>
                                <button type="submit" id="form-submit-button" class="btn btn-primary">Submit</button>
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
        urlGroups.forEach((group) => {
            const removeButton = group.querySelector('.remove-Pointers');
            removeButton.style.display = urlGroups.length > 1 ? 'inline-block' : 'none';
        });
    }

    document.getElementById('add-Pointers').addEventListener('click', function () {
        const container = document.getElementById('Pointers-container');
        const newInputGroup = document.createElement('div');
        newInputGroup.classList.add('form-group', 'url-group');
        newInputGroup.innerHTML = `
            <div class="row">
                <div class="form-group col-md-6">
                    <label> Title</label>
                    <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                    <input type="text" name="sub_title[]" class="form-control" placeholder="Enter title">
                    <div class="text-danger sub-title-error" style="display: none;">This field is required.</div>
                </div>
                <div class="form-group col-md-6">
                    <label> Description</label>
                    <i class="fas fa-info-circle" title="Provide a meaningful description for this section."></i>
                    <input type="text" name="sub_description[]" class="form-control" placeholder="Enter description">
                    <div class="text-danger sub-description-error" style="display: none;">This field is required.</div>
                </div>
            </div>
            <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
        `;
        container.appendChild(newInputGroup);
        updateRemoveButtonVisibility(); // Update "Remove" buttons visibility
    });

    document.getElementById('Pointers-container').addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-Pointers')) {
            event.target.closest('.url-group').remove();
            updateRemoveButtonVisibility(); // Update "Remove" buttons visibility
        }
    });

    // Validation function
    function validateForm() {
        const subTitles = document.querySelectorAll('input[name="sub_title[]"]');
        const subDescriptions = document.querySelectorAll('input[name="sub_description[]"]');
        let isValid = true;

        // Validate Sub Title fields
        subTitles.forEach(input => {
            const errorDiv = input.nextElementSibling; // The sub-title-error div
            if (errorDiv && errorDiv.classList.contains('sub-title-error')) {
                if (!input.value.trim()) {
                    isValid = false;
                    errorDiv.style.display = 'block'; // Show error message
                } else {
                    errorDiv.style.display = 'none'; // Hide error message
                }
            }
        });

        // Validate Sub Description fields
        subDescriptions.forEach(input => {
            const errorDiv = input.nextElementSibling; // The sub-description-error div
            if (errorDiv && errorDiv.classList.contains('sub-description-error')) {
                if (!input.value.trim()) {
                    isValid = false;
                    errorDiv.style.display = 'block'; // Show error message
                } else {
                    errorDiv.style.display = 'none'; // Hide error message
                }
            }
        });

        return isValid;
    }

    // Attach validation to form submission
    document.getElementById('form-submit-button').addEventListener('click', function (event) {
        const isValid = validateForm(); // Corrected function name here
        if (!isValid) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });

    // Initial visibility check when the page loads
    document.addEventListener('DOMContentLoaded', function () {
        updateRemoveButtonVisibility();
    });

    // Image preview logic for file input
    const imgInp = document.getElementById('imgInp');
    const blah = document.getElementById('blah');
    imgInp.onchange = function (evt) {
        const [file] = imgInp.files;
        if (file) {
            blah.src = URL.createObjectURL(file);
            blah.style.display = "block"; // Show the image
        } else {
            blah.style.display = "none"; // Hide the image if no file is selected
            blah.src = "#"; // Reset the src
        }
    };
</script>


@endsection