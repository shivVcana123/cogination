@extends('layouts.guest')
@section('content')
<!-- Correct Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

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
    <div class="container">
        <div class="accordion" id="accordionExample">
            <!-- Accordion Item 1 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Section 1
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                    <div class="accordion-body">
                        <form action="{{ route('save-autism-section') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ old('id', $autismSection[0]->id ?? '') }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="type">Select Type</label>
                                    <i class="fas fa-info-circle" title="Choose the appropriate type for this section."></i>
                                    <select name="type" class="form-control" id="type">
                                        <option disabled selected>Please Select Type</option>
                                        <option value="Child" {{ isset($autismSection[0]) && $autismSection[0]->type === 'Child' ? 'selected' : '' }}>Child</option>
                                        <option value="Adult" {{ isset($autismSection[0]) && $autismSection[0]->type === 'Adult' ? 'selected' : '' }}>Adult</option>
                                    </select>
                                    @error('type')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <i class="fas fa-info-circle" title="Enter a meaningful title."></i>
                                    <input type="text" class="form-control" name="first_title" id="title" placeholder="Enter first title" value="{{ old('first_title', $autismSection[0]->first_title ?? '') }}">
                                    @error('first_title')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="subtitle">Subtitle</label>
                                    <i class="fas fa-info-circle" title="Provide a brief subtitle."></i>
                                    <input type="text" class="form-control" name="first_subtitle" id="subtitle" placeholder="Enter first subtitle" value="{{ old('first_subtitle', $autismSection[0]->first_subtitle ?? '') }}">
                                    @error('first_subtitle')
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
            <!-- Accordion Item 2 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Section 2
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo">
                    <div class="accordion-body">
                        This is the second item's accordion body.
                    </div>
                </div>
            </div>
            <!-- Accordion Item 3 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Section 3
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree">
                    <div class="accordion-body">
                        This is the third item's accordion body.
                    </div>
                </div>
            </div>
             <!-- Accordion Item 2 -->
             <div class="accordion-item">
                <h2 class="accordion-header" id="headingfour">
                    <button class="accordion-button collapsed" type="button" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Section 2
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingfour">
                    <div class="accordion-body">
                        This is the second item's accordion body.
                    </div>
                </div>
            </div>
            <!-- Accordion Item 5 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingfive">
                    <button class="accordion-button collapsed" type="button" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Section 5
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingfive">
                    <div class="accordion-body">
                        This is the third item's accordion body.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Toggle functionality for accordion
        const accordionButtons = document.querySelectorAll('.accordion-button');
        accordionButtons.forEach(button => {
            button.addEventListener('click', () => {
                const collapseElement = document.querySelector(button.getAttribute('data-bs-target'));
                collapseElement.classList.toggle('show');
                button.classList.toggle('collapsed');
            });
        });
    });
</script>
@endsection
