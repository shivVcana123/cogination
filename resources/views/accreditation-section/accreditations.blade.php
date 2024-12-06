@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Accreditation & Certifications Section</h1>
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
                            <h3 class="card-title">{{ empty($accreditationsSection) || !isset($accreditationsSection[0]) ? 'Add' : 'Edit' }} Accreditations Details</h3>
                        </div>
                        <form action="{{ route('save-accreditations-section') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ old('id', $accreditationsSection[0]->id ?? '') }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                    <input type="text" class="form-control" name="title" id="title"
                                        placeholder="Enter title" value="{{ old('title',$accreditationsSection[0]->title ?? '') }}">
                                    @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                 <!-- Subtitle Field -->
                                 <div class="form-group">
                                    <label for="subtitle">Subtitle</label>
                                    <i class="fas fa-info-circle" title="Provide a brief subtitle that complements the main title of this section."></i>
                                    <input type="text" class="form-control" name="subtitle" id="subtitle"
                                        placeholder="Enter first subtitle" value="{{ old('subtitle',$accreditationsSection[0]->subtitle ?? '') }}">
                                    @error('subtitle')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <!-- Description Field -->
                                <div class="form-group">
                                    <label for="description_1">Description</label>
                                    <i class="fas fa-info-circle" title="Describe the purpose or details of this section in 2-3 sentences."></i>
                                    <textarea class="form-control" name="description" id="description">{{ old('description', $accreditationsSection[0]->description ?? '') }}</textarea>
                                    @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                @php
                                // Check if the $accreditationsSection exists and contains data before attempting to decode
                                $pointers = isset($accreditationsSection[0]) && !empty($accreditationsSection[0]->pointers)
                                ? json_decode($accreditationsSection[0]->pointers)
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
                                        <input type="text" name="sub_title[]" class="form-control" value="{{$pointer->sub_title}}" placeholder="Enter sub title">

                                        <label>Sub Description</label>
                                        <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                        <input type="text" name="sub_description[]" class="form-control" value="{{$pointer->sub_description}}" placeholder="Enter sub description">

                                        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                    </div>
                                    @endforeach
                                    @else

                                    <!-- Default empty field when no pointers exist -->
                                    <div class="form-group url-group">
                                        <label>Sub Title</label>
                                        <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                        <input type="text" name="sub_title[]" class="form-control" value="" placeholder="Enter sub title">

                                        <label>Sub Description</label>
                                        <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                        <input type="text" name="sub_description[]" class="form-control" value="" placeholder="Enter sub description">

                                        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                    </div>
                                    @endif
                                </div>
                                <!-- Add Pointer Button -->
                                <button type="button" class="btn btn-success" id="add-Pointers">Add Pointer</button>

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
        <input type="text" name="sub_title[]" class="form-control" value="" placeholder="Enter sub title">

        <label>Sub Description</label>
        <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
        <input type="text" name="sub_description[]" class="form-control" value="" placeholder="Enter sub description">

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
</script>

@endsection