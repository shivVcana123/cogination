@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Our Diagnostic Services Section</h1>
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
                                {{ empty($ourDiagnostic) || !isset($ourDiagnostic[0]) ? 'Add' : 'Edit' }} Our Diagnostic Services Details
                            </h3>
                        </div>


                        <form action="{{ route('save-our-diagnostic-services') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ old('id', $ourDiagnostic[0]->id ?? '') }}">

                            <div class="card-body">
                                <!-- Title Field -->
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                    <input type="text" class="form-control" name="title" id="title"
                                        placeholder="Enter title" value="{{ old('title', $ourDiagnostic[0]->title ?? '') }}">
                                    @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description Field -->
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <i class="fas fa-info-circle" title="Describe the purpose or details of this section in 2-3 sentences."></i>
                                    <textarea class="form-control" name="description" id="description">{{ old('description', $ourDiagnostic[0]->description ?? '') }}</textarea>
                                    @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <hr>

                                @php
                                // Check if the $ourDiagnostic exists and contains data before attempting to decode
                                $pointers = isset($ourDiagnostic[0]) && !empty($ourDiagnostic[0]->pointers)
                                ? json_decode($ourDiagnostic[0]->pointers)
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
                                                <input type="text" name="sub_title[]" class="form-control" value="{{$pointer->sub_title}}" placeholder="Enter sub title">
                                                @error('button_link_2')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>


                                            <div class="form-group col-md-6">
                                                <label>Sub Description</label>
                                                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                                <input type="text" name="sub_description[]" class="form-control" value="{{$pointer->sub_description}}" placeholder="Enter sub description">
                                                @error('button_link_2')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="title">Button 1 Text</label>
                                                <i class="fas fa-info-circle" title="The Button Text field allows you to specify the label that will appear on the button."></i>
                                                <input type="text" class="form-control" name="button_content_1[]" id="button_content_1" placeholder="Enter Button Text" value="{{old('button_content_1',$pointer->button_content_1 ?? '')}}">
                                                @error('button_content_1')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="title">Button 1 Link</label>
                                                <i class="fas fa-info-circle" title="The Button Link field is where you provide the URL the button will navigate to when clicked."></i>
                                                <input type="text" class="form-control" name="button_link_1[]" id="button_link_1" placeholder="Enter Button Link" value="{{old('button_link_1[]',$pointer->button_link_1 ?? '')}}">
                                                @error('button_link_1')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="title">Button 2 Text</label>
                                                <i class="fas fa-info-circle" title="The Button Text field allows you to specify the label that will appear on the button."></i>
                                                <input type="text" class="form-control" name="button_content_2[]" id="button_content_2" placeholder="Enter Button Text" value="{{old('button_content_2[]',$pointer->button_content_2 ?? '')}}">
                                                @error('button_content_2')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="title">Button 2 Link</label>
                                                <i class="fas fa-info-circle" title="The Button Link field is where you provide the URL the button will navigate to when clicked."></i>
                                                <input type="text" class="form-control" name="button_link_2[]" id="button_link_2" placeholder="Enter Button Link" value="{{old('button_link_2[]',$pointer->button_link_2 ?? '')}}">
                                                @error('button_link_2')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>Image</label>
                                                <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                                <img id="blah" src="{{asset($pointer->sub_image ?? '')}}" alt="Image Preview" style="width: 130px; display:none" />
                                                <input type="file" class="form-control" name="image[]" accept="image/*">
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
                                                <input type="text" name="sub_title[]" class="form-control" value="" placeholder="Enter sub title">
                                                @error('button_link_2')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>


                                            <div class="form-group col-md-6">
                                                <label>Sub Description</label>
                                                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                                <input type="text" name="sub_description[]" class="form-control" value="" placeholder="Enter sub description">
                                                @error('button_link_2')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="title">Button 1 Text</label>
                                                <i class="fas fa-info-circle" title="The Button Text field allows you to specify the label that will appear on the button."></i>
                                                <input type="text" class="form-control" name="button_content_1[]" id="button_content_1" placeholder="Enter Button Text" value="">
                                                @error('button_content_1')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="title">Button 1 Link</label>
                                                <i class="fas fa-info-circle" title="The Button Link field is where you provide the URL the button will navigate to when clicked."></i>
                                                <input type="text" class="form-control" name="button_link_1[]" id="button_link_1" placeholder="Enter Button Link" value="">
                                                @error('button_link_1')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="title">Button 2 Text</label>
                                                <i class="fas fa-info-circle" title="The Button Text field allows you to specify the label that will appear on the button."></i>
                                                <input type="text" class="form-control" name="button_content_2[]" id="button_content_2" placeholder="Enter Button Text" value="">
                                                @error('button_content_2')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="title">Button 2 Link</label>
                                                <i class="fas fa-info-circle" title="The Button Link field is where you provide the URL the button will navigate to when clicked."></i>
                                                <input type="text" class="form-control" name="button_link_2[]" id="button_link_2" placeholder="Enter Button Link" value="">
                                                @error('button_link_2')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>Image</label>
                                                <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                                <img id="blah" src="#" alt="Image Preview" style="width: 130px; display:none" />
                                                <input type="file" class="form-control" name="image[]" accept="image/*">
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
                                                <label for="title">Button 1 Text</label>
                                                <i class="fas fa-info-circle" title="The Button Text field allows you to specify the label that will appear on the button."></i>
                                                <input type="text" class="form-control" name="button_content_1[]" id="button_content_1" placeholder="Enter Button Text" value="">
                                          
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="title">Button 1 Link</label>
                                                <i class="fas fa-info-circle" title="The Button Link field is where you provide the URL the button will navigate to when clicked."></i>
                                                <input type="text" class="form-control" name="button_link_1[]" id="button_link_1" placeholder="Enter Button Link" value="">
                                            
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="title">Button 2 Text</label>
                                                <i class="fas fa-info-circle" title="The Button Text field allows you to specify the label that will appear on the button."></i>
                                                <input type="text" class="form-control" name="button_content_2[]" id="button_content_2" placeholder="Enter Button Text" value="">
                                         
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="title">Button 2 Link</label>
                                                <i class="fas fa-info-circle" title="The Button Link field is where you provide the URL the button will navigate to when clicked."></i>
                                                <input type="text" class="form-control" name="button_link_2[]" id="button_link_2" placeholder="Enter Button Link" value="">
                                        
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>Image</label>
                                                <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                                <img id="blah" src="#" alt="Image Preview" style="width: 130px; display:none" />
                                                <input type="file" class="form-control" name="image[]" accept="image/*">
                                         
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
</script>

@endsection