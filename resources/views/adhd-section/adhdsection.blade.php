@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>ADHD Child/Adult Section</h1>
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
                                            placeholder="Enter first title" value="{{ old('first_title',$adhdSection[0]->first_title ?? '') }}" required>
                                        @error('first_title')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Subtitle Field -->
                                    <div class="form-group col-md-6">
                                        <label for="subtitle">Subtitle</label>
                                        <i class="fas fa-info-circle" title="Provide a brief subtitle that complements the main title of this section."></i> <label class="option-area">(Optional)</label>
                                        <input type="text" class="form-control" name="first_subtitle" id="subtitle"
                                            placeholder="Enter first subtitle" value="{{ old('first_subtitle',$adhdSection[0]->first_subtitle ?? '') }}">
                                        @error('first_subtitle')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="title">Button Text</label>
                                        <i class="fas fa-info-circle" title="The Button Text field allows you to specify the label that will appear on the button."></i> <label class="option-area">(Optional)</label>
                                        <input type="text" class="form-control" name="first_button_content" id="button_content" placeholder="Enter Button Text" value="{{old('first_button_content',$adhdSection[0]->first_button_content ?? '')}}">
                                        @error('first_button_content')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="title">Button Link</label>
                                        <i class="fas fa-info-circle" title="The Button Link field is where you provide the URL the button will navigate to when clicked."></i> <label class="option-area">(Optional)</label>
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
                                    <textarea class="form-control" name="first_description" id="first_description" required>{{ old('first_description', $adhdSection[0]->first_description ?? '') }}</textarea>
                                    @error('first_description')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                    <img id="blah" src="{{asset($adhdSection[0]->first_image ?? '')}}" alt="Image Preview" style="width: 130px; display:{{empty($adhdSection[0]->first_image) ? 'none' : 'block'}}" />
                                    <input type="file" class="form-control" name="first_image" id="imgInp" accept="image/*">
                                    @error('first_image')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                

                            </div>

                            <div class="card-footer">
                            <input type="checkbox" id="status" name="status" {{ ($adhdSection[0]->status ?? '') === 'on' ? 'checked' : '' }}>
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
<script>
    CKEDITOR.replace('first_description');

    // Handle image preview
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

    $(document).ready(function() {
        // Handle change event on the #type dropdown
        $('#type').on('change', function() {
            const selectedType = $(this).val();

            // Clear validation errors when type is changed
            $('.validation-error').remove();

            if (selectedType) {
                $.ajax({
                    url: "{{ route('fetch-adhd-section-by-type') }}", // Update with your route
                    type: "GET",
                    data: { type: selectedType },
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
                            $('#button_content').val(section.first_button_content || '');
                            $('#button_link').val(section.first_button_link || '');
                            CKEDITOR.instances.first_description.setData(section.first_description || '');

                            const imageUrl = section.first_image || '';
                            if (imageUrl) {
                                $('#blah').attr('src', imageUrl).show();
                            } else {
                                $('#blah').attr('src', '#').hide(); // Reset if no image
                            }

                            $('#status').prop('checked', section.status === 'on');
                        } else {
                            // Reset form fields if no data is found
                            resetFormFields();
                        }
                    },
                    error: function() {
                        alert('An error occurred while fetching data.');
                    },
                    complete: function() {
                        $('#loading-spinner').hide(); // Hide loader
                    }
                });
            } else {
                resetFormFields();
            }
        });

        // Function to reset all form fields
        function resetFormFields() {
            $('#id, #title, #subtitle, #button_content, #button_link').val('');
            CKEDITOR.instances.first_description.setData(''); // Reset CKEditor
            $('#blah').attr('src', '#').hide(); // Reset image
            $('#status').prop('checked', false); // Uncheck status
        }
    });
</script>


@endsection