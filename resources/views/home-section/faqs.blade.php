@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>FAQs Section</h1>
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
                                {{ empty($saveFaqs) || !isset($saveFaqs[0]) ? 'Add' : 'Edit' }} FAQs Details
                            </h3>
                        </div>


                        <form action="{{ route('save-faq') }}" method="post" enctype="multipart/form-data">
                        @csrf
                            <input type="hidden" name="id" value="{{ old('id', $saveFaqs[0]->id ?? '') }}">

                            <div class="card-body">
                                <!-- Title Field -->
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                    <input type="text" class="form-control" name="title" id="title"
                                        placeholder="Enter title" value="{{ old('title', $saveFaqs[0]->title ?? '') }}">
                                    @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <!-- Subtitle Field -->
                                <div class="form-group">
                                    <label for="subtitle">Subtitle</label>
                                    <i class="fas fa-info-circle" title="Provide a brief subtitle that complements the main title of this section."></i>
                                    <input type="text" class="form-control" name="subtitle" id="subtitle"
                                        placeholder="Enter subtitle" value="{{ old('subtitle', $saveFaqs[0]->subtitle ?? '') }}">
                                    @error('subtitle')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                        
                                <!-- Pointers Section -->
                                <div id="Pointers-container">
                                    @php
                                    $pointers = old('question')
                                    ? array_map(null, old('question', []), old('answer', []))
                                    : (isset($saveFaqs[0]->pointers) ? json_decode($saveFaqs[0]->pointers, true) : []);
                                    @endphp

                                    @if (!empty($pointers))
                                    @foreach ($pointers as $index => $pointer)
                                    <div class="form-group url-group">
                                        <!-- Sub Title -->
                                        <label>Question</label>
                                        <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                        <input type="text" name="question[]" class="form-control"
                                            value="{{ old('question.' . $index, $pointer['question'] ?? '') }}"
                                            placeholder="Enter question">
                                        @error("question.{$index}")
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror

                                        <!-- Sub Description -->
                                        <label>Answer</label>
                                        <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                        <input type="text" name="answer[]" class="form-control"
                                            value="{{ old('answer.' . $index, $pointer['answer'] ?? '') }}"
                                            placeholder="Enter sub description">
                                        @error("answer.{$index}")
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror

                                        <!-- Remove Button -->
                                        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                    </div>
                                    @endforeach
                                    @else
                                    <!-- Default empty field when no pointers exist -->
                                    <div class="form-group url-group">
                                        <label>Question</label>
                                        <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                        <input type="text" name="question[]" class="form-control"
                                            value="" placeholder="Enter sub title">
                                        <label>Answer</label>
                                        <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                        <input type="text" name="answer[]" class="form-control"
                                            value="" placeholder="Enter sub description">
                                        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                    </div>
                                    @endif
                                </div>
                                <!-- Add Pointer Button -->
                                <button type="button" class="btn btn-success" id="add-Pointers">Add More Questions</button>
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
        <label>Question</label>
        <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
        <div class="input-group mb-2">
            <input type="text" name="question[]" class="form-control" placeholder="Enter sub title">
        </div>
        <label>Answer</label>
        <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
        <div class="input-group mb-2">
            <input type="text" name="answer[]" class="form-control" placeholder="Enter sub description">
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