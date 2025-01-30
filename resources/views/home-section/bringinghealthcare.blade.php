@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Bringing healthcare Section</h1>
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
                            <h3 class="card-title">{{ empty($healthcare) || !isset($healthcare[0]) ? 'Add' : 'Edit' }} Bringing healthcare Details</h3>
                        </div>
                        <form action="{{ route('save-bringinghealthcare') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ old('id', $healthcare[0]->id ?? '') }}">
                            <div class="card-body">
                                <div class="row">
                                    <!-- Title Field -->
                                    <div class="form-group col-md-6">
                                        <label for="title">Title</label>
                                        <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                        <input type="text" class="form-control" name="title" id="title"
                                            placeholder="Enter title" value="{{ old('title',$healthcare[0]->title ?? '') }}">
                                        @error('title')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <!-- Subtitle Field -->
                                    <div class="form-group col-md-6">
                                        <label for="subtitle">Subtitle</label>
                                        <i class="fas fa-info-circle" title="Provide a brief subtitle that complements the main title of this section."></i> <label for="">(Optional)</label>
                                        <input type="text" class="form-control" name="subtitle" id="subtitle"
                                            placeholder="Enter subtitle" value="{{ old('subtitle',$healthcare[0]->subtitle ?? '') }}">
                                        @error('subtitle')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="button_content">Button 1 Text</label>
                                        <i class="fas fa-info-circle" title="Provide a meaningful label for Button 1."></i> <label for="">(Optional)</label>
                                        <input type="text" class="form-control" name="button_content1" id="button_content" placeholder="Enter Button Text" value="{{ old('button_content',$healthcare[0]->button_content1 ?? '') }}">
                                        @error('button_content')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="button_link">Button 1 Link</label>
                                        <i class="fas fa-info-circle" title="Provide a valid URL for Button 1."></i> <label for="">(Optional)</label>
                                        <input type="text" class="form-control" name="button_link1" id="button_link" placeholder="Enter Button Link" value="{{ old('button_link',$healthcare[0]->button_link1 ?? '') }}">
                                        @error('button_link')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="button_content">Button 2 Text</label>
                                        <i class="fas fa-info-circle" title="Provide a meaningful label for Button 2."></i> <label for="">(Optional)</label>
                                        <input type="text" class="form-control" name="button_content2" id="button_content" placeholder="Enter Button Text" value="{{ old('button_content',$healthcare[0]->button_content2 ?? '') }}">
                                        @error('button_content')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="button_link">Button 2 Link</label>
                                        <i class="fas fa-info-circle" title="Provide a valid URL for Button 2."></i> <label for="">(Optional)</label>
                                        <input type="text" class="form-control" name="button_link2" id="button_link" placeholder="Enter Button Link" value="{{ old('button_link',$healthcare[0]->button_link2 ?? '') }}">
                                        @error('button_link')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                    <img id="blah" 
     src="{{ asset($healthcare[0]->image ?? '') }}" 
     alt="Image Preview" 
     style="width: 130px; display: {{ !empty($healthcare) && isset($healthcare[0]) && $healthcare[0]->image ? 'block' : 'none' }};" />
                                    <input type="file" class="form-control" name="image" id="imgInp" accept="image/*">
                                    @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="card-footer">
                            <input type="checkbox" id="status" name="status" {{ ($healthcare[0]->status ?? '') === 'on' ? 'checked' : '' }}>
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

<script>
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