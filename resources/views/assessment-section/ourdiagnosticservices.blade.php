@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Our Diagnostic Services Section</h1>
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
                                {{ empty($ourDiagnostic) || !isset($ourDiagnostic[0]) ? 'Add' : 'Edit' }} Our Diagnostic Services Details
                            </h3>
                        </div>

                        <form action="{{ route('save-our-diagnostic-services') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ old('id', $ourDiagnostic[0]->id ?? '') }}">

                            <div class="card-body">
                                <!-- Title Field -->
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" value="{{ old('title', $ourDiagnostic[0]->title ?? '') }}">
                                    @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description Field -->
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <i class="fas fa-info-circle" title="Describe the purpose or details of this section in 2-3 sentences."></i>
                                    <textarea class="form-control" name="description" id="description">{{ old('description', $ourDiagnostic[0]->description ?? '') }}</textarea>
                                    @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <hr>

                                <!-- Extra Pointers Section -->
                                @php
                                $pointers = isset($ourDiagnostic[0]) && !empty($ourDiagnostic[0]->pointers)
                                ? json_decode($ourDiagnostic[0]->pointers)
                                : [];
                                @endphp
                                <div class="mb-3">
                                    <h5>Add Extra Pointers</h5>
                                    <div id="pointerFields">

                                        @if(!empty($pointers) && is_array($pointers))
                                        @foreach ($pointers as $index => $details)
                                        <div class="pointer-field mb-3" data-pointer-id="{{ $index }}">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="pointerTitle{{ $index }}">Pointer Title</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful pointer title that summarizes the purpose of this section."></i>
                                                    <input type="text" id="pointerTitle{{ $index }}" class="form-control mb-2" name="pointerTitle[]" placeholder="Enter pointer title" value="{{ $details->pointerTitle }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="pointerDescription{{ $index }}">Pointer Description</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful pointer description that summarizes the purpose of this section."></i>
                                                    <input type="text" id="pointerDescription{{ $index }}" class="form-control mb-2" name="pointerDescription[]" placeholder="Enter pointer description" value="{{ $details->pointerDescription }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="button1Text{{ $index }}">Button 1 Text</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful button 1 text of this section."></i>
                                                    <input type="text" id="button1Text{{ $index }}" class="form-control mb-2" name="button1Text[]" placeholder="Enter Button 1 Text" value="{{ $details->button1Text }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="button1Link{{ $index }}">Button 1 Link</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful button 1 link of this section."></i>
                                                    <input type="text" id="button1Link{{ $index }}" class="form-control mb-2" name="button1Link[]" placeholder="Enter Button 1 Link" value="{{ $details->button1Link }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="button2Text{{ $index }}">Button 2 Text</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful button 2 Text of this section."></i>
                                                    <input type="text" id="button2Text{{ $index }}" class="form-control mb-2" name="button2Text[]" placeholder="Enter Button 2 Text" value="{{ $details->button2Text }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="button2Link{{ $index }}">Button 2 Link</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful button 2 link of this section."></i>
                                                    <input type="text" id="button2Link{{ $index }}" class="form-control mb-2" name="button2Link[]" placeholder="Enter Button 2 Link" value="{{ $details->button2Link }}">
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="image{{ $index }}">Image</label>
                                                    <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                                    <img id="blah" src="{{asset($details->sub_image)}}" alt="Image Preview" style="width: 130px; display:{{empty($details->sub_image) ? 'none' : 'block'}}" />
                                                    <input type="file" id="image{{ $index }}" class="form-control mb-2" name="image[]" accept="image/*">
                                                </div>
                                            </div>
                                            <hr>
                                            <h5>Add Sub Pointers</h5>
                                            <div class="sub-pointer-area" data-pointer-id="{{ $index }}">
                                                @foreach ($details->sub_pointer as $subIndex => $subPointer)
                                                <div class="sub-pointer mb-3" data-sub-pointer-id="{{ $subIndex }}">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="pointerSubTitle{{ $index }}_{{ $subIndex }}">Pointer Sub Title</label>
                                                            <i class="fas fa-info-circle" title="Enter a meaningful pointer sub title that summarizes the purpose of this section."></i>
                                                            <input type="text" id="pointerSubTitle{{ $index }}_{{ $subIndex }}" class="form-control mb-2" name="pointerSubTitle[{{ $index }}][{{ $subIndex }}]" placeholder="Enter pointer sub title" value="{{ $subPointer->pointerSubTitle1 ?? '' }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="pointerSubDescription{{ $index }}_{{ $subIndex }}">Pointer Sub Description</label>
                                                            <i class="fas fa-info-circle" title="Enter a meaningful pointer sub description that summarizes the purpose of this section."></i>
                                                            <textarea id="pointerSubDescription{{ $index }}_{{ $subIndex }}" class="form-control mb-2" name="pointerSubDescription[{{ $index }}][{{ $subIndex }}]" placeholder="Enter pointer sub description">{{ $subPointer->pointerSubDescription1 ?? '' }}</textarea>
                                                        </div>
                                                        <button type="button" class="btn btn-danger btn-sm remove-sub-pointer">Remove Sub Pointer</button>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="btn btn-success add-sub-pointer">Add Sub Pointer</button>
                                            <button type="button" class="btn btn-danger btn-sm remove-pointer">Remove Pointer</button>
                                        </div>
                                        @endforeach
                                        @else
                                        <!-- Empty Pointer Fields -->
                                        <div class="pointer-field mb-3" data-pointer-id="0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="pointerTitle0">Pointer Title</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful pointer title that summarizes the purpose of this section."></i>
                                                    <input type="text" id="pointerTitle0" class="form-control mb-2" name="pointerTitle[]" placeholder="Enter pointer title">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="pointerDescription0">Pointer Description</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful pointer description that summarizes the purpose of this section."></i>
                                                    <input type="text" id="pointerDescription0" class="form-control mb-2" name="pointerDescription[]" placeholder="Enter pointer description">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="button1Text0">Button 1 Text</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful button 1 text that summarizes the purpose of this section."></i>
                                                    <input type="text" id="button1Text0" class="form-control mb-2" name="button1Text[]" placeholder="Enter Button 1 Text">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="button1Link0">Button 1 Link</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful button 1 link that summarizes the purpose of this section."></i>
                                                    <input type="text" id="button1Link0" class="form-control mb-2" name="button1Link[]" placeholder="Enter Button 1 Link">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="button2Text0">Button 2 Text</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful button 2 text that summarizes the purpose of this section."></i>
                                                    <input type="text" id="button2Text0" class="form-control mb-2" name="button2Text[]" placeholder="Enter Button 2 Text">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="button2Link0">Button 2 Link</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful button 2 link that summarizes the purpose of this section."></i>
                                                    <input type="text" id="button2Link0" class="form-control mb-2" name="button2Link[]" placeholder="Enter Button 2 Link">
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="image0">Image</label>
                                                    <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                                    <img id="blah" src="#" alt="Image Preview" style="width: 130px; display:none" />
                                                    <input type="file" id="image0" class="form-control mb-2" name="image[]" accept="image/*">
                                                </div>
                                            </div>
                                            <hr>
                                            <h5>Add Sub Pointers</h5>
                                            <div class="sub-pointer-area ">
                                                <div class="sub-pointer mb-3 " data-sub-pointer-id="0">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="pointerSubTitle0_0">Pointer Sub Title</label>
                                                            <i class="fas fa-info-circle" title="Enter a meaningful pointer sub title that summarizes the purpose of this section."></i>
                                                            <input type="text" id="pointerSubTitle0_0" class="form-control mb-2" name="pointerSubTitle[0][]" placeholder="Enter pointer sub title">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="pointerSubDescription0_0">Pointer Sub Description</label>
                                                            <i class="fas fa-info-circle" title="Enter a meaningful pointer sub description that summarizes the purpose of this section."></i>
                                                            <textarea id="pointerSubDescription0_0" class="form-control mb-2" name="pointerSubDescription[0][]" placeholder="Enter pointer sub description"></textarea>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-danger remove-sub-pointer">Remove Sub Pointer</button>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-success add-sub-pointer">Add Sub Pointer</button>
                                            <button type="button" class="btn btn-danger remove-pointer">Remove Pointer</button>

                                        </div>
                                        @endif
                                    </div>

                                    <button type="button" id="addPointer" class="btn btn-success">Add Pointer</button>
                                </div>
                            </div>

                            <div class="card-footer">
                                <input type="checkbox" id="status" name="status" {{ ($ourDiagnostic[0]->status ?? '') === 'on' ? 'checked' : '' }}>
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
<!-- <script>
    CKEDITOR.replace('description');

    // Add Pointer
    document.getElementById('addPointer').addEventListener('click', function() {
        let pointerCount = document.querySelectorAll('.pointer-field').length;

        // Create a new div for the pointer field
        let newDiv = document.createElement('div');
        newDiv.classList.add('pointer-field', 'mb-3');
        newDiv.setAttribute('data-pointer-id', pointerCount);

        // Set the innerHTML for the pointer field with labels
        newDiv.innerHTML = `
        <div class="row">
            <div class="col-md-6">
                <label for="pointerTitle${pointerCount}">Pointer Title</label>
                <input type="text" id="pointerTitle${pointerCount}" class="form-control mb-2" name="pointerTitle[]" placeholder="Enter pointer title">
            </div>
            <div class="col-md-6">
                <label for="pointerDescription${pointerCount}">Pointer Description</label>
                <input type="text" id="pointerDescription${pointerCount}" class="form-control mb-2" name="pointerDescription[]" placeholder="Enter pointer description">
            </div>
            <div class="col-md-6">
                <label for="button1Text${pointerCount}">Button 1 Text</label>
                <input type="text" id="button1Text${pointerCount}" class="form-control mb-2" name="button1Text[]" placeholder="Enter Button 1 Text">
            </div>
            <div class="col-md-6">
                <label for="button1Link${pointerCount}">Button 1 Link</label>
                <input type="text" id="button1Link${pointerCount}" class="form-control mb-2" name="button1Link[]" placeholder="Enter Button 1 Link">
            </div>
            <div class="col-md-6">
                <label for="button2Text${pointerCount}">Button 2 Text</label>
                <input type="text" id="button2Text${pointerCount}" class="form-control mb-2" name="button2Text[]" placeholder="Enter Button 2 Text">
            </div>
            <div class="col-md-6">
                <label for="button2Link${pointerCount}">Button 2 Link</label>
                <input type="text" id="button2Link${pointerCount}" class="form-control mb-2" name="button2Link[]" placeholder="Enter Button 2 Link">
            </div>
            <div class="col-md-12">
                <label for="image${pointerCount}">Image</label>
                <input type="file" id="image${pointerCount}" class="form-control mb-2" name="image[]" accept="image/*">
            </div>
        </div>
        <hr>
        <h5>Add Sub Pointers</h5>
        <div class="sub-pointer-area" data-pointer-id="${pointerCount}">
            <div class="sub-pointer mb-3" data-sub-pointer-id="0">
                <div class="row">
                    <div class="col-md-6">
                        <label for="pointerSubTitle${pointerCount}_0">Pointer Sub Title</label>
                        <input type="text" id="pointerSubTitle${pointerCount}_0" class="form-control mb-2" name="pointerSubTitle[${pointerCount}][]" placeholder="Enter pointer sub title">
                    </div>
                    <div class="col-md-6">
                        <label for="pointerSubDescription${pointerCount}_0">Pointer Sub Description</label>
                        <textarea id="pointerSubDescription${pointerCount}_0" class="form-control mb-2" name="pointerSubDescription[${pointerCount}][]" placeholder="Enter pointer sub description"></textarea>
                    </div>
                </div>
                <button type="button" class="btn btn-danger btn-sm remove-sub-pointer">Remove Sub Pointer</button>
            </div>
        </div>
        <button type="button" class="btn btn-success add-sub-pointer">Add Sub Pointer</button>
        <button type="button" class="btn btn-danger btn-sm remove-pointer">Remove Pointer</button>
    `;

        // Append the new pointer field to the container
        document.getElementById('pointerFields').appendChild(newDiv);
    });

    // Event delegation for remove/add sub-pointers and pointers
    document.getElementById('pointerFields').addEventListener('click', function(e) {
        // Remove Pointer
        if (e.target.classList.contains('remove-pointer')) {
            let pointerField = e.target.closest('.pointer-field');
            pointerField.remove();
        }

        // Remove Sub Pointer
        if (e.target.classList.contains('remove-sub-pointer')) {
            let subPointer = e.target.closest('.sub-pointer');
            subPointer.remove();
        }

        // Add Sub Pointer
        if (e.target.classList.contains('add-sub-pointer')) {
            let pointerField = e.target.closest('.pointer-field');
            let subPointerCount = pointerField.querySelectorAll('.sub-pointer').length;
            let subPointer = document.createElement('div');
            subPointer.classList.add('sub-pointer', 'mb-3');
            subPointer.setAttribute('data-sub-pointer-id', subPointerCount);
            subPointer.innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <label for="pointerSubTitle${pointerField.getAttribute('data-pointer-id')}_${subPointerCount}" class="form-label">Sub Pointer Title</label>
                    <input type="text" class="form-control mb-2" name="pointerSubTitle[${pointerField.getAttribute('data-pointer-id')}][${subPointerCount}]" id="pointerSubTitle${pointerField.getAttribute('data-pointer-id')}_${subPointerCount}" placeholder="Enter pointer sub title">
                </div>
                <div class="col-md-6">
                    <label for="pointerSubDescription${pointerField.getAttribute('data-pointer-id')}_${subPointerCount}" class="form-label">Sub Pointer Description</label>
                    <textarea class="form-control mb-2" name="pointerSubDescription[${pointerField.getAttribute('data-pointer-id')}][${subPointerCount}]" id="pointerSubDescription${pointerField.getAttribute('data-pointer-id')}_${subPointerCount}" placeholder="Enter pointer sub description"></textarea>
                </div>
            </div>
            <button type="button" class="btn btn-danger btn-sm remove-sub-pointer">Remove Sub Pointer</button>
        `;
            pointerField.querySelector('.sub-pointer-area').appendChild(subPointer);
        }
    });
</script> -->

<!-- <script>
    // Initialize CKEditor
    CKEDITOR.replace('description');

    // Function to check lengths
    function checkLengths() {
        const removePointerLength = document.querySelectorAll('.remove-pointer').length;
        const removeSubPointerLength = document.querySelectorAll('.remove-sub-pointer').length;

        console.log(`Remove Pointer Buttons: ${removePointerLength}`);
        console.log(`Remove Sub Pointer Buttons: ${removeSubPointerLength}`);
    }

    // Run on page load
    document.addEventListener('DOMContentLoaded', function () {
        checkLengths();
    });

    // Add Pointer
    document.getElementById('addPointer').addEventListener('click', function() {
        let pointerCount = document.querySelectorAll('.pointer-field').length;

        // Create a new div for the pointer field
        let newDiv = document.createElement('div');
        newDiv.classList.add('pointer-field', 'mb-3');
        newDiv.setAttribute('data-pointer-id', pointerCount);

        // Set the innerHTML for the pointer field with labels
        newDiv.innerHTML = `
        <div class="row">
            <div class="col-md-6">
                <label for="pointerTitle${pointerCount}">Pointer Title</label>
                <i class="fas fa-info-circle" title="Enter a meaningful pointer title that summarizes the purpose of this section."></i>
                <input type="text" id="pointerTitle${pointerCount}" class="form-control mb-2" name="pointerTitle[]" placeholder="Enter pointer title">
            </div>
            <div class="col-md-6">
                <label for="pointerDescription${pointerCount}">Pointer Description</label>
                <i class="fas fa-info-circle" title="Enter a meaningful pointer description that summarizes the purpose of this section."></i>
                <input type="text" id="pointerDescription${pointerCount}" class="form-control mb-2" name="pointerDescription[]" placeholder="Enter pointer description">
            </div>
            <div class="col-md-6">
                <label for="button1Text${pointerCount}">Button 1 Text</label>
                <i class="fas fa-info-circle" title="Enter a meaningful button 1 text that summarizes the purpose of this section."></i>
                <input type="text" id="button1Text${pointerCount}" class="form-control mb-2" name="button1Text[]" placeholder="Enter Button 1 Text">
            </div>
            <div class="col-md-6">
                <label for="button1Link${pointerCount}">Button 1 Link</label>
                <i class="fas fa-info-circle" title="Enter a meaningful button 1 link that summarizes the purpose of this section."></i>
                <input type="text" id="button1Link${pointerCount}" class="form-control mb-2" name="button1Link[]" placeholder="Enter Button 1 Link">
            </div>
            <div class="col-md-6">
                <label for="button2Text${pointerCount}">Button 2 Text</label>
                <i class="fas fa-info-circle" title="Enter a meaningful button 2 text that summarizes the purpose of this section."></i>
                <input type="text" id="button2Text${pointerCount}" class="form-control mb-2" name="button2Text[]" placeholder="Enter Button 2 Text">
            </div>
            <div class="col-md-6">
                <label for="button2Link${pointerCount}">Button 2 Link</label>
                <i class="fas fa-info-circle" title="Enter a meaningful button 2 link that summarizes the purpose of this section."></i>
                <input type="text" id="button2Link${pointerCount}" class="form-control mb-2" name="button2Link[]" placeholder="Enter Button 2 Link">
            </div>
            <div class="col-md-12">
                <label for="image${pointerCount}">Image</label>
                <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                <img id="blah" src="#" alt="Image Preview" style="width: 130px; display:none" />
                <input type="file" id="image${pointerCount}" class="form-control mb-2" name="image[]" accept="image/*">
            </div>
        </div>
        <hr>
        <h5>Add Sub Pointers</h5>
        <div class="sub-pointer-area" data-pointer-id="${pointerCount}">
            <div class="sub-pointer mb-3" data-sub-pointer-id="0">
                <div class="row">
                    <div class="col-md-6">
                        <label for="pointerSubTitle${pointerCount}_0">Pointer Sub Title</label>
                        <i class="fas fa-info-circle" title="Enter a meaningful pointer sub title that summarizes the purpose of this section."></i>
                        <input type="text" id="pointerSubTitle${pointerCount}_0" class="form-control mb-2" name="pointerSubTitle[${pointerCount}][]" placeholder="Enter pointer sub title">
                    </div>
                    <div class="col-md-6">
                        <label for="pointerSubDescription${pointerCount}_0">Pointer Sub Description</label>
                        <i class="fas fa-info-circle" title="Enter a meaningful pointer sub description that summarizes the purpose of this section."></i>
                        <textarea id="pointerSubDescription${pointerCount}_0" class="form-control mb-2" name="pointerSubDescription[${pointerCount}][]" placeholder="Enter pointer sub description"></textarea>
                    </div>
                </div>
                <button type="button" class="btn btn-danger btn-sm remove-sub-pointer">Remove Sub Pointer</button>
            </div>
        </div>
        <button type="button" class="btn btn-success add-sub-pointer">Add Sub Pointer</button>
        <button type="button" class="btn btn-danger btn-sm remove-pointer">Remove Pointer</button>
    `;

        // Append the new pointer field to the container
        document.getElementById('pointerFields').appendChild(newDiv);

        // Recheck lengths after adding a pointer
        checkLengths();
    });

    // Event delegation for remove/add sub-pointers and pointers
    document.getElementById('pointerFields').addEventListener('click', function(e) {
        // Remove Pointer
        if (e.target.classList.contains('remove-pointer')) {
            let pointerField = e.target.closest('.pointer-field');
            pointerField.remove();
            checkLengths();
        }

        // Remove Sub Pointer
        if (e.target.classList.contains('remove-sub-pointer')) {
            let subPointer = e.target.closest('.sub-pointer');
            subPointer.remove();
            checkLengths();
        }

        // Add Sub Pointer
        if (e.target.classList.contains('add-sub-pointer')) {
            let pointerField = e.target.closest('.pointer-field');
            let subPointerCount = pointerField.querySelectorAll('.sub-pointer').length;
            let subPointer = document.createElement('div');
            subPointer.classList.add('sub-pointer', 'mb-3');
            subPointer.setAttribute('data-sub-pointer-id', subPointerCount);
            subPointer.innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <label for="pointerSubTitle${pointerField.getAttribute('data-pointer-id')}_${subPointerCount}" class="form-label">Sub Pointer Title</label>
                    <i class="fas fa-info-circle" title="Enter a meaningful pointer sub title that summarizes the purpose of this section."></i>
                    <input type="text" class="form-control mb-2" name="pointerSubTitle[${pointerField.getAttribute('data-pointer-id')}][${subPointerCount}]" id="pointerSubTitle${pointerField.getAttribute('data-pointer-id')}_${subPointerCount}" placeholder="Enter pointer sub title">
                </div>
                <div class="col-md-6">
                    <label for="pointerSubDescription${pointerField.getAttribute('data-pointer-id')}_${subPointerCount}" class="form-label">Sub Pointer Description</label>
                    <i class="fas fa-info-circle" title="Enter a meaningful pointer sub description that summarizes the purpose of this section."></i>
                    <textarea class="form-control mb-2" name="pointerSubDescription[${pointerField.getAttribute('data-pointer-id')}][${subPointerCount}]" id="pointerSubDescription${pointerField.getAttribute('data-pointer-id')}_${subPointerCount}" placeholder="Enter pointer sub description"></textarea>
                </div>
            </div>
            <button type="button" class="btn btn-danger btn-sm remove-sub-pointer">Remove Sub Pointer</button>
        `;
            pointerField.querySelector('.sub-pointer-area').appendChild(subPointer);

            // Recheck lengths after adding a sub-pointer
            checkLengths();
        }
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
</script> -->

<script>
    // Initialize CKEditor
    CKEDITOR.replace('description');

    // Function to check lengths
    function checkLengths() {
        const removePointerLength = document.querySelectorAll('.remove-pointer').length;
        const removeSubPointerLength = document.querySelectorAll('.remove-sub-pointer').length;

        console.log(`Remove Pointer Buttons: ${removePointerLength}`);
        console.log(`Remove Sub Pointer Buttons: ${removeSubPointerLength}`);
    }

    // Run on page load
    document.addEventListener('DOMContentLoaded', function () {
        checkLengths();
    });

    // Add Pointer
    document.getElementById('addPointer').addEventListener('click', function() {
        let pointerCount = document.querySelectorAll('.pointer-field').length;

        // Create a new div for the pointer field
        let newDiv = document.createElement('div');
        newDiv.classList.add('pointer-field', 'mb-3');
        newDiv.setAttribute('data-pointer-id', pointerCount);

        // Set the innerHTML for the pointer field with labels
        newDiv.innerHTML = `
        <div class="row">
            <div class="col-md-6">
                <label for="pointerTitle${pointerCount}">Pointer Title</label>
                <i class="fas fa-info-circle" title="Enter a meaningful pointer title that summarizes the purpose of this section."></i>
                <input type="text" id="pointerTitle${pointerCount}" class="form-control mb-2" name="pointerTitle[]" placeholder="Enter pointer title" required>
            </div>
            <div class="col-md-6">
                <label for="pointerDescription${pointerCount}">Pointer Description</label>
                <i class="fas fa-info-circle" title="Enter a meaningful pointer description that summarizes the purpose of this section."></i>
                <input type="text" id="pointerDescription${pointerCount}" class="form-control mb-2" name="pointerDescription[]" placeholder="Enter pointer description" required>
            </div>
            <div class="col-md-6">
                <label for="button1Text${pointerCount}">Button 1 Text</label>
                <i class="fas fa-info-circle" title="Enter a meaningful button 1 text that summarizes the purpose of this section."></i>
                <input type="text" id="button1Text${pointerCount}" class="form-control mb-2" name="button1Text[]" placeholder="Enter Button 1 Text" >
            </div>
            <div class="col-md-6">
                <label for="button1Link${pointerCount}">Button 1 Link</label>
                <i class="fas fa-info-circle" title="Enter a meaningful button 1 link that summarizes the purpose of this section."></i>
                <input type="text" id="button1Link${pointerCount}" class="form-control mb-2" name="button1Link[]" placeholder="Enter Button 1 Link" >
            </div>
            <div class="col-md-6">
                <label for="button2Text${pointerCount}">Button 2 Text</label>
                <i class="fas fa-info-circle" title="Enter a meaningful button 2 text that summarizes the purpose of this section."></i>
                <input type="text" id="button2Text${pointerCount}" class="form-control mb-2" name="button2Text[]" placeholder="Enter Button 2 Text" >
            </div>
            <div class="col-md-6">
                <label for="button2Link${pointerCount}">Button 2 Link</label>
                <i class="fas fa-info-circle" title="Enter a meaningful button 2 link that summarizes the purpose of this section."></i>
                <input type="text" id="button2Link${pointerCount}" class="form-control mb-2" name="button2Link[]" placeholder="Enter Button 2 Link" >
            </div>
            <div class="col-md-12">
                <label for="image${pointerCount}">Image</label>
                <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                <img id="blah" src="#" alt="Image Preview" style="width: 130px; display:none" />
                <input type="file" id="image${pointerCount}" class="form-control mb-2" name="image[]" accept="image/*" required>
            </div>
        </div>
        <hr>
        <h5>Add Sub Pointers</h5>
        <div class="sub-pointer-area" data-pointer-id="${pointerCount}">
            <div class="sub-pointer mb-3" data-sub-pointer-id="0">
                <div class="row">
                    <div class="col-md-6">
                        <label for="pointerSubTitle${pointerCount}_0">Pointer Sub Title</label>
                        <i class="fas fa-info-circle" title="Enter a meaningful pointer sub title that summarizes the purpose of this section."></i>
                        <input type="text" id="pointerSubTitle${pointerCount}_0" class="form-control mb-2" name="pointerSubTitle[${pointerCount}][]" placeholder="Enter pointer sub title" required>
                    </div>
                    <div class="col-md-6">
                        <label for="pointerSubDescription${pointerCount}_0">Pointer Sub Description</label>
                        <i class="fas fa-info-circle" title="Enter a meaningful pointer sub description that summarizes the purpose of this section."></i>
                        <textarea id="pointerSubDescription${pointerCount}_0" class="form-control mb-2" name="pointerSubDescription[${pointerCount}][]" placeholder="Enter pointer sub description" required></textarea>
                    </div>
                </div>
                <button type="button" class="btn btn-danger btn-sm remove-sub-pointer">Remove Sub Pointer</button>
            </div>
        </div>
        <button type="button" class="btn btn-success add-sub-pointer">Add Sub Pointer</button>
        <button type="button" class="btn btn-danger btn-sm remove-pointer">Remove Pointer</button>
    `;

        // Append the new pointer field to the container
        document.getElementById('pointerFields').appendChild(newDiv);

        // Recheck lengths after adding a pointer
        checkLengths();
    });

    // Event delegation for remove/add sub-pointers and pointers
    document.getElementById('pointerFields').addEventListener('click', function(e) {
        // Remove Pointer
        if (e.target.classList.contains('remove-pointer')) {
            let pointerField = e.target.closest('.pointer-field');
            pointerField.remove();
            checkLengths();
        }

        // Remove Sub Pointer
        if (e.target.classList.contains('remove-sub-pointer')) {
            let subPointer = e.target.closest('.sub-pointer');
            subPointer.remove();
            checkLengths();
        }

        // Add Sub Pointer
        if (e.target.classList.contains('add-sub-pointer')) {
            let pointerField = e.target.closest('.pointer-field');
            let subPointerCount = pointerField.querySelectorAll('.sub-pointer').length;
            let subPointer = document.createElement('div');
            subPointer.classList.add('sub-pointer', 'mb-3');
            subPointer.setAttribute('data-sub-pointer-id', subPointerCount);
            subPointer.innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <label for="pointerSubTitle${pointerField.getAttribute('data-pointer-id')}_${subPointerCount}" class="form-label">Sub Pointer Title</label>
                    <i class="fas fa-info-circle" title="Enter a meaningful pointer sub title that summarizes the purpose of this section."></i>
                    <input type="text" class="form-control mb-2" name="pointerSubTitle[${pointerField.getAttribute('data-pointer-id')}][${subPointerCount}]" id="pointerSubTitle${pointerField.getAttribute('data-pointer-id')}_${subPointerCount}" placeholder="Enter pointer sub title" required>
                </div>
                <div class="col-md-6">
                    <label for="pointerSubDescription${pointerField.getAttribute('data-pointer-id')}_${subPointerCount}" class="form-label">Sub Pointer Description</label>
                    <i class="fas fa-info-circle" title="Enter a meaningful pointer sub description that summarizes the purpose of this section."></i>
                    <textarea class="form-control mb-2" name="pointerSubDescription[${pointerField.getAttribute('data-pointer-id')}][${subPointerCount}]" id="pointerSubDescription${pointerField.getAttribute('data-pointer-id')}_${subPointerCount}" placeholder="Enter pointer sub description" required></textarea>
                </div>
            </div>
            <button type="button" class="btn btn-danger btn-sm remove-sub-pointer">Remove Sub Pointer</button>
        `;
            pointerField.querySelector('.sub-pointer-area').appendChild(subPointer);

            // Recheck lengths after adding a sub-pointer
            checkLengths();
        }
    });

    // Image file change event
    document.getElementById('pointerFields').addEventListener('change', function(e) {
        if (e.target.type === 'file') {
            const imgInp = e.target;
            const blah = imgInp.closest('.pointer-field').querySelector('img');
            const [file] = imgInp.files;
            if (file) {
                blah.src = URL.createObjectURL(file);
                blah.style.display = "block"; // Show the image
            } else {
                blah.style.display = "none"; // Hide the image if no file is selected
                blah.src = "#"; // Reset the src
            }
        }
    });

    // Form submission validation
    document.getElementById('yourForm').addEventListener('submit', function(e) {
        let isValid = true;

        // Validate required inputs
        const requiredFields = document.querySelectorAll('[required]');
        requiredFields.forEach(function(field) {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        // Prevent form submission if validation fails
        if (!isValid) {
            e.preventDefault();
            alert('Please fill all required fields.');
        }
    });
</script>

@endsection