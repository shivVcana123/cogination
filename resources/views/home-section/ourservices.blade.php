@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Our Services Section</h1>
                </div>
                <!-- <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"> Form</li>
                    </ol>
                </div> -->
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
                                {{ empty($chooseusData) || !isset($chooseusData[0]) ? 'Add' : 'Edit' }} Our Services Details
                            </h3>
                        </div>


                        <form action="{{ route('save-our-services') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ old('id', $chooseusData[0]->id ?? '') }}">

                            <div class="card-body">
                                <div class="row">
                                    <!-- Title Field -->
                                    <div class="form-group col-md-6">
                                        <label for="title">Title</label>
                                        <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                        <input type="text" class="form-control" name="title" id="title"
                                            placeholder="Enter title" value="{{ old('title', $chooseusData[0]->title ?? '') }}" required>
                                        @error('title')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <!-- Subtitle Field -->
                                    <div class="form-group col-md-6">
                                        <label for="subtitle">Subtitle</label>
                                        <i class="fas fa-info-circle" title="Provide a brief subtitle that complements the main title of this section."></i> <label class="option-area">(Optional)</label>
                                        <input type="text" class="form-control" name="subtitle" id="subtitle"
                                            placeholder="Enter subtitle" value="{{ old('subtitle', $chooseusData[0]->subtitle ?? '') }}">
                                        @error('subtitle')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <!-- Description Field -->
                                <div class="form-group">
                                    <label for="description_1">Description</label>
                                    <i class="fas fa-info-circle" title="Describe the purpose or details of this section in 2-3 sentences."></i>
                                    <textarea class="form-control" name="description_1" id="description_1" required>{{ old('description_1', $chooseusData[0]->description_1 ?? '') }}</textarea>
                                    @error('description_1')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <hr>

                                @php
                                // Check if the $chooseusData exists and contains data before attempting to decode
                                $pointers = isset($chooseusData[0]) && !empty($chooseusData[0]->pointers)
                                ? json_decode($chooseusData[0]->pointers)
                                : [];
                                @endphp


                                <!-- Pointers Section -->
                                <h5>Card Details</h5>
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
                                            <div class="form-group col-md-6">
                                                <label>Image</label>
                                                <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                                <img id="blah" src="{{asset($pointer->sub_image ?? '')}}" alt="Image Preview" style="width: 130px; display: {{ empty($pointer->sub_image) ? 'none' : 'block' }};" />
                                                <input type="file" class="form-control" name="image[]" accept="image/*">
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
                                                <input type="text" name="sub_title[]" class="form-control" value="" placeholder="Enter title" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label> Description</label>
                                                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                                <input type="text" name="sub_description[]" class="form-control" value="" placeholder="Enter description" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Image</label>
                                                <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                                <img id="blah" src="#" alt="Image Preview" style="width: 130px; display:none" />
                                                <input type="file" class="form-control" name="image[]" accept="image/*">
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
                                <input type="checkbox" id="status" name="status" {{ ($chooseusData[0]->status ?? '') === 'on' ? 'checked' : '' }}>
                                <label for="status">Show On Website</label>
                                <button type="submit" id="form-submit-button" class="btn btn-primary">Save</button>
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
    CKEDITOR.replace('description_1');


    function updateRemoveButtonVisibility() {
        const urlGroups = document.querySelectorAll('.url-group');
        urlGroups.forEach((group) => {
            const removeButton = group.querySelector('.remove-Pointers');
            removeButton.style.display = urlGroups.length > 1 ? 'inline-block' : 'none';
        });
    }

    document.getElementById('add-Pointers').addEventListener('click', function() {
        const container = document.getElementById('Pointers-container');
        const newInputGroup = document.createElement('div');
        newInputGroup.classList.add('form-group', 'url-group');
        newInputGroup.innerHTML = `
        <div class="row">
            <div class="form-group col-md-6">
                <label> Title</label>
                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                <input type="text" name="sub_title[]" class="form-control" value="" placeholder="Enter title" required>
                <div class="text-danger sub-title-error" style="display: none;">The title field is required.</div>
            </div>
            <div class="form-group col-md-6">
                <label> Description</label>
                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                <input type="text" name="sub_description[]" class="form-control" value="" placeholder="Enter description" required>
                <div class="text-danger sub-description-error" style="display: none;">The description field is required.</div>
            </div>
            <div class="form-group col-md-6">
                <label>Image</label>
                <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                <img id="blah" src="#" alt="Image Preview" style="width: 130px; display:none" />
                <input type="file" class="form-control" name="image[]" accept="image/*">
            </div>
        </div>
        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
    `;
        container.appendChild(newInputGroup);
        updateRemoveButtonVisibility(); // Update "Remove" buttons visibility
    });

    document.getElementById('Pointers-container').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-Pointers')) {
            event.target.closest('.url-group').remove();
            updateRemoveButtonVisibility(); // Update "Remove" buttons visibility
        }
    });

    // Validation function
    function validateFields() {
        const urlGroups = document.querySelectorAll('.url-group');
        let isValid = true;

        urlGroups.forEach((group) => {
            const subTitleInput = group.querySelector('input[name="sub_title[]"]');
            const subDescriptionInput = group.querySelector('input[name="sub_description[]"]');
            const titleError = group.querySelector('.sub-title-error');
            const descriptionError = group.querySelector('.sub-description-error');

            // Reset error visibility
            if (titleError) titleError.style.display = 'none';
            if (descriptionError) descriptionError.style.display = 'none';

            // Check if both fields are empty
            if (!subTitleInput.value.trim() && !subDescriptionInput.value.trim()) {
                if (titleError) titleError.style.display = 'block';
                if (descriptionError) descriptionError.style.display = 'block';
                isValid = false;
            }
        });

        // if (!isValid) {
        //     alert('Please ensure at least one field in each group is filled.');
        // }

        return isValid;
    }

    // Add submit listener for validation
    document.getElementById('form-submit-button').addEventListener('click', function(event) {
        if (!validateFields()) {
            event.preventDefault(); // Prevent form submission if validation fails
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
            blah.style.display = "block"; // Show the image
        } else {
            blah.style.display = "none"; // Hide the image if no file is selected
            blah.src = "#"; // Reset the src
        }
    };
</script>

@endsection