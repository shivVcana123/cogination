@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Join Community Section</h1>
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
                                {{ empty($joinCommunitySection) || !isset($joinCommunitySection[0]) ? 'Add' : 'Edit' }} Join Community Details
                            </h3>
                        </div>


                        <form action="{{ route('save-join-community-section') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ old('id', $joinCommunitySection[0]->id ?? '') }}">

                            <div class="card-body">
                                <div class="row">
                                    <!-- Title Field -->
                                    <div class="form-group col-md-6">
                                        <label for="title">Title</label>
                                        <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                        <input type="text" class="form-control" name="title" id="title"
                                            placeholder="Enter title" value="{{ old('title', $joinCommunitySection[0]->title ?? '') }}">
                                        @error('title')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Subtitle Field -->
                                    <div class="form-group col-md-6">
                                        <label for="subtitle">Subtitle</label>
                                        <i class="fas fa-info-circle" title="Provide a brief subtitle that complements the main title of this section."></i>
                                        <input type="text" class="form-control" name="subtitle" id="subtitle"
                                            placeholder="Enter subtitle" value="{{ old('subtitle', $joinCommunitySection[0]->subtitle ?? '') }}">
                                        @error('subtitle')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>




                                <!-- Description Field -->
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <i class="fas fa-info-circle" title="Describe the purpose or details of this section in 2-3 sentences."></i>
                                    <textarea class="form-control" name="description" id="description">{{ old('description', $joinCommunitySection[0]->description ?? '') }}</textarea>
                                    @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <hr>

                                @php
                                // Check if the $joinCommunitySection exists and contains data before attempting to decode
                                $pointers = isset($joinCommunitySection[0]) && !empty($joinCommunitySection[0]->pointers)
                                ? json_decode($joinCommunitySection[0]->pointers)
                                : [];
                                @endphp


                                <!-- Pointers Section -->
                                <label for="">Add Extra Pointers</label>
                                <div id="Pointers-container">

                                    @if(!empty($pointers) && is_array($pointers))
                                    <!-- Loop through each pointer and display -->
                                    @foreach($pointers as $index => $pointer)
                                    <div class="form-group url-group">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Sub Title</label>
                                                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                                <input type="text" name="sub_title[]" class="form-control" value="{{$pointer->sub_title}}" placeholder="Enter sub title">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Sub Description</label>
                                                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                                <input type="text" name="sub_description[]" class="form-control" value="{{$pointer->sub_description}}" placeholder="Enter sub description">
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
                                                <label>Sub Title</label>
                                                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                                <input type="text" name="sub_title[]" class="form-control" value="" placeholder="Enter sub title">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Sub Description</label>
                                                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                                <input type="text" name="sub_description[]" class="form-control" value="" placeholder="Enter sub description">
                                            </div>

                                        </div>

                                        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                    </div>
                                    @endif
                                </div>
                                <!-- Add Pointer Button -->
                                <button type="button" class="btn btn-success" id="add-Pointers">Add Pointer</button>

                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                    <img id="blah" src="{{asset($joinCommunitySection[0]->image ?? '')}}" alt="Image Preview" style="width: 130px; display:{{empty($joinCommunitySection[0]->image) ? 'none' : 'block'}}" />
                                    <input type="file" class="form-control" name="image" id="imgInp" accept="image/*">
                                    @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="card-footer">
                            <input type="checkbox" id="status" name="status" {{ ($joinCommunitySection[0]->status ?? '') === 'on' ? 'checked' : '' }}>
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
    CKEDITOR.replace('description');
    // function updateRemoveButtonVisibility() {
    //     const urlGroups = document.querySelectorAll('.url-group');
    //     urlGroups.forEach((group) => {
    //         const removeButton = group.querySelector('.remove-Pointers');
    //         removeButton.style.display = urlGroups.length > 1 ? 'inline-block' : 'none';
    //     });
    // }

    // document.getElementById('add-Pointers').addEventListener('click', function() {
    //     const container = document.getElementById('Pointers-container');
    //     const newInputGroup = document.createElement('div');
    //     newInputGroup.classList.add('form-group', 'url-group');
    //     newInputGroup.innerHTML = `
    //    <div class="row">
    //                                         <div class="form-group col-md-6">
    //                                             <label>Sub Title</label>
    //                                             <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
    //                                             <input type="text" name="sub_title[]" class="form-control" value="" placeholder="Enter sub title">
    //                                         </div>
    //                                         <div class="form-group col-md-6">
    //                                             <label>Sub Description</label>
    //                                             <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
    //                                             <input type="text" name="sub_description[]" class="form-control" value="" placeholder="Enter sub description">
    //                                         </div>
                                         
    //                                     </div>

    //     <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
    // `;
    //     container.appendChild(newInputGroup);
    //     updateRemoveButtonVisibility(); // Update "Remove" buttons visibility
    // });

    // document.getElementById('Pointers-container').addEventListener('click', function(event) {
    //     if (event.target.classList.contains('remove-Pointers')) {
    //         event.target.closest('.url-group').remove();
    //         updateRemoveButtonVisibility(); // Update "Remove" buttons visibility
    //     }
    // });

    // // Initial visibility check when the page loads
    // document.addEventListener('DOMContentLoaded', function() {
    //     updateRemoveButtonVisibility();
    // });


    // // Initial visibility check when the page loads
    // document.addEventListener('DOMContentLoaded', function() {
    //     updateRemoveButtonVisibility();
    // });

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
                <label>Sub Title</label>
                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                <input type="text" name="sub_title[]" class="form-control" placeholder="Enter sub title">
                <div class="text-danger sub-title-error" style="display: none;">This field is required.</div>
            </div>
            <div class="form-group col-md-6">
                <label>Sub Description</label>
                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                <input type="text" name="sub_description[]" class="form-control" placeholder="Enter sub description">
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

// Validation logic
document.getElementById('form-submit-button').addEventListener('click', function (event) {
    const subTitles = document.querySelectorAll('input[name="sub_title[]"]');
    const subDescriptions = document.querySelectorAll('input[name="sub_description[]"]');
    let isValid = true;

    // Clear previous error messages
    document.querySelectorAll('.validation-error').forEach(error => error.remove());

    // Validate Sub Title and Sub Description fields
    subTitles.forEach(input => {
        if (!input.value.trim()) {
            isValid = false;
            showValidationError(input, 'Sub Title is required.');
        }
    });

    subDescriptions.forEach(input => {
        if (!input.value.trim()) {
            isValid = false;
            showValidationError(input, 'Sub Description is required.');
        }
    });

    if (!isValid) {
        event.preventDefault(); // Prevent form submission if validation fails
    }
});

function showValidationError(input, message) {
    const errorMessage = document.createElement('div');
    errorMessage.classList.add('validation-error');
    errorMessage.style.color = 'red';
    errorMessage.textContent = message;
    input.parentElement.appendChild(errorMessage);
}

// Initial visibility check when the page loads
document.addEventListener('DOMContentLoaded', function () {
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