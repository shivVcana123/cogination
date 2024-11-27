@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Why Choose Us Section</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Add Form</li>
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
                            <h3 class="card-title">{{ isset($chooseusData) ? 'Edit' : 'Add' }} Why Choose Us</h3>
                        </div>
                        <form action="{{ route('save-whychooseus') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ old('id', $chooseusData[0]->id ?? '') }}">
    
    <div class="card-body">
        <!-- Title Field -->
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" id="title" 
                   placeholder="Enter title" value="{{ old('title', $chooseusData[0]->title ?? '') }}">
            @error('title')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Subtitle Field -->
        <div class="form-group">
            <label for="subtitle">Subtitle</label>
            <input type="text" class="form-control" name="subtitle" id="subtitle" 
                   placeholder="Enter subtitle" value="{{ old('subtitle', $chooseusData[0]->subtitle ?? '') }}">
            @error('subtitle')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Description Field -->
        <div class="form-group">
            <label for="description_1">Description</label>
            <textarea class="form-control" name="description_1" id="description_1">{{ old('description_1', $chooseusData[0]->description_1 ?? '') }}</textarea>
            @error('description_1')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Pointers Section -->
        <div id="Pointers-container">
            @php
                $pointers = old('sub_title') 
                    ? array_map(null, old('sub_title', []), old('sub_description', [])) 
                    : (isset($chooseusData[0]->pointers) ? json_decode($chooseusData[0]->pointers, true) : []);
            @endphp

            @if (!empty($pointers))
                @foreach ($pointers as $index => $pointer)
                <div class="form-group url-group">
                    <!-- Sub Title -->
                    <label>Sub Title</label>
                    <input type="text" name="sub_title[]" class="form-control" 
                           value="{{ old('sub_title.' . $index, $pointer['sub_title'] ?? '') }}" 
                           placeholder="Enter sub title">
                    @error("sub_title.{$index}")
                    <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <!-- Sub Description -->
                    <label>Sub Description</label>
                    <input type="text" name="sub_description[]" class="form-control" 
                           value="{{ old('sub_description.' . $index, $pointer['sub_description'] ?? '') }}" 
                           placeholder="Enter sub description">
                    @error("sub_description.{$index}")
                    <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <!-- Remove Button -->
                    <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                </div>
                @endforeach
            @else
                <!-- Default empty field when no pointers exist -->
                <div class="form-group url-group">
                    <label>Sub Title</label>
                    <input type="text" name="sub_title[]" class="form-control" 
                           value="" placeholder="Enter sub title">
                    <label>Sub Description</label>
                    <input type="text" name="sub_description[]" class="form-control" 
                           value="" placeholder="Enter sub description">
                    <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                </div>
            @endif
        </div>

        <!-- Add Pointer Button -->
        <button type="button" class="btn btn-success" id="add-Pointers">Add Pointer</button>



                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <img id="blah" src="{{asset($chooseusData[0]->image)}}" alt="Image Preview" style="width: 130px; display:none" />
                                    <input type="file" class="form-control" name="image" id="imgInp" accept="image/*">
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

<script>
    function updateRemoveButtonVisibility() {
        const urlGroups = document.querySelectorAll('.url-group');
        urlGroups.forEach((group) => {
            const removeButton = group.querySelector('.remove-Pointers');
            if (urlGroups.length > 1) {
                removeButton.style.display = 'inline-block';
            } else {
                removeButton.style.display = 'none';
            }
        });
    }

    document.getElementById('add-Pointers').addEventListener('click', function() {
        const container = document.getElementById('Pointers-container');
        const newInputGroup = document.createElement('div');
        newInputGroup.classList.add('form-group', 'url-group');
        newInputGroup.innerHTML = `
        <label>Sub Title</label>
        <div class="input-group mb-2">
            <input type="text" name="sub_title[]" class="form-control" placeholder="Enter sub title">
        </div>
        <label>Sub Description</label>
        <div class="input-group mb-2">
            <input type="text" name="sub_description[]" class="form-control" placeholder="Enter sub description">
        </div>
        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
    `;
        container.appendChild(newInputGroup);
        updateRemoveButtonVisibility(); // Ensure the visibility of "Remove" buttons is updated
    });

    document.getElementById('Pointers-container').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-Pointers')) {
            event.target.closest('.url-group').remove();
            updateRemoveButtonVisibility(); // Ensure the visibility of "Remove" buttons is updated
        }
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