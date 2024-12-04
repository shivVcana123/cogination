@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Our Pricing Section</h1>
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
                            <h3 class="card-title">{{ empty($ourPricing) || !isset($ourPricing[0]) ? 'Add' : 'Edit' }} Our Pricing Section Details</h3>
                        </div>
                        <form action="{{ route('save-our-pricing-section') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{ old('id', $ourPricing[0]->id ?? '') }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                    <input type="text" class="form-control" name="title" id="title"
                                        placeholder="Enter title" value="{{ old('title',$ourPricing[0]->title ?? '') }}">
                                    @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <!-- Description Field -->
                                <div class="form-group">
                                    <label for="description_1">Description</label>
                                    <i class="fas fa-info-circle" title="Describe the purpose or details of this section in 2-3 sentences."></i>
                                    <textarea class="form-control" name="description" id="description">{{ old('description', $ourPricing[0]->description ?? '') }}</textarea>
                                    @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                @php
                                $pointers = isset($ourPricing[0]) && !empty($ourPricing[0]->pointers)
                                ? json_decode($ourPricing[0]->pointers)
                                : [];
                                @endphp

                                <!-- Pointers Section -->
                                <label for="">Add Extra Pointers</label>
                                <div id="Pointers-container">
                                    @forelse($pointers as $index => $pointer)


                                @php
                                    $descriptions = explode(',',$pointer->sub_description)
                                @endphp
                                    <div class="form-group url-group">
                                        <!-- Sub Title -->
                                        <label>Sub Title</label>
                                        <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                        <input type="text" name="sub_title[]" class="form-control" value="{{ $pointer->sub_title ?? '' }}" placeholder="Enter sub title">

                                        <!-- Sub Descriptions -->
                                        <div class="form-group sub-group" id="add-sub-description-{{ $index }}">
                                            @foreach ($descriptions as $description)
                                            
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <label>Sub Description</label>
                                                    <i class="fas fa-info-circle" title="Provide a meaningful description for this section."></i>
                                                    <input type="text" name="sub_description[{{ $index }}][]" class="form-control" value="{{$description}}" placeholder="Enter sub description">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-danger remove-description">Remove</button>
                                                </div>
                                            </div>
                                            @endforeach


                                            <button type="button" class="btn btn-success add-description">Add</button>
                                        </div>

                                        <!-- Remove Pointer Button -->
                                        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                    </div>
                                    @empty
                                    <div class="form-group url-group">
                                        <!-- Sub Title -->
                                        <label>Sub Title</label>
                                        <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                        <input type="text" name="sub_title[]" class="form-control" value="" placeholder="Enter sub title">

                                        <!-- Sub Description -->
                                        <div class="form-group sub-group">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <label>Sub Description</label>
                                                    <i class="fas fa-info-circle" title="Provide a meaningful description for this section."></i>
                                                    <input type="text" name="sub_description[0][]" class="form-control" value="" placeholder="Enter sub description">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-success add-description">Add</button>
                                                    <button type="button" class="btn btn-danger remove-description">Remove</button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Remove Pointer Button -->
                                        <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
                                    </div>
                                    @endforelse
                                </div>

                                <!-- Add Pointer Button -->
                                <button type="button" class="btn btn-success" id="add-Pointers">Add Pointer</button>


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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('Pointers-container');

    // Add new Pointer group
    document.getElementById('add-Pointers').addEventListener('click', function() {
        const newInputGroup = document.createElement('div');
        newInputGroup.classList.add('form-group', 'url-group');
        newInputGroup.innerHTML = `
            <label>Sub Title</label>
            <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
            <input type="text" name="sub_title[]" class="form-control" placeholder="Enter sub title">
            <div class="form-group sub-group">
                <div class="row">
                    <div class="col-md-10">
                        <label>Sub Description</label>
                        <i class="fas fa-info-circle" title="Provide a meaningful description for this section."></i>
                        <input type="text" class="form-control" placeholder="Enter sub description">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-description" style="display: none;">Remove</button>
                    </div>
                </div>
                <button type="button" class="btn btn-success add-description">Add</button>
            </div>
            <button type="button" class="btn btn-danger remove-Pointers">Remove</button>
        `;
        container.appendChild(newInputGroup);

        updateIndexes();
        updateRemoveButtonVisibility();
    });

    // Delegate events inside Pointers container
    container.addEventListener('click', function(event) {
        const target = event.target;

        // Add new Sub Description
        if (target.classList.contains('add-description')) {
            const subDescriptionContainer = target.closest('.sub-group');
            const index = [...container.children].indexOf(subDescriptionContainer.closest('.url-group'));
            const newRow = document.createElement('div');
            newRow.classList.add('row');
            newRow.innerHTML = `
                <div class="col-md-10">
                    <label>Sub Description</label>
                    <i class="fas fa-info-circle" title="Provide a meaningful description for this section."></i>
                    <input type="text" name="sub_description[${index}][]" class="form-control" placeholder="Enter sub description">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-description">Remove</button>
                </div>
            `;
            subDescriptionContainer.appendChild(newRow);

            updateIndexes();
            updateRemoveButtonVisibility();
        }

        // Remove a Pointer group
        if (target.classList.contains('remove-Pointers')) {
            target.closest('.url-group').remove();
            updateIndexes();
            updateRemoveButtonVisibility();
        }

        // Remove a Sub Description
        if (target.classList.contains('remove-description')) {
            target.closest('.row').remove();
            updateIndexes();
            updateRemoveButtonVisibility();
        }
    });

    // Update indexes for all groups and sub-descriptions
    function updateIndexes() {
        const groups = container.querySelectorAll('.url-group');
        groups.forEach((group, groupIndex) => {
            const subDescriptions = group.querySelectorAll('.sub-group .row input');
            subDescriptions.forEach(input => {
                input.name = `sub_description[${groupIndex}][]`;
            });

            // Update visibility of the remove button for sub-description inputs
            const removeButtons = group.querySelectorAll('.remove-description');
            if (subDescriptions.length > 1) {
                removeButtons.forEach(button => button.style.display = 'inline-block');
            } else {
                removeButtons.forEach(button => button.style.display = 'none');
            }
        });
    }

    // Update Remove Button Visibility
    function updateRemoveButtonVisibility() {
        const groups = container.querySelectorAll('.url-group');
        groups.forEach(group => {
            const removeButton = group.querySelector('.remove-Pointers');
            removeButton.style.display = groups.length > 1 ? 'inline-block' : 'none';
        });
    }

    // Initial setup
    updateIndexes();
    updateRemoveButtonVisibility();
});

</script>

@endsection