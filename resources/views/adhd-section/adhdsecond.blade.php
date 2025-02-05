@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>ADHD Assessment Journey Section</h1>
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
                            <h3 class="card-title">{{ empty($adhdSection) || !isset($adhdSection[0]) ? 'Add' : 'Edit' }} Second Section Details</h3>
                        </div>

                        <form action="{{ route('save-adhd-second') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ old('id', $adhdSection[0]->id ?? '') }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="type">Select Type</label>
                                    <i class="fas fa-info-circle" title="Choose the appropriate type for this section."></i>
                                    <select name="type" class="form-control" id="type">
                                        <option disabled selected>Please Select Type</option>
                                        <option value="Child" {{ isset($adhdSection[0]) && $adhdSection[0]->type === 'Child' ? 'selected' : '' }}>Child</option>
                                        <option value="Adult" {{ isset($adhdSection[0]) && $adhdSection[0]->type === 'Adult' ? 'selected' : '' }}>Adult</option>
                                    </select>
                                    @error('type')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="second_title">Title</label>
                                        <i class="fas fa-info-circle" title="Enter a meaningful title."></i>
                                        <input type="text" class="form-control" name="second_title" id="second_title"
                                            placeholder="Enter second title" value="{{ old('second_title', $adhdSection[0]->second_title ?? '') }}" required>
                                        @error('second_title')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="second_subtitle">Subtitle</label>
                                        <i class="fas fa-info-circle" title="Provide a subtitle."></i> <label for="">(Optional)</label>
                                        <input type="text" class="form-control" name="second_subtitle" id="second_subtitle"
                                            placeholder="Enter second subtitle" value="{{ old('second_subtitle', $adhdSection[0]->second_subtitle ?? '') }}">
                                        @error('second_subtitle')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="second_description">Description</label>
                                    <textarea class="form-control" name="second_description" id="second_description"
                                        required>{{ old('second_description', $adhdSection[0]->second_description ?? '') }}</textarea>
                                    @error('second_description')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                @php
                                // Check if the $adhdBenefit[0] exists and contains data before attempting to decode
                                $pointers = isset($adhdSection[0]) && !empty($adhdSection[0]->pointers)
                                ? json_decode($adhdSection[0]->pointers)
                                : [];
                                @endphp
                                <hr>
                                <!-- Pointers -->
                                <label for="">Card Details</label>
                                <div class="form-group">
                                    <label for="heading">Heading</label>
                                    <i class="fas fa-info-circle" title="Provide a Heading."></i> <label for="">(Optional)</label>
                                    <input class="form-control" name="heading" id="heading"
                                        value="{{ old('heading', $adhdSection[0]->heading ?? '') }} " required>
                                    @error('heading')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div id="Pointers-container">
                                    @if(!empty($pointers) && is_array($pointers))
                                    @foreach($pointers as $index => $pointer)
                                    <div class="form-group url-group">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label> Title</label>
                                                <i class="fas fa-info-circle" title="Enter a meaningful title."></i>
                                                <input type="text" name="second_sub_title[]" class="form-control"
                                                    value="{{ $pointer->second_sub_title }}" placeholder="Enter title" required>
                                                @error('second_sub_title.' . $index)
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label> Description</label>
                                                <i class="fas fa-info-circle" title="Enter a meaningful description."></i>
                                                <input type="text" name="second_sub_description[]" class="form-control"
                                                    value="{{ $pointer->second_sub_description }}" placeholder="Enter description" required>
                                                @error('second_sub_description.' . $index)
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="form-group url-group">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label> Title</label>
                                                <i class="fas fa-info-circle" title="Enter a meaningful title."></i>
                                                <input type="text" name="second_sub_title[]" class="form-control" placeholder="Enter title" required>
                                                @error('second_sub_title.0')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label> Description</label>
                                                <i class="fas fa-info-circle" title="Enter a meaningful description."></i>
                                                <input type="text" name="second_sub_description[]" class="form-control" placeholder="Enter description" required>
                                                @error('second_sub_description.0')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                    </div>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-success mb-3" id="add-Pointers">Add Card</button>

                                <div class="form-group">
                                    <label for="second_image">Image</label>
                                    <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                    <img id="blah" src="{{asset($adhdSection[0]->second_image ?? '')}}" alt="Image Preview" style="width: 130px; display:{{empty($adhdSection[0]->second_image) ? 'none' : 'block'}}" />
                                    <input type="file" class="form-control" name="second_image" id="imgInp" accept="image/*">
                                    @error('second_image')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="card-footer">
                                <input type="checkbox" id="status" name="status" {{ ($adhdSection[0]->status ?? '') === 'on' ? 'checked' : '' }}>
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
    CKEDITOR.replace('second_description');

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
                <i class="fas fa-info-circle" title="Provide a meaningful sub title for this section."></i>
                <input type="text" name="second_sub_title[]" class="form-control" value="" placeholder="Enter title" required>
                <div class="text-danger title-error" style="display: none;">At least one field is required.</div>
            </div>
            <div class="form-group col-md-6">
                <label> Description</label>
                <i class="fas fa-info-circle" title="Provide a meaningful sub description for this section."></i>
                <input type="text" name="second_sub_description[]" class="form-control" value="" placeholder="Enter description" required>
                <div class="text-danger description-error" style="display: none;">At least one field is required.</div>
            </div>
        </div>
        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
    `;
        container.appendChild(newInputGroup);
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

    // Validation function
    function validateFields() {
        const urlGroups = document.querySelectorAll('.url-group');
        let isValid = true;

        urlGroups.forEach((group) => {
            const titleInput = group.querySelector('input[name="second_sub_title[]"]');
            const descriptionInput = group.querySelector('input[name="second_sub_description[]"]');
            const titleError = group.querySelector('.title-error');
            const descriptionError = group.querySelector('.description-error');

            // Reset error messages
            if (titleError) titleError.style.display = 'none';
            if (descriptionError) descriptionError.style.display = 'none';

            // Validate at least one field is filled
            if (!titleInput.value.trim() && !descriptionInput.value.trim()) {
                if (titleError) titleError.style.display = 'block';
                if (descriptionError) descriptionError.style.display = 'block';
                isValid = false;
            }
        });

        // if (!isValid) {
        //     alert('Please fill out at least one field in each group.');
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
    $('#type').on('change', function() {
        const selectedType = $(this).val();
        if (selectedType) {
            $.ajax({
                url: "{{ route('fetch-adhd-second-section-by-type') }}", // Update with your route
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
                        // Populate other fields
                        $('#id').val(section.id || '');
                        CKEDITOR.instances.second_description.setData(section.second_description || '');
                        $('#second_title').val(section.second_title || '');
                        $('#second_subtitle').val(section.second_subtitle || '');
                        $('#heading').val(section.heading || '');
                        $('#status').prop('checked', section.status === 'on');
                        const imageUrl = section.second_image || '';
                        $('#blah').attr('src', imageUrl ? imageUrl : '#'); // Use the image URL or reset

                        // Populate pointers
                        const container = $('#Pointers-container');
                        container.empty();
                        const pointers = section.pointers ? JSON.parse(section.pointers) : [];
                        // console.log(pointers);
                        if (pointers.length > 0) {
                            pointers.forEach(pointer => {
                                appendPointer(container, pointer);
                            });
                        } else {
                            appendPointer(container); // Add an empty group if no pointers exist
                        }
                    } else {
                        // Reset fields if no data is found
                        $('#id, #second_title, #second_subtitle').val('');
                        CKEDITOR.instances.second_description.setData('');
                        $('#status').prop('checked', false);

                        // Clear and add empty fields in pointers
                        const container = $('#Pointers-container');
                        container.empty();
                        appendPointer(container); // Add one empty group
                    }

                    updateRemoveButtonVisibility(); // Update visibility of "Remove" buttons
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

    // Append pointer dynamically
    function appendPointer(container, data = {}) {
        const newInputGroup = document.createElement('div');
        newInputGroup.classList.add('form-group', 'url-group');
        newInputGroup.innerHTML = `
        <div class="row">
            <div class="form-group col-md-6">
                <label> Title</label>
                <i class="fas fa-info-circle" title="Provide a meaningful sub title for this section."></i>
                <input type="text" name="second_sub_title[]" class="form-control" value="${data.second_sub_title || ''}" placeholder="Enter title" required>
                <div class="text-danger title-error" style="display: none;">At least one field is required.</div>
            </div>
            <div class="form-group col-md-6">
                <label> Description</label>
                <i class="fas fa-info-circle" title="Provide a meaningful description for this section."></i>
                <input type="text" name="second_sub_description[]" class="form-control" value="${data.second_sub_description || ''}" placeholder="Enter description" required>
                <div class="text-danger description-error" style="display: none;">At least one field is required.</div>
            </div>
        </div>
        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
    `;
        container.append(newInputGroup);
    }

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