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
                                        <option value="Child" {{ $adhdSection[0]->type === 'Child' ? 'selected' : '' }}>Child</option>
                                        <option value="Adult" {{ $adhdSection[0]->type === 'Adult' ? 'selected' : ''}}>Adult</option>
                                    </select>
                                    @error('type')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">

                                    <div class="form-group col-md-6">
                                        <label for="title">Title</label>
                                        <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                        <input type="text" class="form-control" name="first_title" id="title"
                                            placeholder="Enter first title" value="{{ old('first_title',$adhdSection[0]->first_title ?? '') }}">
                                        @error('first_title')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Subtitle Field -->
                                    <div class="form-group col-md-6">
                                        <label for="subtitle">Subtitle</label>
                                        <i class="fas fa-info-circle" title="Provide a brief subtitle that complements the main title of this section."></i>
                                        <input type="text" class="form-control" name="first_subtitle" id="subtitle"
                                            placeholder="Enter first subtitle" value="{{ old('first_subtitle',$adhdSection[0]->first_subtitle ?? '') }}">
                                        @error('first_subtitle')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="title">Button Text</label>
                                        <i class="fas fa-info-circle" title="The Button Text field allows you to specify the label that will appear on the button."></i>
                                        <input type="text" class="form-control" name="first_button_content" id="button_content" placeholder="Enter Button Text" value="{{old('first_button_content',$adhdSection[0]->first_button_content ?? '')}}">
                                        @error('first_button_content')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="title">Button Link</label>
                                        <i class="fas fa-info-circle" title="The Button Link field is where you provide the URL the button will navigate to when clicked."></i>
                                        <input type="text" class="form-control" name="first_button_link" id="button_link" placeholder="Enter Button Link" value="{{old('first_button_link',$adhdSection[0]->first_button_link ?? '')}}">
                                        @error('first_button_link')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
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

                                <div class="row">

                                    <!-- Title Field -->
                                    <div class="form-group col-md-6">
                                        <label for="title">Title</label>
                                        <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                        <input type="text" class="form-control" name="second_title" id="second_title"
                                            placeholder="Enter second title" value="{{ old('second_title',$adhdSection[0]->second_title ?? '') }}">
                                        @error('second_title')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Subtitle Field -->
                                    <div class="form-group col-md-6">
                                        <label for="subtitle">Subtitle</label>
                                        <i class="fas fa-info-circle" title="Provide a brief subtitle that complements the main title of this section."></i>
                                        <input type="text" class="form-control" name="second_subtitle" id="second_subtitle"
                                            placeholder="Enter second subtitle" value="{{ old('second_subtitle',$adhdSection[0]->second_subtitle ?? '') }}">
                                        @error('second_subtitle')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
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
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Sub Title</label>
                                                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                                <input type="text" name="second_sub_title[]" class="form-control" value="{{$pointer->second_sub_title}}" placeholder="Enter sub title">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Sub Description</label>
                                                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                                <input type="text" name="second_sub_description[]" class="form-control" value="{{$pointer->second_sub_description}}" placeholder="Enter sub description">
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
                                                <i class="fas fa-info-circle" title="Provide a meaningful sub title for this section."></i>
                                                <input type="text" name="second_sub_title[]" class="form-control" value="" placeholder="Enter sub title">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Sub Description</label>
                                                <i class="fas fa-info-circle" title="Provide a meaningful sub description for this section."></i>
                                                <input type="text" name="second_sub_description[]" class="form-control" value="" placeholder="Enter sub description">
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
                                    <img id="second_img" src="{{asset($adhdSection[0]->second_image ?? '')}}" alt="Image Preview" style="width: 130px; display:none" />
                                    <input type="file" class="form-control" name="second_image" id="second_image" accept="image/*">
                                    @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="card-footer">
                            <input type="checkbox" id="status" name="status" {{ ($adhdSection[0]->status ?? '') === 'on' ? 'checked' : '' }}>
                            <label for="status">Show On Website</label>
                                <button type="submit" class="btn btn-primary">Submit</button>
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
    CKEDITOR.replace('second_description');
    function updateRemoveButtonVisibility() {
        const urlGroups = document.querySelectorAll('.url-group');
        console.log("Current URL Groups Count:", urlGroups.length); // Log count
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
                                            <label>Sub Title</label>
                                            <i class="fas fa-info-circle" title="Provide a meaningful sub title for this section."></i>
                                                <input type="text" name="second_sub_title[]" class="form-control" value="" placeholder="Enter sub title">
                                            </div>
                                            <div class="form-group col-md-6">
                                            <label>Sub Description</label>
                                            <i class="fas fa-info-circle" title="Provide a meaningful sub description for this section."></i>
                                                <input type="text" name="second_sub_description[]" class="form-control" value="" placeholder="Enter sub description">
                                            </div>
                                         
                                        </div>

        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
    `;
        container.appendChild(newInputGroup);
        console.log("Pointer added:", newInputGroup); // Log new pointer
        updateRemoveButtonVisibility();
    });

    document.getElementById('Pointers-container').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-Pointers')) {
            const groupToRemove = event.target.closest('.url-group');
            console.log("Pointer removed:", groupToRemove); // Log removed pointer
            groupToRemove.remove();
            updateRemoveButtonVisibility();
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        console.log("Page Loaded - Initial Check");
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
        // Function to toggle the "Remove" button visibility
        function toggleRemoveButton() {
            const pointerCount = $('#Pointers-container .url-group').length;
            $('.remove-Pointers').toggle(pointerCount > 1);
        }

        // Function to append a pointer
        function appendPointer(container, data = {
            second_sub_title: '',
            second_sub_description: ''
        }) {
            const pointerHtml = `
            <div class="form-group url-group">
                <div class="row">
                    <div class="form-group col-md-6">
                    <label>Sub Title</label>
                    <i class="fas fa-info-circle" title="Provide a meaningful sub title for this section."></i>
                        <input type="text" name="second_sub_title[]" class="form-control" value="${data.second_sub_title}" placeholder="Enter sub title">
                    </div>
                    <div class="form-group col-md-6">
                    <label>Sub Description</label>
                    <i class="fas fa-info-circle" title="Provide a meaningful sub description for this section."></i>
                        <input type="text" name="second_sub_description[]" class="form-control" value="${data.second_sub_description}" placeholder="Enter sub description">
                    </div>
                    <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                </div>
            </div>`;
            container.append(pointerHtml);
        }

        // Handle change event on the #type dropdown
        $('#type').on('change', function() {
            const selectedType = $(this).val();

            if (selectedType) {
                $.ajax({
                    url: "{{ route('fetch-adhd-section-by-type') }}", // Update with your route
                    type: "GET",
                    data: {
                        type: selectedType
                    },
                    beforeSend: function() {
                        $('#loading-spinner').show(); // Show loader
                    },
                    success: function(response) {
                        const section = response.data?.[0] || null;

                        if (section) {
                            // Populate form fields
                            $('#id').val(section.id || '');
                            $('#title').val(section.first_title || '');
                            $('#subtitle').val(section.first_subtitle || '');
                            $('#description').val(section.first_description || '');
                            $('#button_content').val(section.first_button_content || '');
                            $('#button_link').val(section.first_button_link || '');
                            $('#second_title').val(section.second_title || '');
                            $('#second_subtitle').val(section.second_subtitle || '');
                            $('#second_description').val(section.second_description || '');
                            $('#status').prop('checked', section.status === 'on');

                            // Populate pointers
                            const container = $('#Pointers-container');
                            container.empty();
                            const pointers = section.pointers ? JSON.parse(section.pointers) : [];
                            if (pointers.length > 0) {
                                pointers.forEach(pointer => appendPointer(container, pointer));
                            } else {
                                appendPointer(container); // Add an empty group if no pointers
                            }
                        } else {
                            // Reset form fields if no data is found
                            $('#id, #title, #subtitle, #description, #button_content, #button_link, #second_title, #second_subtitle, #second_description').val('');
                            const container = $('#Pointers-container');
                            container.empty();
                            appendPointer(container); // Add a single empty group
                        }

                        toggleRemoveButton(); // Re-evaluate "Remove" button visibility
                    },
                    error: function() {
                        alert('An error occurred while fetching data.');
                    },
                    complete: function() {
                        $('#loading-spinner').hide(); // Hide loader
                    }
                });
            }
        });

        // Handle click event to dynamically add pointers
        $('#add-pointer-btn').on('click', function() {
            appendPointer($('#Pointers-container'));
            toggleRemoveButton();
        });

        // Handle click event to remove pointers
        $(document).on('click', '.remove-Pointers', function() {
            $(this).closest('.url-group').remove();
            toggleRemoveButton();
        });

        // Initial setup
        toggleRemoveButton();
    });
</script>

@endsection