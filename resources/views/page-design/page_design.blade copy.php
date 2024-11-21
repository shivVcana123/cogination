@extends('layouts.guest')
@section('content')
<!-- Include CKEditor CSS -->
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.css">

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Page Design</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">News</a></li>
                        <li class="breadcrumb-item active">style Form</li>
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
                            <h3 class="card-title">Add News</h3>
                        </div>
                        <!-- Form Start -->
                        <form action="{{ route('page-save') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <!-- <input type="text" name="id" id="id" value="{{$pageData[0]->id}}"> -->
                                <div class="form-group">
                                    <label for="title_style">Title</label>
                                    <textarea class="form-control ckeditor" name="title_style" id="title_style">{{ old('title_style',$pageData[0]->title_style) }}</textarea>
                                    @error('title_style')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="subtitle_style">Subtitle</label>
                                    <textarea class="form-control ckeditor" name="subtitle_style" id="subtitle_style">{{ old('subtitle_style',$pageData[0]->subtitle_style) }}</textarea>
                                    @error('subtitle_style')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description_1">Description 1</label>
                                    <textarea class="form-control ckeditor" name="description_style" id="description_style">{{ old('description_style',$pageData[0]->description_style) }}</textarea>
                                    @error('description_style')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="button_content_style">Button Text</label>
                                    <textarea class="form-control ckeditor" name="button_content_style" id="button_content_style">{{ old('button_content_style',$pageData[0]->button_content_style) }}</textarea>
                                    @error('button_content_style')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="header_color">Header Color</label>
                                    <input type="color" class="form-control" name="header_color" id="header_color" value="{{ old('header_color',$pageData[0]->header_color) }}">
                                    @error('header_color')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="footer_color">Footer Color</label>
                                    <input type="color" class="form-control" name="footer_color" id="footer_color" value="{{ old('footer_color',$pageData[0]->footer_color) }}">
                                    @error('footer_color')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                <label for="image">Header Image</label>
                                <img id="blah"  src="{{ asset($pageData[0]->header_image) }}" alt="Image Preview" style="width: 130px; display:none" />
                                <input type="file" class="form-control" name="header_image" id="header_image" accept="image/*">
                                @error('header_image')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="footer_image">Footer Image</label>
                                <img id="bg_image"  src="{{ asset($pageData[0]->footer_image) }}" alt="Background Image Preview" style="width: 130px; display:none" />
                                <input type="file" class="form-control" name="footer_image" id="footer_image" accept="image/*">
                                @error('footer_image')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            </div>

                            <!-- Submit Button -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                        <!-- Form End -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Include CKEditor JS -->
<script src="https://cdn.ckeditor.com/4.25.0/standard/ckeditor.js"></script>

<script>
  

    // Image Preview for Image Input
    header_image.onchange = evt => {
        const [file] = header_image.files;
        if (file && file.type.startsWith('image/')) {
            blah.src = URL.createObjectURL(file);
            blah.style.display = "block"; // Show the preview
        } else {
            blah.style.display = "none"; // Hide the preview
            blah.src = "#"; // Reset the src
        }
    };

    // Image Preview for Background Image Input
    footer_image.onchange = evt => {
        const [file] = footer_image.files;
        if (file && file.type.startsWith('image/')) {
            bg_image.src = URL.createObjectURL(file);
            bg_image.style.display = "block"; // Show the preview
        } else {
            bg_image.style.display = "none"; // Hide the preview
            bg_image.src = "#"; // Reset the src
        }
    };
</script>

<script type="importmap">
    {
        "imports": {
            "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.js",
            "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.3.1/"
        }
    }
</script>

<script type="module">
    import {
        ClassicEditor,
        Essentials,
        Paragraph,
        Bold,
        Italic,
        Underline,
        Font
    } from 'ckeditor5';

    // Select all elements with the class 'ckeditor'
    const editors = document.querySelectorAll('.ckeditor');

    editors.forEach(editorElement => {
        ClassicEditor
            .create(editorElement, {
                plugins: [Essentials, Paragraph, Bold, Italic, Underline, Font],
                toolbar: [
                    'undo', 'redo', '|', 'bold', 'italic', 'underline', '|',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
                ],
                fontSize: {
                    options: [
                        8, 10, 12, 14, 'default', 18, 20, 22, 24, 28, 32, 36, 40, 48, 56, 64, 72, 96, 120,
                    ],
                    supportAllValues: true
                },
                fontFamily: {
                    options: [
                        'default',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Times New Roman, Times, serif',
                        'Verdana, Geneva, sans-serif'
                    ],
                    supportAllValues: true
                }
            })
            .then(editor => {
                window.editor = editor;  // Optionally store the editor instance
            })
            .catch(error => {
                console.error('There was a problem initializing the editor:', error);
            });
    });
</script>

<!-- Reminder to use an HTTP server -->
<script>
    window.onload = function() {
        if (window.location.protocol === 'file:') {
            alert('This sample requires an HTTP server. Please serve this file with a web server.');
        }
    };
</script>


@endsection
