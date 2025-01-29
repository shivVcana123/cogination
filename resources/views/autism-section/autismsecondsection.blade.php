@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Autism Section</h1>
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
                            <h3 class="card-title">{{ empty($autismSection) || !isset($autismSection[0]) ? 'Add' : 'Edit' }} Second Section Details</h3>
                        </div>
                        <form action="{{ route('save-autism-second-section') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ old('id', $autismSection[0]->id ?? '') }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Select Type</label>
                                    <i class="fas fa-info-circle" title="Choose the appropriate type for this section."></i>
                                    <select name="type" class="form-control" id="type">
                                        <option disabled selected>Please Select Type</option>
                                        <option value="Child" {{ isset($autismSection[0]) && $autismSection[0]->type === 'Child' ? 'selected' : ''}}>Child</option>
                                        <option value="Adult" {{ isset($autismSection[0]) && $autismSection[0]->type === 'Adult' ? 'selected' : '' }}>Adult</option>
                                    </select>
                                    @error('type')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="row">

                                        <!-- Title Field -->
                                        <div class="form-group col-md-6">
                                            <label for="title">Title</label>
                                            <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                            <input type="text" class="form-control" name="second_title" id="second_title"
                                                placeholder="Enter title" value="{{ old('second_title',$autismSection[0]->second_title ?? '') }}">
                                            @error('second_title')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Subtitle Field -->
                                        <div class="form-group col-md-6">
                                            <label for="subtitle">Subtitle</label>
                                            <i class="fas fa-info-circle" title="Provide a brief subtitle that complements the main title of this section."></i>
                                            <input type="text" class="form-control" name="second_subtitle" id="second_subtitle"
                                                placeholder="Enter subtitle" value="{{ old('second_subtitle',$autismSection[0]->second_subtitle ?? '') }}">
                                            @error('second_subtitle')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="title">Button Text</label>
                                            <i class="fas fa-info-circle" title="The Button Text field allows you to specify the label that will appear on the button."></i>
                                            <input type="text" class="form-control" name="second_button_content" id="second_button_content" placeholder="Enter Button Text" value="{{old('second_button_content',$autismSection[0]->second_button_content ?? '')}}">
                                            @error('second_button_content')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="title">Button Link</label>
                                            <i class="fas fa-info-circle" title="The Button Link field is where you provide the URL the button will navigate to when clicked."></i>

                                            <input type="text" class="form-control" name="second_button_link" id="second_button_link" placeholder="Enter Button Link" value="{{old('second_button_link',$autismSection[0]->second_button_link ?? '')}}">
                                            @error('second_button_link')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Description Field -->
                                    <div class="form-group">
                                        <label for="description_1">Description</label>
                                        <i class="fas fa-info-circle" title="Describe the purpose or details of this section in 2-3 sentences."></i>
                                        <textarea class="form-control" name="second_description" id="second_description">{{ old('second_description', $autismSection[0]->second_description ?? '') }}</textarea>
                                        @error('second_description')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    @php
                                    // Check if the $autismSection exists and contains data before attempting to decode
                                    $pointers = isset($autismSection[0]) && !empty($autismSection[0]->pointers)
                                    ? json_decode($autismSection[0]->pointers)
                                    : [];
                                    @endphp


                                    <!-- Pointers Section -->
                                    <label for="">Card Details</label>
                                    <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>

                                    <div id="Pointers-container">

                                        @if(!empty($pointers) && is_array($pointers))
                                        <!-- Loop through each pointer and display -->
                                        @foreach($pointers as $index => $pointer)
                                        <div class="form-group url-group">
                                            <label>Sub Title</label>
                                            <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                            <input type="text" name="second_sub_title[]" class="form-control" value="{{$pointer->second_sub_title}}" placeholder="Enter title">

                                            <button type="button" class="btn btn-danger remove-Pointers mt-3">Remove</button>
                                        </div>
                                        @endforeach
                                        @else

                                        <!-- Default empty field when no pointers exist -->
                                        <div class="form-group url-group">
                                            <label> Title</label>
                                            <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                            <input type="text" name="second_sub_title[]" class="form-control" value="" placeholder="Enter  title">

                                            <button type="button" class="btn btn-danger remove-Pointers mt-3">Remove</button>
                                        </div>
                                        @endif
                                    </div>
                                    <!-- Add Pointer Button -->
                                    <button type="button" class="btn btn-success mb-3" id="add-Pointers">Add Card</button>

                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                        <img id="second_img" src="{{asset($autismSection[0]->second_image ?? '')}}" alt="Image Preview" style="width: 130px; display:{{empty($autismSection[0]->second_image) ? 'none' : 'block'}}" />
                                        <input type="file" class="form-control" name="second_image" id="second_image" accept="image/*">
                                        @error('second_image')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="card-footer">
                                    <input type="checkbox" id="status" name="status" {{ ($autismSection[0]->status ?? '') === 'on' ? 'checked' : '' }}>
                                    <label for="status">Show On Website</label>
                                    <button type="submit" id="form-submit-button" class="btn btn-primary">Submit</button>
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
    CKEDITOR.replace('second_description');

    function updateRemoveButtonVisibility() {
        const urlGroups = document.querySelectorAll('.url-group');
        urlGroups.forEach((group) => {
            const removeButton = group.querySelector('.remove-Pointers');
            if (removeButton) {
                removeButton.style.display = urlGroups.length > 1 ? 'inline-block' : 'none';
            }
        });
    }

    document.getElementById('add-Pointers').addEventListener('click', function() {
        const container = document.getElementById('Pointers-container');
        const newInputGroup = document.createElement('div');
        newInputGroup.classList.add('form-group', 'url-group');
        newInputGroup.innerHTML = `
        <label> Title</label>
        <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
        <input type="text" name="second_sub_title[]" class="form-control" placeholder="Enter title">
        <div class="text-danger error-message" style="display: none;">Sub Title is required.</div>

        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
    `;
        container.appendChild(newInputGroup);
        updateRemoveButtonVisibility(); // Update "Remove" buttons visibility
    });

    document.getElementById('Pointers-container').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-Pointers')) {
            const group = event.target.closest('.url-group');
            if (group) {
                group.remove();
            }
            updateRemoveButtonVisibility(); // Update "Remove" buttons visibility
        }
    });

    // Validate input fields
    function validateFields() {
        const urlGroups = document.querySelectorAll('.url-group');
        let isValid = true;

        urlGroups.forEach((group) => {
            const input = group.querySelector('input[name="second_sub_title[]"]');
            const errorMessage = group.querySelector('.error-message');

            if (errorMessage) {
                errorMessage.style.display = 'none'; // Reset error message
            }

            if (input && !input.value.trim()) {
                if (errorMessage) {
                    errorMessage.style.display = 'block';
                }
                isValid = false;
            }
        });

        return isValid;
    }

    // Submit button handler
    document.getElementById('form-submit-button').addEventListener('click', function(event) {
        if (!validateFields()) {
            event.preventDefault(); // Prevent form submission if validation fails
            // alert('Please fill in all required fields.');
        }
    });

    // Initial visibility check when the page loads
    document.addEventListener('DOMContentLoaded', function() {
        updateRemoveButtonVisibility();
    });

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
                    url: "{{ route('fetch-autism-second-section-by-type') }}", // Ensure this route exists
                    type: "GET",
                    data: {
                        type: selectedType
                    },
                    success: function(response) {
                        if (response && response.data && response.data.length > 0) {
                            const section = response.data[0]; // Assuming a single record
                            if (section) {
                                $('#id').val(section.id || '');
                                CKEDITOR.instances.second_description.setData(section.second_description || '');
                                $('#second_title').val(section.second_title || '');
                                $('#second_subtitle').val(section.second_subtitle || '');
                                // $('#second_description').val(section.second_description || '');
                                $('#second_button_content').val(section.second_button_content || '');
                                $('#second_button_link').val(section.second_button_link || '');
                                $('#status').prop('checked', section.status === 'on');

                                const imageUrl = section.second_image || '';
                                $('#second_img').attr('src', imageUrl ? imageUrl : '#'); 

                                // Update pointers dynamically
                                const pointers = section.pointers ? JSON.parse(section.pointers) : [];
                                const container = $('#Pointers-container');
                                container.empty(); // Clear existing pointers

                                if (pointers.length > 0) {
                                    pointers.forEach(pointer => {
                                        const pointerHtml = `
                                    <div class="form-group url-group">
                                        <label>Sub Title</label>
                                        <input type="text" name="second_sub_title[]" class="form-control" value="${pointer.second_sub_title || ''}" placeholder="Enter title">
                                       
                                        <button type="button" class="btn btn-danger remove-Pointers mt-3">Remove</button>
                                    </div>
                                `;
                                        container.append(pointerHtml);
                                    });
                                } else {
                                    // Add a single empty group if no pointers exist
                                    container.append(`
                                <div class="form-group url-group">
                                    <label> Title</label>
                                    <input type="text" name="second_sub_title[]" class="form-control" value="" placeholder="Enter title">
                                   
                                    <button type="button" class="btn btn-danger remove-Pointers mt-3">Remove</button>
                                </div>
                            `);
                                }

                                // Update "Remove" button visibility
                                toggleRemoveButton();
                            }
                        } else {
                            // Clear fields if no data is found
                            $('#id').val('');
                            CKEDITOR.instances.second_description.setData('');
                            $('#second_title').val('');
                            $('#second_subtitle').val('');
                            // $('#second_description').val('');
                            $('#second_button_content').val('');
                            $('#second_button_link').val('');
                            $('#status').val('');

                            // Clear pointers and add a single empty group
                            const container = $('#Pointers-container');
                            container.empty();
                            container.append(`
                        <div class="form-group url-group">
                            <label> Title</label>
                            <input type="text" name="second_sub_title[]" class="form-control" value="" placeholder="Enter title">
                           
                            <button type="button" class="btn btn-danger remove-Pointers mt-3">Remove</button>
                        </div>
                    `);

                            // Update "Remove" button visibility
                            toggleRemoveButton();

                            // alert('No data found for the selected type.');
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
            <label> Title</label>
            <input type="text" name="second_sub_title[]" class="form-control" placeholder="Enter sub title">
            <label>Sub Description</label>
            <input type="text" name="second_sub_description[]" class="form-control" placeholder="Enter description">
            <button type="button" class="btn btn-danger remove-Pointers mt-3">Remove</button>
        </div>
    `);
            toggleRemoveButton(); // Re-evaluate button visibility
        });

        // Initial evaluation of the "Remove" button
        toggleRemoveButton();
    });
</script>

@endsection