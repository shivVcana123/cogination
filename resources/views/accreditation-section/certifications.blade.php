@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Certifications Section</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Form</li>
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
                            <h3 class="card-title">{{ empty($certificationsSection) || !isset($certificationsSection[0]) ? 'Add' : 'Edit' }} Certifications Details</h3>
                        </div>
                        <form action="{{ route('save-certifications-section') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ old('id', $certificationsSection[0]->id ?? '') }}">
                            <div class="card-body">
                                <div class="row">

                                    <div class="form-group col-md-6">
                                        <label for="title">Title</label>
                                        <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                        <input type="text" class="form-control" name="title" id="title"
                                            placeholder="Enter title" value="{{ old('title',$certificationsSection[0]->title ?? '') }}">
                                        @error('title')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Subtitle Field -->
                                    <div class="form-group col-md-6">
                                        <label for="subtitle">Subtitle</label>
                                        <i class="fas fa-info-circle" title="Provide a brief subtitle that complements the main title of this section."></i> <label>(Optional)</label>
                                        <input type="text" class="form-control" name="subtitle" id="subtitle"
                                            placeholder="Enter first subtitle" value="{{ old('subtitle',$certificationsSection[0]->subtitle ?? '') }}">
                                        @error('subtitle')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>



                                <!-- Description Field -->
                                <div class="form-group">
                                    <label for="description_1">Description</label>
                                    <i class="fas fa-info-circle" title="Describe the purpose or details of this section in 2-3 sentences."></i>
                                    <textarea class="form-control" name="description" id="description">{{ old('description', $certificationsSection[0]->description ?? '') }}</textarea>
                                    @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                @php
                                // Check if the $certificationsSection exists and contains data before attempting to decode
                                $pointers = isset($certificationsSection[0]) && !empty($certificationsSection[0]->pointers)
                                ? json_decode($certificationsSection[0]->pointers)
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
                                                <input type="text" name="sub_title[]" class="form-control" value="{{$pointer->sub_title}}" placeholder="Enter title">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label> Description</label>
                                                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                                <input type="text" name="sub_description[]" class="form-control" value="{{$pointer->sub_description}}" placeholder="Enter description">
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
                            <input type="checkbox" id="status" name="status" {{ ($certificationsSection[0]->status ?? '') === 'on' ? 'checked' : '' }}>
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
@endsection
@section('java_script')
<script>
    // Initialize CKEditor
    CKEDITOR.replace('description');

    // Function to update the visibility of the "Remove" button
    function updateRemoveButtonVisibility() {
        const urlGroups = document.querySelectorAll('.url-group');
        urlGroups.forEach((group) => {
            const removeButton = group.querySelector('.remove-Pointers');
            removeButton.style.display = urlGroups.length > 1 ? 'inline-block' : 'none';
        });
    }

    // Add a new URL group when the button is clicked
    document.getElementById('add-Pointers').addEventListener('click', function() {
        const container = document.getElementById('Pointers-container');
        const newInputGroup = document.createElement('div');
        newInputGroup.classList.add('form-group', 'url-group');
        newInputGroup.innerHTML = `
            <div class="row">
                <div class="form-group col-md-6">
                    <label> Title</label>
                    <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                    <input type="text" name="sub_title[]" class="form-control" value="" placeholder="Enter title">
                    <div class="text-danger sub-title-error" style="display: none;">This field is required.</div>
                </div>
                <div class="form-group col-md-6">
                    <label> Description</label>
                    <i class="fas fa-info-circle" title="Provide a meaningful description for this section."></i>
                    <input type="text" name="sub_description[]" class="form-control" value="" placeholder="Enter description">
                    <div class="text-danger sub-description-error" style="display: none;">This field is required.</div>
                </div>
            </div>
            <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
        `;
        container.appendChild(newInputGroup);
        updateRemoveButtonVisibility(); // Update "Remove" buttons visibility
    });

    // Remove a URL group when the "Remove" button is clicked
    document.getElementById('Pointers-container').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-Pointers')) {
            event.target.closest('.url-group').remove();
            updateRemoveButtonVisibility(); // Update "Remove" buttons visibility
        }
    });

    // Validate the form before submission
    function validateForm() {
        const subTitles = document.querySelectorAll('input[name="sub_title[]"]');
        const subDescriptions = document.querySelectorAll('input[name="sub_description[]"]');
        let isValid = true;

        // Validate Sub Title fields
        subTitles.forEach(input => {
            const errorDiv = input.closest('.form-group').querySelector('.sub-title-error');
            if (errorDiv) {  // Ensure the error div exists before accessing it
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
            const errorDiv = input.closest('.form-group').querySelector('.sub-description-error');
            if (errorDiv) {  // Ensure the error div exists before accessing it
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

    // Handle form submission
    document.getElementById('form-submit-button').addEventListener('click', function(event) {
        const isValid = validateForm();
        if (!isValid) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });

    // Initial visibility check when the page loads
    document.addEventListener('DOMContentLoaded', function() {
        updateRemoveButtonVisibility();
    });
</script>
@endsection