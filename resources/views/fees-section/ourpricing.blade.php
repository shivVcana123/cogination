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
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="title">Title</label>
                                        <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                        <input type="text" class="form-control" name="title" id="title"
                                            placeholder="Enter title" value="{{ old('title', $ourPricing[0]->title ?? '') }}">
                                        @error('title')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="title">Button Text</label>
                                        <i class="fas fa-info-circle" title="The Button Text field allows you to specify the label that will appear on the button."></i>
                                        <input type="text" class="form-control" name="button_content" id="button_content" placeholder="Enter Button Text" value="{{old('button_content',$ourPricing[0]->button_content ?? '')}}">
                                        @error('button_content')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

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

                                <hr>

                                @php
                                $pointers = isset($ourPricing[0]) && !empty($ourPricing[0]->pointers)
                                ? json_decode($ourPricing[0]->pointers)
                                : [];
                                @endphp

                                <!-- Pointers Section -->
                                <label for="">Card Details</label>
                                <div id="Pointers-container">
                                    @forelse($pointers as $index => $pointer)
                                    @if (count($pointers) > 1 && $index > 0)
        <hr>
    @endif
                                    <div class="form-group url-group">
                                        <!-- Sub Title -->
                                        <label> Title</label>
                                        <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                        <input type="text" name="sub_title[]" class="form-control mb-2" value="{{ old('sub_title.' . $index, $pointer->sub_title ?? '') }}" placeholder="Enter title">
                                        @error('sub_title.' . $index)
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <!-- Sub Descriptions -->
                                        <div class="form-group sub-group" id="add-sub-description-{{ $index }}">
                                            @php
                                            // Explode the strings into arrays for sub_descriptions and prices
                                            $descriptions = explode(',', $pointer->sub_description);
                                            $prices = explode(',', $pointer->price);
                                            @endphp

                                            @foreach ($descriptions as $key => $description)
                                            <div class="row mb-2">
                                                <div class="col-md-6">
                                                    <label> Description</label>
                                                    <i class="fas fa-info-circle" title="Provide a meaningful description for this section."></i>
                                                    <input
                                                        type="text"
                                                        name="sub_description[{{ $index }}][]"
                                                        class="form-control"
                                                        value="{{ old('sub_description.' . $index . '.' . $key, $description) }}"
                                                        placeholder="Enter description">
                                                    @error('sub_description.' . $index . '.' . $key)
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <label>Price</label>
                                                    <i class="fas fa-info-circle" title="Provide a meaningful price for this section."></i>
                                                    <input
                                                        type="number" step="0.01"
                                                        name="price[{{ $index }}][]"
                                                        class="form-control"
                                                        value="{{ old('price.' . $index . '.' . $key, $prices[$key] ?? '') }}"
                                                        placeholder="Enter price">
                                                    @error('price.' . $index . '.' . $key)
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-danger remove-description">Remove</button>
                                                </div>
                                            </div>
                                            @endforeach

                                            <button type="button" class="btn btn-success add-description">Add</button>
                                        </div>

                                        <!-- Remove Pointer Button -->
                                        <button type="button" class="btn btn-danger remove-Pointers">Remove Card</button>
                                    </div>
                                    @empty
                                    <div class="form-group url-group">
                                        <!-- Sub Title -->
                                        <label> Title</label>
                                        <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                                        <input type="text" name="sub_title[]" class="form-control" value="{{ old('sub_title.0') }}" placeholder="Enter title">
                                        @error('sub_title.*')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror

                                        <!-- Sub Description -->
                                        <div class="form-group sub-group">
                                            <div class="row mb-2">
                                                <div class="col-md-6">
                                                    <label> Description</label>
                                                    <i class="fas fa-info-circle" title="Provide a meaningful description for this section."></i>
                                                    <input type="text" name="sub_description[0][]" class="form-control" value="{{ old('sub_description.0.0') }}" placeholder="Enter description">
                                                    @error('sub_description.0.*')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <label>Price</label>
                                                    <i class="fas fa-info-circle" title="Provide a meaningful price for this section."></i>
                                                    <input type="number" step="0.01" name="price[0][]" class="form-control" value="{{ old('price.0.0') }}" placeholder="Enter price">
                                                    @error('price.0.*')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-danger remove-description">Remove Description</button>
                                                </div>
                                            </div>

                                            <button type="button" class="btn btn-success add-description">Add</button>
                                        </div>

                                        <!-- Remove Pointer Button -->
                                        <button type="button" class="btn btn-danger remove-Pointers">Remove Card</button>
                                    </div>
                                    @endforelse
                                </div>

                                <!-- Add Pointer Button -->
                                <button type="button" class="btn btn-success" id="add-Pointers">Add Card</button>
                            </div>

                            <div class="card-footer">
                                <input type="checkbox" id="status" name="status" {{ old('status', $ourPricing[0]->status ?? '') === 'on' ? 'checked' : '' }}>
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
@endsection
@section('java_script')
<script>
    CKEDITOR.replace('description');

    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('Pointers-container');

        // Add new Pointer group
        document.getElementById('add-Pointers').addEventListener('click', function() {
            const newInputGroup = document.createElement('div');
            newInputGroup.classList.add('form-group', 'url-group');
            newInputGroup.innerHTML = `<hr>
             <div class="form-group">
                <label> Title</label>
                <i class="fas fa-info-circle" title="Provide a meaningful title for this section."></i>
                <input type="text" name="sub_title[]" class="form-control mb-2" placeholder="Enter title">
                <div class="text-danger sub-title-error" style="display: none;">This field is required.</div>
            </div>
            <div class="form-group sub-group">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label> Description</label>
                        <i class="fas fa-info-circle" title="Provide a meaningful description for this section."></i>
                        <input type="text" name="sub_description[0][]" class="form-control" placeholder="Enter description">
                        <div class="text-danger sub-description-error" style="display: none;">This field is required.</div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label>Price</label>
                        <i class="fas fa-info-circle" title="Provide a meaningful price for this section."></i>
                        <input type="number" step="0.01" name="price[0][]" class="form-control" placeholder="Enter price">
                        <div class="text-danger price-error" style="display: none;">This field is required.</div>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-description">Remove</button>
                    </div>
                </div>
                <button type="button" class="btn btn-success add-description">Add</button>
            </div>
            <button type="button" class="btn btn-danger remove-Pointers">Remove Card</button>`;
            container.appendChild(newInputGroup);

            updateIndexes(); // Ensure new inputs have the correct index.
            updateRemoveButtonVisibility(); // Update remove button visibility
        });

        // Delegate events inside Pointers container
        container.addEventListener('click', function(event) {
            const target = event.target;

            // Add new Sub Description
            if (target.classList.contains('add-description')) {
                const subDescriptionContainer = target.closest('.sub-group');
                const index = [...container.querySelectorAll('.url-group')].indexOf(subDescriptionContainer.closest('.url-group'));
                const newRow = document.createElement('div');
                newRow.classList.add('row');
                newRow.innerHTML = `
                <div class="col-md-6">
                    <label> Description</label>
                    <i class="fas fa-info-circle" title="Provide a meaningful description for this section."></i>
                    <input type="text" name="sub_description[${index}][]" class="form-control" placeholder="Enter description">
                    <div class="text-danger sub-description-error" style="display: none;">This field is required.</div>
                </div>
                <div class="col-md-6 mb-2">
                    <label>Price</label>
                    <i class="fas fa-info-circle" title="Provide a meaningful price for this section."></i>
                    <input type="number" step="0.01" name="price[${index}][]" class="form-control" placeholder="Enter price">
                    <div class="text-danger price-error" style="display: none;">This field is required.</div>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-description mb-2">Remove Description</button>
                </div>`;

                // Append the new row above the Add button
                const addButton = subDescriptionContainer.querySelector('.add-description');
                subDescriptionContainer.insertBefore(newRow, addButton);

                updateIndexes(); // Update indexes after adding a new row
                updateRemoveButtonVisibility(); // Update remove button visibility
            }

            // Remove a Pointer group
            if (target.classList.contains('remove-Pointers')) {
                target.closest('.url-group').remove();
                updateIndexes(); // Update indexes after removing a group
                updateRemoveButtonVisibility(); // Update remove button visibility
            }

            // Remove a Sub Description
            if (target.classList.contains('remove-description')) {
                const subGroup = target.closest('.sub-group');
                target.closest('.row').remove();
                updateIndexes(); // Update indexes after removing a sub description
                updateRemoveButtonVisibility(); // Update remove button visibility
            }
        });

        // Update indexes for all groups and sub-descriptions
        function updateIndexes() {
            const groups = container.querySelectorAll('.url-group');
            groups.forEach((group, groupIndex) => {
                const subDescriptions = group.querySelectorAll('.sub-group .row input');
                subDescriptions.forEach((input) => {
                    const nameParts = input.name.split('[');
                    if (nameParts[0] === 'sub_description' || nameParts[0] === 'price') {
                        input.name = `${nameParts[0]}[${groupIndex}][]`; // Update name to reflect correct index
                    }
                });
            });
        }

        // Update Remove Button Visibility
        function updateRemoveButtonVisibility() {
            const groups = container.querySelectorAll('.url-group');
            groups.forEach((group) => {
                const removeButton = group.querySelector('.remove-Pointers');
                removeButton.style.display = groups.length > 1 ? 'inline-block' : 'none';
            });

            const allRows = container.querySelectorAll('.sub-group');
            allRows.forEach((subGroup) => {
                const rows = subGroup.querySelectorAll('.row');
                rows.forEach((row) => {
                    const removeButton = row.querySelector('.remove-description');
                    removeButton.style.display = rows.length > 1 ? 'inline-block' : 'none';
                });
            });
        }

        // Initial setup
        updateIndexes();
        updateRemoveButtonVisibility();
    });
</script>


@endsection