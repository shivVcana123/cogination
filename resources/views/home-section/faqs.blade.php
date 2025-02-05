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
                                <div class="row">
                                    <!-- Title Field -->
                                    <div class="form-group col-md-6">
                                        <label for="title">Title</label>
                                        <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                        <input type="text" class="form-control" name="title" id="title"
                                            placeholder="Enter title" value="{{ old('title', $saveFaqs[0]->title ?? '') }}" required>
                                        @error('title')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <!-- Subtitle Field -->
                                    <div class="form-group col-md-6">
                                        <label for="subtitle">Subtitle</label>
                                        <i class="fas fa-info-circle" title="Provide a brief subtitle that complements the main title of this section."></i> <label for="">(Optional)</label>
                                        <input type="text" class="form-control" name="subtitle" id="subtitle"
                                            placeholder="Enter subtitle" value="{{ old('subtitle', $saveFaqs[0]->subtitle ?? '') }}">
                                        @error('subtitle')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
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
                                        <div class="row">
                                            <!-- Title Field -->
                                            <div class="form-group col-md-6">
                                                <label for="question">Question</label>
                                                <i class="fas fa-info-circle" title="Enter a meaningful question that summarizes the purpose of this section."></i>
                                                <input type="text" class="form-control" name="question[]" id="question"
                                                    placeholder="Enter question" value="{{ old('question', $pointer['question'] ?? '') }}" required>
                                                @error('question')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>


                                            <!-- answer Field -->
                                            <div class="form-group col-md-6">
                                                <label for="answer">Answer</label>
                                                <i class="fas fa-info-circle" title="Provide a brief answer that complements the main title of this section."></i>
                                                <input type="text" class="form-control" name="answer[]" id="answer"
                                                    placeholder="Enter answer" value="{{ old('answer', $pointer['answer'] ?? '') }}" required>
                                                @error('answer')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Remove Button -->
                                        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                    </div>
                                    @endforeach
                                    @else
                                    <!-- Default empty field when no pointers exist -->
                                    <div class="form-group url-group">
                                        <div class="row">
                                            <!-- Title Field -->
                                            <div class="form-group col-md-6">
                                                <label for="question">Question</label>
                                                <i class="fas fa-info-circle" title="Enter a meaningful question that summarizes the purpose of this section."></i>
                                                <input type="text" class="form-control" name="question[]" id="question"
                                                    placeholder="Enter question" value="" required>
                                                @error('question')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>


                                            <!-- answer Field -->
                                            <div class="form-group col-md-6">
                                                <label for="answer">Answer</label>
                                                <i class="fas fa-info-circle" title="Provide a brief answer that complements the main title of this section."></i>
                                                <input type="text" class="form-control" name="answer[]" id="answer"
                                                    placeholder="Enter answer" value="" required>
                                                @error('answer')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                    </div>
                                    @endif
                                </div>
                                <!-- Add Pointer Button -->
                                <button type="button" class="btn btn-success" id="add-Pointers">Add More Questions</button>
                            </div>

                            <div class="card-footer">
                            <input type="checkbox" id="status" name="status" {{ ($saveFaqs[0]->status ?? '') === 'on' ? 'checked' : '' }}>
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

document.getElementById('add-Pointers').addEventListener('click', function () {
    const container = document.getElementById('Pointers-container');
    const newInputGroup = document.createElement('div');
    newInputGroup.classList.add('form-group', 'url-group');
    newInputGroup.innerHTML = `
        <div class="row">
            <!-- Question Field -->
            <div class="form-group col-md-6">
                <label for="question">Question</label>
                <i class="fas fa-info-circle" title="Enter a meaningful question that summarizes the purpose of this section."></i>
                <input type="text" class="form-control" name="question[]" id="question" placeholder="Enter question" value="" required>
                <div class="text-danger question-error" style="display: none;">This field is required.</div>
            </div>

            <!-- Answer Field -->
            <div class="form-group col-md-6">
                <label for="answer">Answer</label>
                <i class="fas fa-info-circle" title="Provide a brief answer that complements the main title of this section."></i>
                <input type="text" class="form-control" name="answer[]" id="answer" placeholder="Enter answer" value="" required>
                <div class="text-danger answer-error" style="display: none;">This field is required.</div>
            </div>
        </div>
        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
    `;
    container.appendChild(newInputGroup);
    updateRemoveButtonVisibility(); // Ensure the visibility of "Remove" buttons is updated
});

document.getElementById('Pointers-container').addEventListener('click', function (event) {
    if (event.target.classList.contains('remove-Pointers')) {
        event.target.closest('.url-group').remove();
        updateRemoveButtonVisibility(); // Ensure the visibility of "Remove" buttons is updated
    }
});

// Validation function
function validateFields() {
    const urlGroups = document.querySelectorAll('.url-group');
    let isValid = true;

    urlGroups.forEach((group) => {
        const questionInput = group.querySelector('input[name="question[]"]');
        const answerInput = group.querySelector('input[name="answer[]"]');
        const questionError = group.querySelector('.question-error');
        const answerError = group.querySelector('.answer-error');

        // Reset error messages
        if (questionError) questionError.style.display = 'none';
        if (answerError) answerError.style.display = 'none';

        // Validate question
        if (!questionInput.value.trim()) {
            if (questionError) questionError.style.display = 'block';
            isValid = false;
        }

        // Validate answer
        if (!answerInput.value.trim()) {
            if (answerError) answerError.style.display = 'block';
            isValid = false;
        }
    });

    // if (!isValid) {
    //     alert('Please fill out all required fields.');
    // }

    return isValid;
}

// Add submit listener for validation
document.getElementById('form-submit-button').addEventListener('click', function (event) {
    if (!validateFields()) {
        event.preventDefault(); // Prevent form submission if validation fails
    }
});

// Initial visibility check when the page loads
document.addEventListener('DOMContentLoaded', function () {
    updateRemoveButtonVisibility();
});

   
</script>

@endsection