@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>ADHD Benefits Section</h1>
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
                                {{ empty($adhdBenefit) || !isset($adhdBenefit[0]) ? 'Add' : 'Edit' }} ADHD Benefits Details
                            </h3>
                        </div>


                        <form action="{{ route('save-adhd-benefits') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ $adhdBenefit[0]->id ?? '' }}">

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Select Type</label>
                                    <i class="fas fa-info-circle" title="Choose the appropriate type for this section."></i>
                                    <select name="type" class="form-control" id="type">
                                        <option disabled selected>Please Select Type</option>
                                        <option value="Child" {{ isset($adhdBenefit[0]) && $adhdBenefit[0]->type === 'Child' ? 'selected' : '' }}>Child</option>
                                        <option value="Adult" {{ isset($adhdBenefit[0]) && $adhdBenefit[0]->type === 'Adult' ? 'selected' : ''}}>Adult</option>
                                    </select>
                                    @error('type')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <!-- Title Field -->
                                    <div class="form-group col-md-6">
                                        <label for="title">Title</label>
                                        <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                        <input type="text" class="form-control" name="title" id="title"
                                            placeholder="Enter title" value="{{ old('title', $adhdBenefit[0]->title ?? '') }}">
                                        @error('title')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <!-- Subtitle Field -->
                                    <div class="form-group col-md-6">
                                        <label for="subtitle">Subtitle</label>
                                        <i class="fas fa-info-circle" title="Provide a brief subtitle that complements the main title of this section."></i>
                                        <input type="text" class="form-control" name="subtitle" id="subtitle"
                                            placeholder="Enter subtitle" value="{{ old('subtitle', $adhdBenefit[0]->subtitle ?? '') }}">
                                        @error('subtitle')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>


                                <!-- Description Field -->
                                <div class="form-group">
                                    <label for="description_1">Description</label>
                                    <i class="fas fa-info-circle" title="Describe the purpose or details of this section in 2-3 sentences."></i>
                                    <textarea class="form-control" name="description_1" id="description_1">{{ old('description_1', $adhdBenefit[0]->description_1 ?? '') }}</textarea>
                                    @error('description_1')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <hr>

                                @php
                                // Check if the $adhdBenefit[0] exists and contains data before attempting to decode
                                $pointers = isset($adhdBenefit[0]) && !empty($adhdBenefit[0]->pointers)
                                ? json_decode($adhdBenefit[0]->pointers)
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
                                                <input type="text" name="sub_title[]" id="sub_title" class="form-control" value="{{$pointer->sub_title}}" placeholder="Enter sub title">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Sub Description</label>
                                                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                                <input type="text" name="sub_description[]" id="sub_description" class="form-control" value="{{$pointer->sub_description}}" placeholder="Enter sub description">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="image">Image</label>
                                                <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                                <img id="blah" src="{{asset($pointer->sub_image ?? '')}}" alt="Image Preview" style="width: 130px; display:none" />
                                                <input type="file" class="form-control" name="image[]" id="imgInp" accept="image/*">
                                                @error('image')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
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
                                                <input type="text" name="sub_title[]" id="sub_title" class="form-control" value="" placeholder="Enter sub title">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Sub Description</label>
                                                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                                <input type="text" name="sub_description[]" id="sub_description" class="form-control" value="" placeholder="Enter sub description">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="image">Image</label>
                                                <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                                <img id="blah" src="#" alt="Image Preview" style="width: 130px; display:none" />
                                                <input type="file" class="form-control" name="image[]" id="imgInp" accept="image/*">
                                                @error('image')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>

                                        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                    </div>
                                    @endif
                                </div>
                                <!-- Add Pointer Button -->
                                <button type="button" class="btn btn-success" id="add-Pointers">Add Pointer</button>
                            </div>

                            <div class="card-footer">
                            <input type="checkbox" id="status" name="status" {{ ($adhdBenefit[0]->status ?? '') === 'on' ? 'checked' : '' }}>
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
    CKEDITOR.replace('description_1');
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
                                                <label>Sub Title</label>
                                                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                                <input type="text" name="sub_title[]" class="form-control" value="" placeholder="Enter sub title">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Sub Description</label>
                                                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                                <input type="text" name="sub_description[]" class="form-control" value="" placeholder="Enter sub description">
                                            </div>

                                            <div class="form-group col-md-6">
                                        <label for="image">Image</label>
                                        <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                        <img id="blah" src="#" alt="Image Preview" style="width: 130px; display:none" />
                                        <input type="file" class="form-control" name="image[]" id="imgInp" accept="image/*">
                                  
                                    </div>
                                         
                                        </div>

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

     // Handle change event on the #type dropdown
     $('#type').on('change', function() {
    const selectedType = $(this).val();

    if (selectedType) {
        $.ajax({
            url: "{{ route('fetch-adhd-benefits-section-by-type') }}",
            type: "GET",
            data: { type: selectedType },

            success: function(response) {
                const section = response.data[0] || {};
                $('#id').val(section.id || '');
                $('#title').val(section.title || '');
                $('#subtitle').val(section.subtitle || '');
                $('#description_1').val(section.description_1 || '');
                $('#status').prop('checked', section.status === 'on');

                // Clear existing pointers
                $('#Pointers-container').empty();
               const pointers = JSON.parse(section.pointers)
                console.log('sdsad',pointers);

                // Add new pointers
              
                    pointers.forEach(pointer => {
                        const newPointer = `
                            <div class="form-group url-group">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Sub Title</label>
                                        <input type="text" name="sub_title[]" class="form-control" value="${pointer.sub_title || ''}" placeholder="Enter sub title">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Sub Description</label>
                                        <input type="text" name="sub_description[]" class="form-control" value="${pointer.sub_description || ''}" placeholder="Enter sub description">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="image">Image</label>
                                        <img src="${pointer.sub_image}" alt="Image Preview" style="width: 130px; display:none;" />
                                        <input type="file" class="form-control" name="image[]" accept="image/*">
                                    </div>
                                </div>
                                <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                            </div>`;
                        $('#Pointers-container').append(newPointer);
                    });
               
                updateRemoveButtonVisibility(); // Ensure buttons are updated
            },
            error: function() {
                $('#loading-spinner').hide();
                alert('Failed to fetch data. Please try again.');
            }
        });
    }
});

</script>

@endsection