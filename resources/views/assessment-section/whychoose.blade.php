@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Why Choose Cognitive Care Section</h1>
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
                            <h3 class="card-title">{{ empty($assessmentWhyChoose) || !isset($assessmentWhyChoose[0]) ? 'Add' : 'Edit' }} Why Choose Cognitive Care Section Details</h3>
                        </div>
                        <form action="{{ route('save-whychoose-section') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ old('id', $assessmentWhyChoose[0]->id ?? '') }}">
                            <div class="card-body">
                              
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                    <input type="text" class="form-control" name="title" id="title"
                                        placeholder="Enter title" value="{{ old('title',$assessmentWhyChoose[0]->title ?? '') }}" required>
                                    @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <!-- Description Field -->
                                <div class="form-group">
                                    <label for="description_1">Description</label>
                                    <i class="fas fa-info-circle" title="Describe the purpose or details of this section in 2-3 sentences."></i>
                                    <textarea class="form-control" name="description" id="description" required>{{ old('description', $assessmentWhyChoose[0]->description ?? '') }}</textarea>
                                    @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="title">Button Text 1</label>
                                    <i class="fas fa-info-circle" title="The Button Text field allows you to specify the label that will appear on the button."></i>
                                    <input type="text" class="form-control" name="first_button_content" id="button_content" placeholder="Enter Button Text" value="{{old('first_button_content',$assessmentWhyChoose[0]->first_button_content ?? '')}}">
                                    @error('first_button_content')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="title">Button Link 1</label>
                                    <i class="fas fa-info-circle" title="The Button Link field is where you provide the URL the button will navigate to when clicked."></i>
                                    <input type="text" class="form-control" name="first_button_link" id="button_link" placeholder="Enter Button Link" value="{{old('first_button_link',$assessmentWhyChoose[0]->first_button_link ?? '')}}">
                                    @error('first_button_link')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="title">Button Text 2</label>
                                    <i class="fas fa-info-circle" title="The Button Text field allows you to specify the label that will appear on the button."></i>
                                    <input type="text" class="form-control" name="second_button_content" id="button_content" placeholder="Enter Button Text" value="{{old('second_button_content',$assessmentWhyChoose[0]->second_button_content ?? '')}}">
                                    @error('second_button_content')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="title">Button Link 2</label>
                                    <i class="fas fa-info-circle" title="The Button Link field is where you provide the URL the button will navigate to when clicked."></i>
                                    <input type="text" class="form-control" name="second_button_link" id="button_link" placeholder="Enter Button Link" value="{{old('second_button_link',$assessmentWhyChoose[0]->second_button_link ?? '')}}">
                                    @error('second_button_link')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>


</div>
                                

                                @php
                                // Check if the $assessmentWhyChoose exists and contains data before attempting to decode
                                $pointers = isset($assessmentWhyChoose[0]) && !empty($assessmentWhyChoose[0]->pointers)
                                ? json_decode($assessmentWhyChoose[0]->pointers)
                                : [];
                                @endphp
                                  
                                <hr>
                                <!-- Pointers Section -->
                                <label for="">Card Details</label>
                                <div id="Pointers-container">

                                    @if(!empty($pointers) && is_array($pointers))
                                    <!-- Loop through each pointer and display -->
                                    @foreach($pointers as $index => $pointer)
                                    <div class="form-group url-group">
                               
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label> Title</label>
                                                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                                <input type="text" name="sub_title[]" class="form-control" value="{{$pointer->sub_title}}" placeholder="Enter title" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label> Description</label>
                                                <i class="fas fa-info-circle" title="Provide a meaningful description for this section."></i>
                                                <input type="text" name="sub_description[]" class="form-control" value="{{$pointer->sub_description}}" placeholder="Enter description" required>
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
                                                <label> Title</label>
                                                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                                <input type="text" name="sub_title[]" class="form-control" value="" placeholder="Enter title" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label> Description</label>
                                                <i class="fas fa-info-circle" title="Provide a meaningful description for this section."></i>
                                                <input type="text" name="sub_description[]" class="form-control" value="" placeholder="Enter description" required>
                                            </div>
                                         
                                        </div>

                                        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                    </div>
                                    @endif
                                </div>
                                <!-- Add Pointer Button -->
                                <button type="button" class="btn btn-success" id="add-Pointers">Add Card</button>

                                <div class="form-group mt-2">
                                    <label for="image">Image</label>
                                    <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                    <img id="blah" src="{{asset($assessmentWhyChoose[0]->image ?? '')}}" alt="Image Preview" style="width: 130px; display:{{empty($assessmentWhyChoose[0]->image) ? 'none' : 'block'}}" />
                                    <input type="file" class="form-control" name="image" id="imgInp" accept="image/*">
                                    @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="card-footer">
                            <input type="checkbox" id="status" name="status" {{ ($assessmentWhyChoose[0]->status ?? '') === 'on' ? 'checked' : '' }}>
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
                                                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                                <input type="text" name="sub_title[]" class="form-control" value="" placeholder="Enter title" required>
                                                <div class="text-danger sub-title-error" style="display: none;">This field is required.</div>
                                                </div>
                                            <div class="form-group col-md-6">
                                                <label> Description</label>
                                                <i class="fas fa-info-circle" title="Provide a meaningful description for this section."></i>
                                                <input type="text" name="sub_description[]" class="form-control" value="" placeholder="Enter description" required>
                                                <div class="text-danger sub-description-error" style="display: none;">This field is required.</div>
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

       // Validate the form before submission
       function validateForm() {
        const subTitles = document.querySelectorAll('input[name="sub_title[]"]');
        const subDescriptions = document.querySelectorAll('input[name="sub_description[]"]');
        let isValid = true;

        // Validate Sub Title fields
        subTitles.forEach(input => {
            const errorDiv = input.closest('.form-group').querySelector('.sub-title-error');
            if (errorDiv) {  // Ensure the error div exists before accessing it
                if (!input.value.trim()) {
                    isValid = false;
                    errorDiv.style.display = 'block'; // Show error message
                } else {
                    errorDiv.style.display = 'none'; // Hide error message
                }
            }
        });

        // Validate Sub Description fields
        subDescriptions.forEach(input => {
            const errorDiv = input.closest('.form-group').querySelector('.sub-description-error');
            if (errorDiv) {  // Ensure the error div exists before accessing it
                if (!input.value.trim()) {
                    isValid = false;
                    errorDiv.style.display = 'block'; // Show error message
                } else {
                    errorDiv.style.display = 'none'; // Hide error message
                }
            }
        });

        return isValid;
    }

    // Handle form submission
    document.getElementById('form-submit-button').addEventListener('click', function(event) {
        const isValid = validateForm();
        if (!isValid) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
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