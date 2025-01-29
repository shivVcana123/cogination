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
                                        <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" value="{{ old('title', $autismProcess[0]->title ?? '') }}">
                                        @error('title')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="subtitle">Subtitle</label>
                                        <i class="fas fa-info-circle" title="Provide a brief subtitle that complements the main title of this section."></i>
                                        <input type="text" class="form-control" name="subtitle" id="subtitle" placeholder="Enter subtitle" value="{{ old('subtitle', $autismProcess[0]->subtitle ?? '') }}">
                                        @error('subtitle')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <i class="fas fa-info-circle" title="Describe the purpose or details of this section in 2-3 sentences."></i>
                                    <textarea name="description" id="description" class="form-control">{{ old('description', $autismProcess[0]->description ?? '') }}</textarea>
                                    @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                </div>

                                <!-- Pointers Section -->
                                <label for="">Add Extra Pointers</label>
                                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>

                                <div id="Pointers-container" class="prcss-cls">
                                    @php
                                    $pointers = json_decode($autismProcess[0]->pointers ?? '[]');
                                    @endphp
                                    @if(!empty($pointers) && is_array($pointers))
                                    @foreach ($pointers as $index => $pointer)
                                    <div class="form-group url-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Sub Title</label>
                                                <input type="text" name="sub_title[]" class="form-control" value="{{ $pointer->sub_title }}" placeholder="Enter sub title">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Sub Description</label>
                                                <textarea name="sub_description[]" class="form-control">{{ $pointer->sub_description }}</textarea>
                                            </div>
                                            <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                        </div>
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="form-group url-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Sub Title</label>
                                                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                                <input type="text" name="sub_title[]" class="form-control sub-title-input" placeholder="Enter sub title">
                                                @error('sub_title')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label>Sub Description</label>
                                                <i class="fas fa-info-circle" title="Provide a meaningful description for this section."></i>
                                                <textarea name="sub_description[]" class="form-control"></textarea>
                                                @error('sub_description')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                    </div>
                                </div>
                                @endif
                                <button type="button" id="add-Pointers" class="btn btn-success">Add Card</button>
                            </div>

                            <div class="card-footer">
                                <input type="checkbox" id="status" name="status" {{ ($autismProcess[0]->status ?? '') === 'on' ? 'checked' : '' }}>
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

    document.getElementById('add-Pointers').addEventListener('click', function() {
        const container = document.getElementById('Pointers-container');
        const div = document.createElement('div');
        div.classList.add('form-group', 'url-group');
        div.innerHTML = `
        <div class="row">
            <div class="col-md-6">
                <label>Sub Title</label>
                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                <input type="text" name="sub_title[]" class="form-control sub-title-input" placeholder="Enter sub title">
                                <div class="text-danger image-error" style="display: none;">The title field is required.</div>

                </div>
            <div class="col-md-6">
                <label>Sub Description</label>
                <i class="fas fa-info-circle" title="Provide a meaningful description for this section."></i>
                <textarea name="sub_description[]" class="form-control"></textarea>
                                <div class="text-danger image-error" style="display: none;">The description field is required.</div>

                </div>
            </div>
            <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
        </div>
            
        `;
        container.appendChild(div);
        toggleRemoveButtons();
    });

    document.getElementById('Pointers-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-Pointers')) {
            e.target.closest('.url-group').remove();
            toggleRemoveButtons();
        }
    });

    function toggleRemoveButtons() {
        const pointers = document.querySelectorAll('.url-group');
        pointers.forEach((pointer) => {
            const removeButton = pointer.querySelector('.remove-Pointers');
            removeButton.style.display = pointers.length > 1 ? 'inline-block' : 'none';
        });
    }

    // Initial check on page load
    toggleRemoveButtons();

    // Validation logic
    document.getElementById('form-submit-button').addEventListener('click', function(event) {
    let isValid = true;

    // Remove existing error messages
    document.querySelectorAll('.validation-error').forEach(error => error.remove());

    // Validate Sub Titles
    document.querySelectorAll('.sub-title-input').forEach(input => {
        if (!input.value.trim()) {
            isValid = false;
            showError(input, "Sub Title is required.");
        }
    });

    // Validate Sub Descriptions
    document.querySelectorAll('textarea[name="sub_description[]"]').forEach(textarea => {
        if (!textarea.value.trim()) {
            isValid = false;
            showError(textarea, "Sub Description is required.");
        }
    });

    if (!isValid) {
        event.preventDefault(); // Prevent form submission if validation fails
    }
});

// Function to show error messages
function showError(element, message) {
    const errorMessage = document.createElement('div');
    errorMessage.classList.add('validation-error');
    errorMessage.style.color = 'red';
    errorMessage.textContent = message;
    element.parentElement.appendChild(errorMessage);
}


$('#type').on('change', function() {
    const selectedType = $(this).val();
    const container = $('#Pointers-container');

    if (selectedType) {
        $.ajax({
            url: "{{ route('fetch-process-section-by-type') }}",
            type: "GET",
            data: { type: selectedType },
            success: function(response) {
                console.log(response.data);
                if (response && response.data && response.data.length > 0) {
                    const section = response.data[0]; // Assuming a single record
                    if (section) {
                        $('#id').val(section.id || '');
                        $('#title').val(section.title || '');
                        $('#subtitle').val(section.subtitle || '');
                        $('#status').prop('checked', section.status === 'on');
                        CKEDITOR.instances.description.setData(section.description || '');

                        // Handle pointers
                        const pointers = section.pointers ? JSON.parse(section.pointers) : [];
                        container.empty();

                        if (pointers.length > 0) {
                            pointers.forEach(pointer => {
                                const pointerHtml = `
                                    <div class="form-group url-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Sub Title</label>
                                                <input type="text" name="sub_title[]" class="form-control sub-title-input" value="${pointer.sub_title || ''}" placeholder="Enter sub title">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Sub Description</label>
                                                <textarea name="sub_description[]" class="form-control">${pointer.sub_description || ''}</textarea>
                                            </div>
                                            <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                        </div>
                                    </div>
                                `;
                                container.append(pointerHtml);
                            });
                        } else {
                            addEmptyPointer(container);
                        }

                        toggleRemoveButtons();
                    }
                } else {
                    resetForm(); // Reset form if no data is found
                }
            },
            error: function() {
                alert('An error occurred while fetching data.');
                resetForm();
            }
        });
    } else {
        resetForm(); // Reset form when no type is selected
    }
});

// Function to add an empty pointer input
function addEmptyPointer(container) {
    container.empty();
    container.append(`
        <div class="form-group url-group">
            <div class="row">
                <div class="col-md-6">
                    <label>Sub Title</label>
                    <input type="text" name="sub_title[]" class="form-control sub-title-input" placeholder="Enter sub title">
                </div>
                <div class="col-md-6">
                    <label>Sub Description</label>
                    <textarea name="sub_description[]" class="form-control"></textarea>
                </div>
                <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
            </div>
        </div>
    `);
}

// Function to reset form fields
function resetForm() {
    $('#id').val('');
    $('#title').val('');
    $('#subtitle').val('');
    $('#status').prop('checked', false);
    CKEDITOR.instances.description.setData('');
    $('#Pointers-container').empty();
    addEmptyPointer($('#Pointers-container'));
}

</script>


@endsection