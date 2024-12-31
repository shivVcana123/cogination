@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Autism Book Section</h1>
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
                            <h3 class="card-title">{{ empty($autismBook) ? 'Add' : 'Edit' }} Book Section</h3>
                        </div>
                        <form action="{{ route('save-book-section') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ old('id', $autismBook[0]->id ?? '') }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="type">Select Type</label>
                                    <i class="fas fa-info-circle" title="Choose the appropriate type for this section."></i>
                                    <select name="type" id="type" class="form-control">
                                        <option value="" disabled selected>Please Select Type</option>
                                        <option value="Child" {{ old('type', $autismBook[0]->type ?? '') === 'Child' ? 'selected' : '' }}>Child</option>
                                        <option value="Adult" {{ old('type', $autismBook[0]->type ?? '') === 'Adult' ? 'selected' : '' }}>Adult</option>
                                    </select>
                                </div>
                                <div class="row">

                                    <div class="form-group col-md-6">
                                        <label for="title">Title</label>
                                        <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>

                                        <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" value="{{ old('title', $autismBook[0]->title ?? '') }}">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="subtitle">Subtitle</label>
                                        <i class="fas fa-info-circle" title="Provide a brief subtitle that complements the main title of this section."></i>

                                        <input type="text" class="form-control" name="subtitle" id="subtitle" placeholder="Enter subtitle" value="{{ old('subtitle', $autismBook[0]->subtitle ?? '') }}">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="title">Button Text</label>
                                        <i class="fas fa-info-circle" title="The Button Text field allows you to specify the label that will appear on the button."></i>

                                        <input type="text" class="form-control" name="button_content" id="button_content" placeholder="Enter Button Text" value="{{old('button_content',$autismBook[0]->button_content ?? '')}}">
                                        @error('button_content')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="title">Button Link</label>
                                        <i class="fas fa-info-circle" title="The Button Link field is where you provide the URL the button will navigate to when clicked."></i>

                                        <input type="text" class="form-control" name="button_link" id="button_link" placeholder="Enter Button Link" value="{{old('button_link',$autismBook[0]->button_link ?? '')}}">
                                        @error('button_link')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <i class="fas fa-info-circle" title="Describe the purpose or details of this section in 2-3 sentences."></i>

                                    <textarea name="description" id="description" class="form-control">{{ old('description', $autismBook[0]->description ?? '') }}</textarea>
                                </div>


                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                    <img id="img" src="{{asset($autismBook[0]->image ?? '')}}" alt="Image Preview" style="width: 130px; display:none" />
                                    <input type="file" class="form-control" name="image" id="image" accept="image/*">
                                    @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
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
    CKEDITOR.replace('description');
    $('#type').on('change', function() {
        const selectedType = $(this).val();
        if (selectedType) {
            $.ajax({
                url: "{{ route('fetch-book-section-by-type') }}",
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
                            $('#button_content').val(section.button_content || '');
                            $('#button_link').val(section.button_link || '');
                        }
                    } else {
                        // Clear fields if no data is found
                        $('#id').val('');
                        $('#title').val('');
                        $('#subtitle').val('');
                        $('#description').val('');
                        $('#button_content').val('');
                        $('#button_link').val('');
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