@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ isset($cta->id) ? 'Edit cta Section' : 'Add cta Section' }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('cta.index') }}">cta</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ isset($cta->id) ? 'Edit Form' : 'Add Form' }}
                        </li>
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
                            <h3 class="card-title">{{ isset($cta->id) ? 'Edit CTA Details' : 'Add CTA Details' }}</h3>
                        </div>

                        <form action="{{ isset($cta->id) ? route('cta.update', $cta->id) : route('cta.store') }}"
                            method="POST" enctype="multipart/form-data" id="ctaForm">
                            @csrf
                            @if($cta->id)
                            @method('PUT')
                            @endif
                            <input type="hidden" name="hidden_id" value="{{ $cta->id }}">
                            <div class="card-body">
                                <!-- Title and Subtitle -->
                                <div class="row">
                                    @if (!empty($cta->id))
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cta_type">Service Type</label>
                                            <input type="text" class="form-control" name="cta_type" id="cta_type"
                                                value="{{ old('cta_type', $cta->cta_type ?? '') }}" placeholder="Enter Title" readonly>
                                        </div>
                                    </div>
                                    @else
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cta_type">Service Type</label>
                                            <select class="form-control" name="cta_type" id="cta_type">
                                                <option value="" selected disabled>Please Select Type</option>
                                                @if ($links)
                                                @foreach($links as $child)
                                                <option value="{{ $child->category }}"
                                                    {{ old('cta_type', $cta->cta_type ?? '') == $child->category ? 'selected' : '' }}>
                                                    {{ $child->category }}
                                                </option>
                                                @endforeach
                                                @else
                                                <option value="">No children available</option>
                                                @endif
                                            </select>
                                            <div class="text-danger" id="cta_type_error"></div>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" name="title" id="title"
                                                value="{{ old('title', $cta->title ?? '') }}" placeholder="Enter Title">
                                            <div class="text-danger" id="title_error"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="description">Description</label><i class="fas fa-info-circle" title="Enter a description for Footer Section."></i>
                                    <textarea class="form-control" name="description" id="description" placeholder="Enter Text">{{ $cta->description }}</textarea>
                                    <div class="text-danger" id="description_error"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="button_content">Button Text</label>
                                            <input type="text" class="form-control" name="button_content" id="button_content" placeholder="Enter Button Text" value="{{ old('button_content', $cta->button_content) }}">
                                            <div class="text-danger" id="button_content_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="button_link">Button Link</label>
                                            <input type="text" class="form-control" name="button_link" id="button_link" value="{{ old('button_link', $cta->button_link) }}" placeholder="Enter Button link">
                                            <div class="text-danger" id="button_link_error"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Submit Button -->
                                <div class="card-footer">
                                    <input type="checkbox" id="status" name="status" {{ ($cta->status ?? '') === 'on' ? 'checked' : '' }}>
                                    <label for="status">Show On Website</label>
                                    <button type="submit" class="btn btn-primary">{{ isset($cta->id) ? 'Update' : 'Submit' }}</button>
                                </div>
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
    document.getElementById('ctaForm').addEventListener('submit', function(event) {

        // Service Type Validation
        const ctaType = document.getElementById('cta_type');
        const ctaTypeError = document.getElementById('cta_type_error');

        let isValid = true;

        // Validate the select input
        if (!ctaType.value || ctaType.value === '') {
            isValid = false;
            ctaTypeError.textContent = 'Please select a service type.';
        } else {
            ctaTypeError.textContent = '';
        }

        // Prevent form submission if validation fails

        // Title Validation
        const title = document.getElementById('title');
        const titleError = document.getElementById('title_error');
        if (title.value.trim() === '') {
            isValid = false;
            titleError.textContent = 'The title field is required.';
        } else {
            titleError.textContent = '';
        }

        // Description Validation
        const description = document.getElementById('description');
        const descriptionError = document.getElementById('description_error');
        if (description.value.trim() === '') {
            isValid = false;
            descriptionError.textContent = 'The description field is required.';
        } else {
            descriptionError.textContent = '';
        }

        // If any validation fails, prevent form submission
        if (!isValid) {
            event.preventDefault();
        }
    });
</script>
@endsection