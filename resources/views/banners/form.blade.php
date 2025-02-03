@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Banner Section</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('banner.index')}}">Banner</a></li>
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
                        <div class="card-header" style="background-color:#0377ce">
                            <h3 class="card-title">Add Banner Details</h3>
                        </div>
                        <form action="{{ isset($banner->id) ? route('banner.update', $banner->id) : route('banner.store') }}" method="POST" enctype="multipart/form-data" id="form-baaner-id">
                            <input type="hidden" name="hidden_id" value="{{ $banner->id }}">
                            @csrf
                            @if(isset($banner->id))
                            @method('PUT') <!-- For update requests -->
                            @endif

                            <div class="card-body">
                                @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                @if (empty($banner->id))
                                <div class="form-group">
                                    <label for="title">Page</label>
                                    <i class="fas fa-info-circle" title="Enter a title for Banner Section."></i>
                                    <select class="form-control" style="width: 100%;" name="type" id="page_type">
                                        @foreach ($headerData as $header)
                                        <option value="{{ $header->category }}" {{ old('type', $banner->type) == $header->category ? 'selected' : '' }}>
                                            {{ $header->category }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @else
                                <label for="title"> Page</label>
                                <input type="text" class="form-control" name="type" id="button_text" placeholder="Enter Button Text" value="{{ old('type', $banner->type) }}" readonly>
                                @endif

                                <div class="form-group type-area">
                                    <label for="title">Choose Type</label>
                                    <i class="fas fa-info-circle" title="Enter a title for Banner Section."></i>
                                    <select class="form-control" style="width: 100%;" name="section_type" id="section_type">
                                        <option selected disabled>Please Select Type</option>
                                        <option value="Child" {{ old('section_type', $banner->section_type) == 'Child' ? 'selected' : '' }}>Child</option>
                                        <option value="Adult" {{ old('section_type', $banner->section_type) == 'Adult' ? 'selected' : '' }}>Adult</option>
                                    </select>
                                    @error('section_type')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6 mt-3">
                                        <label for="title">Heading</label><i class="fas fa-info-circle" title="Enter a title for Banner Section ."></i>
                                        <input type="text" class="form-control" name="heading" id="heading" placeholder="Enter heading" value="{{ old('heading', $banner->heading) }}">
                                        @error('heading')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6 mt-3">
                                        <label for="subtitle">Subtitle</label>
                                        <i class="fas fa-info-circle" title="Enter a subtitle for Banner Section ."></i>
                                        <label>(Optional)</label>
                                        <input type="text" class="form-control " name="subtitle" id="subtitle" placeholder="Enter sub heading" value="{{ old('subtitle', $banner->subtitle ?? '') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description_1">Description</label><i class="fas fa-info-circle" title="Enter a Description for Banner Section."></i>
                                    <textarea class="form-control" name="description" id="description_1">{{ old('description', $banner->description) }}</textarea>
                                    @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="button_content">Button Text</label><i class="fas fa-info-circle" title="Enter a Button text for Banner Section."></i> <label>(Optional)</label>
                                        <input type="text" class="form-control" name="button_text" id="button_text" placeholder="Enter Button Text" value="{{ old('button_text', $banner->button_text) }}">
                                        @error('button_text')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="button_link">Button Link</label><i class="fas fa-info-circle" title="Enter a Button link for Banner Section."></i> <label>(Optional)</label>
                                        <input type="text" class="form-control" name="button_link" id="button_link" placeholder="Enter Button Link" value="{{ old('button_link', $banner->button_link) }}">
                                    </div>
                                    @error('button_link')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="image">Background Image</label>
                                    <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                    <img id="blah" src="{{ old('image', asset($banner->image ?? '')) }}" alt="Image Preview" style="width: 130px; display: {{ empty($banner->image) && old('image') ? 'block' : 'none' }};" />
                                    <input type="file" class="form-control" name="image" id="imgInp" accept="image/*">
                                    @error('image')
                                    <span class="text-danger">{{ $message }}</span>
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

@endsection
@section('java_script')
<script>
    CKEDITOR.replace('description_1');

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

    function resetFields() {
        $('#form-baaner-id')[0].reset();
        $('#section_banner').prop('selectedIndex', 0); // Set to the first (disabled) option
        $('#section_type').prop('selectedIndex', 0);

    }

    $(document).ready(function() {
        const pageType = $("#page_type").val();

        // Show or hide areas based on initial value or old input
        const initializeVisibility = () => {
            if (pageType === "Autism" || pageType === "ADHD" || pageType === "{{ old('type') }}") {
                $('.type-area').show();
            } else {
                $('.type-area').hide();
            }

            if (pageType === "Home" || pageType === "{{ old('type') }}") {
                $('.home-area').show();
            } else {
                $('.home-area').hide();
            }
        };

        // Initialize visibility on page load
        initializeVisibility();

        // Handle changes to the page type dropdown
        $("#page_type").change(function() {
            if (this.value === "Autism" || this.value === "ADHD") {
                $('.type-area').show();
            } else {
                $('.type-area').hide();
            }

            if (this.value === "Home") {
                $('.home-area').show();
            } else {
                $('.home-area').hide();
            }
            // alert(this.value);
            if (this.value !== "Home") {
                //   resetFields();
            } else {
                resetFields();
            }

            // $('#section_type').val('');
            // Reset the form values
            // $('#form-baaner-id')[0].reset(); // Replace 'yourFormId' with the actual form ID

            // Reset CKEditor content
            CKEDITOR.instances.description_1.setData(''); // Reset CKEditor content

            // Reset the image preview
            blah.style.display = "none"; // Hide the image preview
            blah.src = "#"; // Reset the image src
        });
    });
</script>



@endsection