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
                        <form action="{{ isset($banner->id) ? route('banner.update', $banner->id) : route('banner.store') }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="hidden_id" value="{{ $banner->id }}">
                            @csrf
                            @if(isset($banner->id))
                            @method('PUT') <!-- For update requests -->
                            @endif

                            <div class="card-body">
                                @if (empty($banner->id))
                                <div class="form-group">
                                    <label for="title">Page</label>
                                    <i class="fas fa-info-circle" title="Enter a title for Banner Section."></i>
                                    <select class="form-control" style="width: 100%;" name="type" id="page_type">
                                        @foreach ($headerData as $header)
                                        <option value="{{ $header->category }}" {{ $header->category == $banner->type ? 'selected' : '' }}>
                                            {{ $header->category }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @else
                                <label for="title"> Page</label>
                                <input type="text" class="form-control" name="type" id="button_text" placeholder="Enter Button Text" value="{{ old('type', $banner->type) }}" readonly>
                               @if (!empty( $banner->section_type))
                               <label for="title"> Choose Banner</label>
                               <input type="text" class="form-control" name="section_banner" id="button_text" placeholder="Enter Button Text" value="{{ old('section_banner', $banner->section_type) }}" readonly>
                               @endif
                           
                                @endif
                                <div class="form-group type-area">
                                    <label for="title">Choose Type</label>
                                    <i class="fas fa-info-circle" title="Enter a title for Banner Section."></i>
                                    <select class="form-control" style="width: 100%;" name="section_type" id="section_type">
                                        <option selected disabled>Please Select Type</option>
                                        <option value="Child" {{ ( $banner->section_type == 'Child') ? 'selected' : '' }}>Child</option>
                                        <option value="Adult" {{ ( $banner->section_type == 'Adult') ? 'selected' : '' }}>Adult</option>
                                    </select>
                                </div>

                                <div class="form-group home-area">
                                    <label for="title">Choose Banner</label>
                                    <i class="fas fa-info-circle" title="Enter a title for Banner Section."></i>
                                    <select class="form-control" style="width: 100%;" name="section_banner" id="section_type">
                                        <option selected disabled>Please Select Banner</option>
                                        <option value="1st" {{ ( $banner->section_type == '1st') ? 'selected' : '' }}>1st</option>
                                        <option value="2nd" {{ ( $banner->section_type == '2nd') ? 'selected' : '' }}>2nd</option>
                                        <option value="3rd" {{ ( $banner->section_type == '3rd') ? 'selected' : '' }}>3rd</option>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="title">Heading</label><i class="fas fa-info-circle" title="Enter a title for Banner Section ."></i>
                                        <input type="text" class="form-control" name="heading" id="heading" placeholder="Enter heading" value="{{ old('heading', $banner->heading) }}">
                                        @error('heading')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="subtitle">Sub Heading</label>
                                        <input type="text" class="form-control" name="subtitle" id="subtitle" placeholder="Enter sub heading" value="{{ old('subtitle', $banner->subtitle ?? '') }}">
                                        @error('subtitle')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description_1">Description</label><i class="fas fa-info-circle" title="Enter a Description for Banner Section."></i>
                                    <textarea class="form-control" name="description" id="description_1">{{ old('description', $banner->description) }}</textarea>
                                    @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="button_content">Button Text</label><i class="fas fa-info-circle" title="Enter a Button text for Banner Section."></i>
                                        <input type="text" class="form-control" name="button_text" id="button_text" placeholder="Enter Button Text" value="{{ old('button_text', $banner->button_text) }}">
                                        @error('button_text')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="button_link">Button Link</label><i class="fas fa-info-circle" title="Enter a Button link for Banner Section."></i>
                                        <input type="text" class="form-control" name="button_link" id="button_link" placeholder="Enter Button Link" value="{{ old('button_link', $banner->button_link) }}">
                                        @error('button_link')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="image">Background Image</label>
                                    <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                    <img id="blah" src="{{asset($banner->image ?? '')}}" alt="Image Preview" style="width: 130px; display: {{ empty($banner->image) ? 'none' : 'block' }};" />
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

    $(document).ready(function() {
        $('.type-area').hide();
        $('.home-area').hide();
        var getValue = $("#page_type").val();
        if (getValue === "Autism") {
            $('.type-area').show();
        } else {
            $('.type-area').hide();
        }
        if (getValue === "Home") {
            $('.home-area').show();
        } else {
            $('.home-area').hide();

        }

        // Show the type-area if the page type is "Autism"
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
        });

    });
</script>

@endsection