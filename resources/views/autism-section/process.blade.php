@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Autism Process Section</h1>
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
                            <h3 class="card-title">{{ empty($autismProcess) ? 'Add' : 'Edit' }} Process Section</h3>
                        </div>
                        <form action="{{ route('save-process-section') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ old('id', $autismProcess[0]->id ?? '') }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="type">Select Type</label>
                                    <i class="fas fa-info-circle" title="Choose the appropriate type for this section."></i>
                                    <select name="type" id="type" class="form-control">
                                        <option value="" disabled selected>Please Select Type</option>
                                        <option value="Child" {{ old('type', $autismProcess[0]->type ?? '') === 'Child' ? 'selected' : '' }}>Child</option>
                                        <option value="Adult" {{ old('type', $autismProcess[0]->type ?? '') === 'Adult' ? 'selected' : '' }}>Adult</option>
                                    </select>
                                    @error('type')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">

                                    <div class="form-group col-md-6">
                                        <label for="title">Title</label>
                                        <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>

                                        <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" value="{{ old('title', $autismProcess[0]->title ?? '') }}" required>
                                        @error('title')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="subtitle">Subtitle</label>
                                        <i class="fas fa-info-circle" title="Provide a brief subtitle that complements the main title of this section."></i> <label class="option-area">(Optional)</label>
                                        <input type="text" class="form-control" name="subtitle" id="subtitle" placeholder="Enter subtitle" value="{{ old('subtitle', $autismProcess[0]->subtitle ?? '') }}">
                                        @error('subtitle')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <i class="fas fa-info-circle" title="Describe the purpose or details of this section in 2-3 sentences."></i>

                                    <textarea name="description" id="description" class="form-control" required>{{ old('description', $autismProcess[0]->description ?? '') }}</textarea>
                                    @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <hr>
                                <!-- Pointers Section -->
                                <h5>Card Details</h5>

                                <div id="Pointers-container">
                                    @php
                                    $pointers = json_decode($autismProcess[0]->pointers ?? '[]');
                                    @endphp
                                    @if(!empty($pointers) && is_array($pointers))
                                    @foreach ($pointers as $index => $pointer)
                                    <div class="form-group url-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label> Title</label>
                                              <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                                <input type="text" name="sub_title[]" class="form-control" value="{{ $pointer->sub_title }}" placeholder="Enter title" required>
                                                @error('sub_title')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label> Description</label>
                                              <i class="fas fa-info-circle" title="Describe the purpose or details of this section in 2-3 sentences."></i>
                                                <input name="sub_description[]" class="form-control" value="{{ $pointer->sub_description }}" required>
                                                @error('sub_description')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-danger remove-Pointers mt-2">Remove</button>
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="form-group url-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label> Title</label>
                                                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                                <input type="text" name="sub_title[]" class="form-control" value="" placeholder="Enter title" required>
                                                @error('sub_title')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label> Description</label>
                                                <i class="fas fa-info-circle" title="Describe the purpose or details of this section in 2-3 sentences."></i>

                                                <textarea name="sub_description[]" class="form-control" required></textarea>
                                                @error('sub_description')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                    </div>
                                    @endif
                                </div>
                                <button type="button" id="add-Pointers" class="btn btn-success">Add Card</button>

                                <div class="card-footer">
                                    <input type="checkbox" id="status" name="status" {{ ($autismProcess[0]->status ?? '') === 'on' ? 'checked' : '' }}>
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

<!-- <script>
    CKEDITOR.replace('description');

    // Handle adding new pointers (cards)
    document.getElementById('add-Pointers').addEventListener('click', function() {
        const container = document.getElementById('Pointers-container');
        const div = document.createElement('div');
        div.classList.add('form-group', 'url-group');
        div.innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <label>Title</label>
                    <input type="text" name="sub_title[]" class="form-control sub-title-input" placeholder="Enter title" required>
                </div>
                <div class="col-md-6">
                    <label>Description</label>
                    <textarea name="sub_description[]" class="form-control" required></textarea>
                </div>
            </div>
            <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
        `;
        container.appendChild(div);
        toggleRemoveButtons();
    });

    // Handle removing pointers (cards)
    document.getElementById('Pointers-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-Pointers')) {
            e.target.closest('.url-group').remove();
            toggleRemoveButtons();
        }
    });

    // Toggle visibility of remove buttons
    function toggleRemoveButtons() {
        const pointers = document.querySelectorAll('.url-group');
        pointers.forEach((pointer) => {
            const removeButton = pointer.querySelector('.remove-Pointers');
            removeButton.style.display = pointers.length > 1 ? 'inline-block' : 'none';
        });
    }

    // Initial check on page load
    toggleRemoveButtons();

    // Form submission validation
    document.getElementById('form-submit-button').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent form submission

        const subTitles = document.querySelectorAll('.sub-title-input');
        const subDescriptions = document.querySelectorAll('.sub-description-input');
        let isValid = true;

        // Remove existing error messages
        document.querySelectorAll('.validation-error').forEach(error => error.remove());

        subTitles.forEach((input, index) => {
            // Validate sub_title
            if (!input.value.trim()) {
                isValid = false;

                // Display error message for sub_title
                const errorMessage = document.createElement('div');
                errorMessage.classList.add('validation-error');
                errorMessage.style.color = 'red';
                errorMessage.style.paddingBottom = '10px';
                errorMessage.textContent = 'Title is required.';
                input.parentElement.appendChild(errorMessage);
            }

            // Validate sub_description only if the corresponding element exists
            const subDescription = subDescriptions[index];
            if (subDescription && !subDescription.value.trim()) {
                isValid = false;

                // Display error message for sub_description
                const errorMessage = document.createElement('div');
                errorMessage.classList.add('validation-error');
                errorMessage.style.color = 'red';
                errorMessage.textContent = 'Description is required.';
                subDescription.parentElement.appendChild(errorMessage);
            }
        });

        // Only submit if valid
        if (isValid) {
            // Simulate form submission (or call your actual form submission method here)
            console.log('Form is valid, submitting...');
            // Add actual form submission code here, e.g., make an AJAX request or submit the form.
            document.querySelector('form').submit();
        } else {
            console.log('Form has errors, not submitting.');
        }
    });

    // Handle type change for AJAX
    $('#type').on('change', function() {
        const selectedType = $(this).val();
        if (selectedType) {
            $.ajax({
                url: "{{ route('fetch-process-section-by-type') }}",
                type: "GET",
                data: {
                    type: selectedType
                },
                success: function(response) {
                    if (response && response.data && response.data.length > 0) {
                        const section = response.data[0];
                        if (section) {
                            $('#id').val(section.id || '');
                            $('#title').val(section.title || '');
                            $('#subtitle').val(section.subtitle || '');
                            $('#status').prop('checked', section.status === 'on');
                            CKEDITOR.instances.description.setData(section.description || '');

                            const pointers = section.pointers ? JSON.parse(section.pointers) : [];
                            const container = $('#Pointers-container');
                            container.empty();

                            if (pointers.length > 0) {
                                pointers.forEach(pointer => {
                                    const pointerHtml = `
                                        <div class="form-group url-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Title</label>
                                                    <input type="text" name="sub_title[]" class="form-control sub-title-input" value="${pointer.sub_title || ''}" placeholder="Enter title" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Sub Description</label>
                                                    <textarea name="sub_description[]" class="form-control sub-description-input" required>${pointer.sub_description || ''}</textarea>
                                                </div>
                                                <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                            </div>
                                        </div>
                                    `;
                                    container.append(pointerHtml);
                                });
                            } else {
                                container.append(`
                                    <div class="form-group url-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Title</label>
                                                <input type="text" name="sub_title[]" class="form-control sub-title-input" placeholder="Enter title" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Description</label>
                                                <textarea name="sub_description[]" class="form-control sub-description-input" required></textarea>
                                            </div>
                                            <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                        </div>
                                    </div>
                                `);
                            }

                            toggleRemoveButtons();
                        } else {
                            resetForm(); // Reset form if no data is found
                        }
                    }
                },
                error: function() {
                    alert('An error occurred while fetching data.');
                }
            });
        }
    });

    // Reset form fields
    function resetForm() {
        $('#id').val('');
        $('#title').val('');
        $('#subtitle').val('');
        $('#status').prop('checked', false);
        CKEDITOR.instances.description.setData('');
        $('#Pointers-container').empty();
        addEmptyPointer($('#Pointers-container'));
    }

    // Add an empty pointer input
    function addEmptyPointer(container) {
        container.empty();
        container.append(`
            <div class="form-group url-group">
                <div class="row">
                    <div class="col-md-6">
                        <label>Title</label>
                        <input type="text" name="sub_title[]" class="form-control sub-title-input" placeholder="Enter title" required>
                    </div>
                    <div class="col-md-6">
                        <label>Description</label>
                        <textarea name="sub_description[]" class="form-control sub-description-input" required></textarea>
                    </div>
                    <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                </div>
            </div>
        `);
    }
</script> -->


<script>
    $(document).ready(function() {
        CKEDITOR.replace('description');

        // Handle adding new pointers (cards)
        $('#add-Pointers').on('click', function() {
            addEmptyPointer($('#Pointers-container'));
        });

        // Handle removing pointers (cards)
        $(document).on('click', '.remove-Pointers', function() {
            $(this).closest('.url-group').remove();
            toggleRemoveButtons();
        });

        // Toggle remove button visibility
        function toggleRemoveButtons() {
            const pointers = $('.url-group');
            $('.remove-Pointers').toggle(pointers.length > 1);
        }

        // Form submission validation
        $('#form-submit-button').on('click', function(event) {
            event.preventDefault();
            $('.validation-error').remove();

            let isValid = true;
            $('.sub-title-input, .sub-description-input').each(function() {
                if (!$(this).val().trim()) {
                    isValid = false;
                    $(this).after(`<div class="validation-error" style="color: red; padding-bottom: 10px;">This field is required.</div>`);
                }
            });

            if (isValid) {
                console.log('Form is valid, submitting...');
                $('form').submit();
            } else {
                console.log('Form has errors, not submitting.');
            }
        });

        // Handle type change for AJAX
        $('#type').on('change', function() {
            const selectedType = $(this).val();
            if (selectedType) {
                $.ajax({
                    url: "{{ route('fetch-process-section-by-type') }}",
                    type: "GET",
                    data: { type: selectedType },
                    success: function(response) {
                        if (response?.data?.length > 0) {
                            populateForm(response.data[0]);
                        } else {
                            resetForm();
                        }
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }
        });

        // Populate form with fetched data
        function populateForm(section) {
            $('#id').val(section.id || '');
            $('#title').val(section.title || '');
            $('#subtitle').val(section.subtitle || '');
            $('#status').prop('checked', section.status === 'on');

            if (CKEDITOR.instances.description) {
                CKEDITOR.instances.description.setData(section.description || '');
            }

            const pointers = section.pointers ? JSON.parse(section.pointers) : [];
            const container = $('#Pointers-container').empty();

            if (pointers.length > 0) {
                pointers.forEach(pointer => {
                    container.append(`
                        <div class="form-group url-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Title</label>
<i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                    <input type="text" name="sub_title[]" class="form-control sub-title-input" value="${pointer.sub_title || ''}" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Sub Description</label>
<i class="fas fa-info-circle" title="Describe the purpose or details of this section in 2-3 sentences."></i>
                                    <textarea name="sub_description[]" class="form-control sub-description-input" required>${pointer.sub_description || ''}</textarea>
                                </div>
                            </div>
                            <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                        </div>
                    `);
                });
            } else {
                addEmptyPointer(container);
            }

            toggleRemoveButtons();
        }

        // Reset form fields
        function resetForm() {
            $('#id, #title, #subtitle').val('');
            $('#status').prop('checked', false);
            if (CKEDITOR.instances.description) {
                CKEDITOR.instances.description.setData('');
            }
            $('#Pointers-container').empty();
            addEmptyPointer($('#Pointers-container'));
        }

        // Add an empty pointer input
        function addEmptyPointer(container) {
            container.append(`
                <div class="form-group url-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Title</label>
<i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                            <input type="text" name="sub_title[]" class="form-control sub-title-input" placeholder="Enter title" required>
                        </div>
                        <div class="col-md-6">
                            <label>Description</label>
<i class="fas fa-info-circle" title="Describe the purpose or details of this section in 2-3 sentences."></i>
                            <textarea name="sub_description[]" class="form-control sub-description-input" required></textarea>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                </div>
            `);
        }

        // Initial setup
        toggleRemoveButtons();
    });
</script>


@endsection