@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>ADHD Section</h1>
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
                            <h3 class="card-title">{{ empty($adhdSection) || !isset($adhdSection[0]) ? 'Add' : 'Edit' }} First Section Details</h3>
                        </div>
                        <form action="{{ route('save-adhd-section') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ old('id', $adhdSection[0]->id ?? '') }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Select Type</label>
                                    <i class="fas fa-info-circle" title="Choose the appropriate type for this section."></i>
                                    <select name="type" class="form-control" id="type">
                                        <option disabled selected>Please Select Type</option>
                                        <option value="Child" {{ old('type', $adhdSection[0]->type ?? '' === 'Child' ? 'selected' : '') }}>Child</option>
                                        <option value="Adult" {{ old('type', $adhdSection[0]->type ?? '' === 'Adult' ? 'selected' : '') }}>Adult</option>
                                    </select>
                                    @error('type')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                    <input type="text" class="form-control" name="first_title" id="title"
                                        placeholder="Enter first title" value="{{ old('first_title',$adhdSection[0]->first_title ?? '') }}">
                                    @error('first_title')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Subtitle Field -->
                                <div class="form-group">
                                    <label for="subtitle">Subtitle</label>
                                    <i class="fas fa-info-circle" title="Provide a brief subtitle that complements the main title of this section."></i>
                                    <input type="text" class="form-control" name="first_subtitle" id="subtitle"
                                        placeholder="Enter first subtitle" value="{{ old('first_subtitle',$adhdSection[0]->first_subtitle ?? '') }}">
                                    @error('first_subtitle')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Description Field -->
                                <div class="form-group">
                                    <label for="description_1">Description</label>
                                    <i class="fas fa-info-circle" title="Describe the purpose or details of this section in 2-3 sentences."></i>
                                    <textarea class="form-control" name="first_description" id="description">{{ old('first_description', $adhdSection[0]->first_description ?? '') }}</textarea>
                                    @error('first_description')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="title">Button Text</label>
                                    <input type="text" class="form-control" name="first_button_content" id="button_content" placeholder="Enter Button Text" value="{{old('first_button_content',$adhdSection[0]->first_button_content ?? '')}}">
                                    @error('first_button_content')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="title">Button Link</label>
                                    <input type="text" class="form-control" name="first_button_link" id="button_link" placeholder="Enter Button Link" value="{{old('first_button_link',$adhdSection[0]->first_button_link ?? '')}}">
                                    @error('first_button_link')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                        <img id="blah" src="{{asset($adhdSection[0]->first_image ?? '')}}" alt="Image Preview" style="width: 130px; display:none" />
                                        <input type="file" class="form-control" name="first_image" id="imgInp" accept="image/*">
                                        @error('first_image')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <hr>
                                    <h3> Second Section Details</h3>
                                    <hr>

                                    <!-- Title Field -->
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                        <input type="text" class="form-control" name="second_title" id="second_title"
                                            placeholder="Enter second title" value="{{ old('second_title',$adhdSection[0]->second_title ?? '') }}">
                                        @error('second_title')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Subtitle Field -->
                                    <div class="form-group">
                                        <label for="subtitle">Subtitle</label>
                                        <i class="fas fa-info-circle" title="Provide a brief subtitle that complements the main title of this section."></i>
                                        <input type="text" class="form-control" name="second_subtitle" id="second_subtitle"
                                            placeholder="Enter second subtitle" value="{{ old('second_subtitle',$adhdSection[0]->second_subtitle ?? '') }}">
                                        @error('second_subtitle')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Description Field -->
                                    <div class="form-group">
                                        <label for="description_1">Description</label>
                                        <i class="fas fa-info-circle" title="Describe the purpose or details of this section in 2-3 sentences."></i>
                                        <textarea class="form-control" name="second_description" id="second_description">{{ old('second_description', $adhdSection[0]->second_description ?? '') }}</textarea>
                                        @error('second_description')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @php
                                    // Check if the $adhdSection exists and contains data before attempting to decode
                                    $pointers = isset($adhdSection[0]) && !empty($adhdSection[0]->pointers)
                                    ? json_decode($adhdSection[0]->pointers)
                                    : [];
                                    @endphp


                                    <!-- Pointers Section -->
                                    <label for="">Add Extra Pointers</label>
                                    <div id="Pointers-container">

                                        @if(!empty($pointers) && is_array($pointers))
                                        <!-- Loop through each pointer and display -->
                                        @foreach($pointers as $index => $pointer)
                                        <div class="form-group url-group">
                                            <label>Sub Title</label>
                                            <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                            <input type="text" name="second_sub_title[]" class="form-control" value="{{$pointer->second_sub_title}}" placeholder="Enter sub title">

                                            <label>Sub Description</label>
                                            <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                            <input type="text" name="second_sub_description[]" class="form-control" value="{{$pointer->second_sub_description}}" placeholder="Enter sub description">

                                            <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                        </div>
                                        @endforeach
                                        @else

                                        <!-- Default empty field when no pointers exist -->
                                        <div class="form-group url-group">
                                            <label>Sub Title</label>
                                            <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                            <input type="text" name="second_sub_title[]" class="form-control" value="" placeholder="Enter sub title">

                                            <label>Sub Description</label>
                                            <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                            <input type="text" name="second_sub_description[]" class="form-control" value="" placeholder="Enter sub description">

                                            <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                        </div>
                                        @endif
                                    </div>
                                    <!-- Add Pointer Button -->
                                    <button type="button" class="btn btn-success" id="add-Pointers">Add Pointer</button>

                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                        <img id="second_img" src="{{asset($adhdSection[0]->second_image ?? '')}}" alt="Image Preview" style="width: 130px; display:none" />
                                        <input type="file" class="form-control" name="second_image" id="second_image" accept="image/*">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
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
        <label>Sub Title</label>
        <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
        <input type="text" name="second_sub_title[]" class="form-control" value="" placeholder="Enter sub title">

        <label>Sub Description</label>
        <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
        <input type="text" name="second_sub_description[]" class="form-control" value="" placeholder="Enter sub description">

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

    // Initial visibility check when the page loads
    document.addEventListener('DOMContentLoaded', function() {
        updateRemoveButtonVisibility();
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
    second_image.onchange = evt => {
        const [file] = second_image.files;
        if (file) {
            second_img.src = URL.createObjectURL(file);
            second_img.style.display = "block"; // Show the image
        } else {
            second_img.style.display = "none"; // Hide the image if no file is selected
            second_img.src = "#"; // Reset the src
        }
    };


    $(document).ready(function() {
        function toggleRemoveButton() {
            // Show or hide the "Remove" button based on the count of pointers
            const pointerCount = $('#Pointers-container .url-group').length;
            if (pointerCount > 1) {
                $('.remove-Pointers').show();
            } else {
                $('.remove-Pointers').hide();
            }
        }

        $('#type').on('change', function() {
            const selectedType = $(this).val();

            if (selectedType) {
                $.ajax({
                    url: "{{ route('fetch-adhd-section-by-type') }}", // Ensure this route exists
                    type: "GET",
                    data: {
                        type: selectedType
                    },
                    success: function(response) {
                        if (response.data) {
                            const section = response.data[0]; // Assuming a single record
                            if (section) {
                                $('#id').val(section.id || '');
                                $('#title').val(section.first_title || '');
                                $('#subtitle').val(section.first_subtitle || '');
                                $('#description').val(section.first_description || '');
                                $('#button_content').val(section.first_button_content || '');
                                $('#button_link').val(section.first_button_link || '');

                                $('#second_title').val(section.second_title || '');
                                $('#second_subtitle').val(section.second_subtitle || '');
                                $('#second_description').val(section.second_description || '');

                                // Update pointers dynamically
                                const pointers = section.pointers ? JSON.parse(section.pointers) : [];
                                const container = $('#Pointers-container');
                                container.empty(); // Clear existing pointers

                                if (pointers.length > 0) {
                                    pointers.forEach(pointer => {
                                        const pointerHtml = `
                                        <div class="form-group url-group">
                                            <label>Sub Title</label>
                                            <input type="text" name="second_sub_title[]" class="form-control" value="${pointer.second_sub_title}" placeholder="Enter sub title">
                                            <label>Sub Description</label>
                                            <input type="text" name="second_sub_description[]" class="form-control" value="${pointer.second_sub_description}" placeholder="Enter sub description">
                                            <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                        </div>
                                    `;
                                        container.append(pointerHtml);
                                    });
                                } else {
                                    // Add a single empty group if no pointers exist
                                    container.append(`
                                    <div class="form-group url-group">
                                        <label>Sub Title</label>
                                        <input type="text" name="second_sub_title[]" class="form-control" value="" placeholder="Enter sub title">
                                        <label>Sub Description</label>
                                        <input type="text" name="second_sub_description[]" class="form-control" value="" placeholder="Enter sub description">
                                        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                    </div>
                                `);
                                }

                                // Update "Remove" button visibility
                                toggleRemoveButton();
                            }
                        } else {
                            alert('No data found for the selected type.');
                        }
                    },
                    error: function() {
                        alert('An error occurred while fetching data.');
                    }
                });
            }
        });

        // Handle dynamic pointer removal
        $(document).on('click', '.remove-Pointers', function() {
            $(this).closest('.url-group').remove();
            toggleRemoveButton(); // Re-evaluate button visibility
        });

        // Add a new pointer
        $('#add-pointer-btn').on('click', function() {
            $('#Pointers-container').append(`
            <div class="form-group url-group">
                <label>Sub Title</label>
                <input type="text" name="second_sub_title[]" class="form-control" placeholder="Enter sub title">
                <label>Sub Description</label>
                <input type="text" name="second_sub_description[]" class="form-control" placeholder="Enter sub description">
                <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
            </div>
        `);
            toggleRemoveButton(); // Re-evaluate button visibility
        });

        // Initial evaluation of the "Remove" button
        toggleRemoveButton();
    });
</script>

@endsection