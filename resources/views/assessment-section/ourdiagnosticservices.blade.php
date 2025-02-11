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
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" value="{{ old('title', $ourDiagnostic[0]->title ?? '') }}" required>
                                    @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description Field -->
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <i class="fas fa-info-circle" title="Describe the purpose or details of this section in 2-3 sentences."></i>
                                    <textarea class="form-control" name="description" id="description" required>{{ old('description', $ourDiagnostic[0]->description ?? '') }}</textarea>
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
                                    <h5>Card Details</h5>
                                    <div id="pointerFields">
                                        @if(!empty($pointers) && is_array($pointers))
                                        @foreach ($pointers as $index => $details)
 @if (count($pointers) > 1 && $index > 0)
                                    <hr>
                                    @endif
                                        <div class="pointer-field mb-3" data-pointer-id="{{ $index }}">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="pointerTitle{{ $index }}"> Title</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful pointer title that summarizes the purpose of this section."></i>
                                                    <input type="text" id="pointerTitle{{ $index }}" class="form-control mb-2" name="pointerTitle[]" placeholder="Enter title" value="{{ $details->pointerTitle }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="pointerDescription{{ $index }}"> Description</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful pointer description that summarizes the purpose of this section."> </i>
                                                    <input type="text" id="pointerDescription{{ $index }}" class="form-control mb-2" name="pointerDescription[]" placeholder="Enter description" value="{{ $details->pointerDescription }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="button1Text{{ $index }}">Button Text</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful Button text of this section."></i> <label class="option-area">(Optional)</label>
                                                    <input type="text" id="button1Text{{ $index }}" class="form-control mb-2" name="button1Text[]" placeholder="Enter Button Text" value="{{ $details->button1Text }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="button1Link{{ $index }}">Button Link</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful Button link of this section."></i> <label class="option-area">(Optional)</label>
                                                    <input type="text" id="button1Link{{ $index }}" class="form-control mb-2" name="button1Link[]" placeholder="Enter Button Link" value="{{ $details->button1Link }}">
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="image{{ $index }}">Image</label>
                                                    <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                                    <img id="blah" src="{{asset($details->sub_image)}}" alt="Image Preview" style="width: 130px; display:{{empty($details->sub_image) ? 'none' : 'block'}}" />
                                                    <input type="file" id="image{{ $index }}" class="form-control mb-2" name="image[]" accept="image/*">
                                                </div>
                                            </div>
                                            <br>
                                            <h5>Add Sub Card</h5>
                                            <div class="sub-pointer-area" data-pointer-id="{{ $index }}">
                                                @foreach ($details->sub_pointer as $subIndex => $subPointer)
                                                <div class="sub-pointer mb-3" data-sub-pointer-id="{{ $subIndex }}">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="pointerSubTitle{{ $index }}_{{ $subIndex }}"> Title</label>
                                                            <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                                            <input type="text" id="pointerSubTitle{{ $index }}_{{ $subIndex }}" class="form-control mb-2" name="pointerSubTitle[{{ $index }}][{{ $subIndex }}]" placeholder="Enter  title" value="{{ $subPointer->pointerSubTitle1 ?? '' }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="pointerSubDescription{{ $index }}_{{ $subIndex }}"> Description</label>
                                                            <i class="fas fa-info-circle" title="Enter a meaningful description that summarizes the purpose of this section."></i>
                                                            <textarea id="pointerSubDescription{{ $index }}_{{ $subIndex }}" class="form-control mb-2" name="pointerSubDescription[{{ $index }}][{{ $subIndex }}]" placeholder="Enter description" required>{{ $subPointer->pointerSubDescription1 ?? '' }}</textarea>
                                                        </div>
                                                        <button type="button" class="btn btn-danger remove-sub-pointer">Remove Sub Card</button>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <button type="button" class="btn btn-success add-sub-pointer">Add Sub Card</button>
                                                <button type="button" class="btn btn-danger remove-pointer">Remove Card</button>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <!-- Empty Pointer Fields -->
                                        <div class="pointer-field mb-3" data-pointer-id="0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="pointerTitle0"> Title</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                                    <input type="text" id="pointerTitle0" class="form-control mb-2" name="pointerTitle[]" placeholder="Enter title" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="pointerDescription0"> Description</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful description that summarizes the purpose of this section."></i>
                                                    <input type="text" id="pointerDescription0" class="form-control mb-2" name="pointerDescription[]" placeholder="Enter description" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="button1Text0">Button Text</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful Button text that summarizes the purpose of this section."></i> <label class="option-area">(Optional)</label>
                                                    <input type="text" id="button1Text0" class="form-control mb-2" name="button1Text[]" placeholder="Enter Button Text">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="button1Link0">Button Link</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful Button link that summarizes the purpose of this section."></i> <label class="option-area">(Optional)</label>
                                                    <input type="text" id="button1Link0" class="form-control mb-2" name="button1Link[]" placeholder="Enter Button Link">
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="image0">Image</label>
                                                    <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                                    <img id="blah" src="#" alt="Image Preview" style="width: 130px; display:none" />
                                                    <input type="file" id="image0" class="form-control mb-2" name="image[]" accept="image/*">
                                                </div>
                                            </div>

                                            <h5>Add Sub Card</h5>
                                            <div class="sub-pointer-area ">
                                                <div class="sub-pointer mb-3 " data-sub-pointer-id="0">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="pointerSubTitle0_0"> Title</label>
                                                            <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                                            <input type="text" id="pointerSubTitle0_0" class="form-control mb-2" name="pointerSubTitle[0][]" placeholder="Enter title" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="pointerSubDescription0_0"> Description</label>
                                                            <i class="fas fa-info-circle" title="Enter a meaningful description that summarizes the purpose of this section."></i>
                                                            <textarea id="pointerSubDescription0_0" class="form-control mb-2" name="pointerSubDescription[0][]" placeholder="Enter description" required></textarea>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-danger remove-sub-pointer">Remove Sub Card</button>
                                                </div>
                                            </div>
                                            <!-- <button type="button" class="btn btn-success add-sub-pointer">Add Sub Card</button>
                                            <button type="button" class="btn btn-danger remove-pointer">Remove Card</button> -->

                                            <div class="d-flex justify-content-between">
                                                <button type="button" class="btn btn-success add-sub-pointer">Add Sub Card</button>
                                                <button type="button" class="btn btn-danger remove-pointer">Remove Card</button>
                                            </div>

                                        </div>
                                        @endif
                                    </div>

                                    <button type="button" id="addPointer" class="btn btn-success">Add Card</button>
                                </div>
                            </div>

                            <div class="card-footer">
                                <input type="checkbox" id="status" name="status" {{ ($ourDiagnostic[0]->status ?? '') === 'on' ? 'checked' : '' }}>
                                <label for="status">Show On Website</label>
                                <button type="submit" class="btn btn-primary">Save</button>
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
    document.addEventListener('DOMContentLoaded', function() {
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
        newDiv.innerHTML = `<hr>
        <div class="row">
            <div class="col-md-6">
                <label for="pointerTitle${pointerCount}"> Title</label>
                <i class="fas fa-info-circle" title="Enter a meaningful  title that summarizes the purpose of this section."></i>
                <input type="text" id="pointerTitle${pointerCount}" class="form-control mb-2" name="pointerTitle[]" placeholder="Enter  title" required>
            </div>
            <div class="col-md-6">
                <label for="pointerDescription${pointerCount}"> Description</label>
                <i class="fas fa-info-circle" title="Enter a meaningful description that summarizes the purpose of this section."></i>
                <input type="text" id="pointerDescription${pointerCount}" class="form-control mb-2" name="pointerDescription[]" placeholder="Enter description" required>
            </div>
            <div class="col-md-6">
                <label for="button1Text${pointerCount}">Button Text</label>
                <i class="fas fa-info-circle" title="Enter a meaningful Button text that summarizes the purpose of this section."></i> <label class="option-area">(Optional)</label>
                <input type="text" id="button1Text${pointerCount}" class="form-control mb-2" name="button1Text[]" placeholder="Enter Button Text" >
            </div>
            <div class="col-md-6">
                <label for="button1Link${pointerCount}">Button Link</label>
                <i class="fas fa-info-circle" title="Enter a meaningful Button link that summarizes the purpose of this section."></i> <label class="option-area">(Optional)</label>
                <input type="text" id="button1Link${pointerCount}" class="form-control mb-2" name="button1Link[]" placeholder="Enter Button Link" >
            </div>
           
            <div class="col-md-12">
                <label for="image${pointerCount}">Image</label>
                <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                <img id="blah" src="#" alt="Image Preview" style="width: 130px; display:none" />
                <input type="file" id="image${pointerCount}" class="form-control mb-2" name="image[]" accept="image/*">
            </div>
        </div><br>
   
        <h5>Add Sub Card</h5>
        <div class="sub-pointer-area" data-pointer-id="${pointerCount}">
            <div class="sub-pointer mb-3" data-sub-pointer-id="0">
                <div class="row">
                    <div class="col-md-6">
                        <label for="pointerSubTitle${pointerCount}_0"> Title</label>
                        <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                        <input type="text" id="pointerSubTitle${pointerCount}_0" class="form-control mb-2" name="pointerSubTitle[${pointerCount}][]" placeholder="Enter pointer sub title" required>
                    </div>
                    <div class="col-md-6">
                        <label for="pointerSubDescription${pointerCount}_0"> Description</label>
                        <i class="fas fa-info-circle" title="Enter a meaningful description that summarizes the purpose of this section."></i>
                        <textarea id="pointerSubDescription${pointerCount}_0" class="form-control mb-2" name="pointerSubDescription[${pointerCount}][]" placeholder="Enter description" required></textarea>
                    </div>
                </div>
                <button type="button" class="btn btn-danger remove-sub-pointer">Remove Sub Card</button>
            </div>
        </div>
     

          <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-success add-sub-pointer">Add Sub Card</button>
                <button type="button" class="btn btn-danger remove-pointer">Remove Card</button>
            </div>
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
                    <label for="pointerSubTitle${pointerField.getAttribute('data-pointer-id')}_${subPointerCount}" class="form-label"> Title</label>
                    <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                    <input type="text" class="form-control mb-2" name="pointerSubTitle[${pointerField.getAttribute('data-pointer-id')}][${subPointerCount}]" id="pointerSubTitle${pointerField.getAttribute('data-pointer-id')}_${subPointerCount}" placeholder="Enter title" required>
                </div>
                <div class="col-md-6">
                    <label for="pointerSubDescription${pointerField.getAttribute('data-pointer-id')}_${subPointerCount}" class="form-label"> Description</label>
                    <i class="fas fa-info-circle" title="Enter a meaningful description that summarizes the purpose of this section."></i>
                    <textarea class="form-control mb-2" name="pointerSubDescription[${pointerField.getAttribute('data-pointer-id')}][${subPointerCount}]" id="pointerSubDescription${pointerField.getAttribute('data-pointer-id')}_${subPointerCount}" placeholder="Enter description" required></textarea>
                </div>
            </div>
            <button type="button" class="btn btn-danger remove-sub-pointer">Remove Sub Card</button>
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
</script>

@endsection