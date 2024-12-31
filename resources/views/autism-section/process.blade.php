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
                                </div>

                                <div class="row">

                                    <div class="form-group col-md-6">
                                        <label for="title">Title</label>
                                        <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>

                                        <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" value="{{ old('title', $autismProcess[0]->title ?? '') }}">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="subtitle">Subtitle</label>
                                        <i class="fas fa-info-circle" title="Provide a brief subtitle that complements the main title of this section."></i>

                                        <input type="text" class="form-control" name="subtitle" id="subtitle" placeholder="Enter subtitle" value="{{ old('subtitle', $autismProcess[0]->subtitle ?? '') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <i class="fas fa-info-circle" title="Describe the purpose or details of this section in 2-3 sentences."></i>

                                    <textarea name="description" id="description" class="form-control">{{ old('description', $autismProcess[0]->description ?? '') }}</textarea>
                                </div>

                                <!-- Pointers Section -->
                                <label for="">Add Extra Pointers</label>
                                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>

                                <div id="Pointers-container">
                                    @php
                                    $pointers = json_decode($autismProcess[0]->pointers ?? '[]');
                                    @endphp
                                    @if(!empty($pointers) && is_array($pointers))
                                    @foreach ($pointers as $index => $pointer)
                                    <div class="form-group url-group">
                                        <label>Sub Title</label>
                                        <input type="text" name="sub_title[]" class="form-control" value="{{ $pointer->sub_title }}" placeholder="Enter sub title">
                                        <label>Sub Description</label>
                                        <textarea name="sub_description[]" class="form-control">{{ $pointer->sub_description }}</textarea>
                                        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="form-group url-group">
                                        <label>Sub Title</label>
                                        <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                        <input type="text" name="sub_title[]" class="form-control" value="" placeholder="Enter sub title">

                                        <label>Sub Description</label>
                                        <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>

                                        <textarea name="sub_description[]" class="form-control"></textarea>

                                        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                    </div>
                                    @endif
                                </div>
                                <button type="button" id="add-Pointers" class="btn btn-success">Add Pointer</button>

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
@endsection
@section('java_script')
<script>
    CKEDITOR.replace('description');
    document.getElementById('add-Pointers').addEventListener('click', function() {
        const container = document.getElementById('Pointers-container');
        const div = document.createElement('div');
        div.classList.add('form-group', 'url-group');
        div.innerHTML = `
            <label>Sub Title</label>
                                                    <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>

            <input type="text" name="sub_title[]" class="form-control" placeholder="Enter sub title">
            <label>Sub Description</label>
                                                    <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>

            <textarea name="sub_description[]" class="form-control"></textarea>
            <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
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

    // Function to toggle visibility of Remove buttons
    function toggleRemoveButtons() {
        const pointers = document.querySelectorAll('.url-group');
        pointers.forEach((pointer) => {
            const removeButton = pointer.querySelector('.remove-Pointers');
            removeButton.style.display = pointers.length > 1 ? 'inline-block' : 'none';
        });
    }

    // Initial check on page load
    toggleRemoveButtons();

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
                        const section = response.data[0]; // Assuming a single record
                        if (section) {
                            $('#id').val(section.id || '');
                            $('#title').val(section.title || '');
                            $('#subtitle').val(section.subtitle || '');
                            $('#description').val(section.description || '');

                            // Update pointers dynamically
                            const pointers = section.pointers ? JSON.parse(section.pointers) : [];
                            const container = $('#Pointers-container');
                            container.empty(); // Clear existing pointers

                            if (pointers.length > 0) {
                                pointers.forEach(pointer => {
                                    const pointerHtml = `
                                        <div class="form-group url-group">
                                            <label>Sub Title</label>
                                             <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                            <input type="text" name="sub_title[]" class="form-control" value="${pointer.sub_title || ''}" placeholder="Enter sub title">
                                            <label>Sub Description</label>
                                                                                    <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>

                                            <textarea name="sub_description[]" class="form-control">${pointer.sub_description || ''}</textarea>
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
                                         <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                        <input type="text" name="sub_title[]" class="form-control" placeholder="Enter sub title">
                                        <label>Sub Description</label>
                                                                                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>

                                        <textarea name="sub_description[]" class="form-control"></textarea>
                                        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                    </div>
                                `);
                            }

                            toggleRemoveButtons();
                        }
                    } else {
                        // Clear fields if no data is found
                        $('#id').val('');
                        $('#title').val('');
                        $('#subtitle').val('');
                        $('#description').val('');

                        // Clear pointers and add a single empty group
                        const container = $('#Pointers-container');
                        container.empty();
                        container.append(`
                            <div class="form-group url-group">
                                <label>Sub Title</label>
                                 <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                <input type="text" name="sub_title[]" class="form-control" placeholder="Enter sub title">
                                <label>Sub Description</label>
                                                                        <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>

                                <textarea name="sub_description[]" class="form-control"></textarea>
                                <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                            </div>
                        `);

                        toggleRemoveButtons();
                    }
                },
                error: function() {
                    alert('An error occurred while fetching data.');
                }
            });
        }
    });
</script>



@endsection