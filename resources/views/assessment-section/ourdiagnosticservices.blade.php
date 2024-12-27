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
                                                    <input type="text" id="pointerTitle{{ $index }}" class="form-control mb-2" name="pointerTitle[]" placeholder="Enter pointer title" value="{{ $details->pointerTitle }}">

                                                    <label for="pointerDescription{{ $index }}">Pointer Description</label>
                                                    <input type="text" id="pointerDescription{{ $index }}" class="form-control mb-2" name="pointerDescription[]" placeholder="Enter pointer description" value="{{ $details->pointerDescription }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="button1Text{{ $index }}">Button 1 Text</label>
                                                    <input type="text" id="button1Text{{ $index }}" class="form-control mb-2" name="button1Text[]" placeholder="Enter Button 1 Text" value="{{ $details->button1Text }}">

                                                    <label for="button1Link{{ $index }}">Button 1 Link</label>
                                                    <input type="text" id="button1Link{{ $index }}" class="form-control mb-2" name="button1Link[]" placeholder="Enter Button 1 Link" value="{{ $details->button1Link }}">

                                                    <label for="button2Text{{ $index }}">Button 2 Text</label>
                                                    <input type="text" id="button2Text{{ $index }}" class="form-control mb-2" name="button2Text[]" placeholder="Enter Button 2 Text" value="{{ $details->button2Text }}">

                                                    <label for="button2Link{{ $index }}">Button 2 Link</label>
                                                    <input type="text" id="button2Link{{ $index }}" class="form-control mb-2" name="button2Link[]" placeholder="Enter Button 2 Link" value="{{ $details->button2Link }}">

                                                    <label for="image{{ $index }}">Upload Image</label>
                                                    <input type="file" id="image{{ $index }}" class="form-control mb-2" name="image[]" accept="image/*">

                                                    <div class="sub-pointer-area">
                                                        @foreach ($details->sub_pointer as $subIndex => $subPointer)
                                                        <div class="sub-pointer mb-3" data-sub-pointer-id="{{ $subIndex }}">
                                                            <label for="pointerSubTitle{{ $index }}_{{ $subIndex }}">Pointer Sub Title</label>
                                                            <input type="text" id="pointerSubTitle{{ $index }}_{{ $subIndex }}" class="form-control mb-2" name="pointerSubTitle[{{ $index }}][{{ $subIndex }}]" placeholder="Enter pointer sub title" value="{{ $subPointer->pointerSubTitle1 ?? '' }}">

                                                            <label for="pointerSubDescription{{ $index }}_{{ $subIndex }}">Pointer Sub Description</label>
                                                            <textarea id="pointerSubDescription{{ $index }}_{{ $subIndex }}" class="form-control mb-2" name="pointerSubDescription[{{ $index }}][{{ $subIndex }}]" placeholder="Enter pointer sub description">{{ $subPointer->pointerSubDescription1 ?? '' }}</textarea>

                                                            <button type="button" class="btn btn-danger btn-sm remove-sub-pointer">Remove Sub Pointer</button>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    <button type="button" class="btn btn-success add-sub-pointer">Add Sub Pointer</button>
                                                </div>
                                                <button type="button" class="btn btn-danger btn-sm remove-pointer">Remove Pointer</button>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <!-- Empty Pointer Fields -->
                                        <div class="pointer-field mb-3" data-pointer-id="0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="pointerTitle0">Pointer Title</label>
                                                    <input type="text" id="pointerTitle0" class="form-control mb-2" name="pointerTitle[]" placeholder="Enter pointer title">

                                                    <label for="pointerDescription0">Pointer Description</label>
                                                    <input type="text" id="pointerDescription0" class="form-control mb-2" name="pointerDescription[]" placeholder="Enter pointer description">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="button1Text0">Button 1 Text</label>
                                                    <input type="text" id="button1Text0" class="form-control mb-2" name="button1Text[]" placeholder="Enter Button 1 Text">

                                                    <label for="button1Link0">Button 1 Link</label>
                                                    <input type="text" id="button1Link0" class="form-control mb-2" name="button1Link[]" placeholder="Enter Button 1 Link">

                                                    <label for="button2Text0">Button 2 Text</label>
                                                    <input type="text" id="button2Text0" class="form-control mb-2" name="button2Text[]" placeholder="Enter Button 2 Text">

                                                    <label for="button2Link0">Button 2 Link</label>
                                                    <input type="text" id="button2Link0" class="form-control mb-2" name="button2Link[]" placeholder="Enter Button 2 Link">

                                                    <label for="image0">Upload Image</label>
                                                    <input type="file" id="image0" class="form-control mb-2" name="image[]" accept="image/*">

                                                    <div class="sub-pointer-area">
                                                        <div class="sub-pointer mb-3" data-sub-pointer-id="0">
                                                            <label for="pointerSubTitle0_0">Pointer Sub Title</label>
                                                            <input type="text" id="pointerSubTitle0_0" class="form-control mb-2" name="pointerSubTitle[0][]" placeholder="Enter pointer sub title">

                                                            <label for="pointerSubDescription0_0">Pointer Sub Description</label>
                                                            <textarea id="pointerSubDescription0_0" class="form-control mb-2" name="pointerSubDescription[0][]" placeholder="Enter pointer sub description"></textarea>

                                                            <button type="button" class="btn btn-danger btn-sm remove-sub-pointer">Remove Sub Pointer</button>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-success add-sub-pointer">Add Sub Pointer</button>
                                                </div>
                                                <button type="button" class="btn btn-danger btn-sm remove-pointer">Remove Pointer</button>
                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                    <button type="button" id="addPointer" class="btn btn-success">Add Pointer</button>
                                </div>
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
                <label for="pointerTitle${pointerCount}" class="form-label">Pointer Title</label>
                <input type="text" class="form-control mb-2" name="pointerTitle[]" id="pointerTitle${pointerCount}" placeholder="Enter pointer title" required>

                <label for="pointerDescription${pointerCount}" class="form-label">Pointer Description</label>
                <input type="text" class="form-control mb-2" name="pointerDescription[]" id="pointerDescription${pointerCount}" placeholder="Enter pointer description" required>
            </div>
            <div class="col-md-6">
                <label for="button1Text${pointerCount}" class="form-label">Button 1 Text</label>
                <input type="text" class="form-control mb-2" name="button1Text[]" id="button1Text${pointerCount}" placeholder="Enter Button 1 Text" required>

                <label for="button1Link${pointerCount}" class="form-label">Button 1 Link</label>
                <input type="text" class="form-control mb-2" name="button1Link[]" id="button1Link${pointerCount}" placeholder="Enter Button 1 Link" required>

                <label for="button2Text${pointerCount}" class="form-label">Button 2 Text</label>
                <input type="text" class="form-control mb-2" name="button2Text[]" id="button2Text${pointerCount}" placeholder="Enter Button 2 Text" required>

                <label for="button2Link${pointerCount}" class="form-label">Button 2 Link</label>
                <input type="text" class="form-control mb-2" name="button2Link[]" id="button2Link${pointerCount}" placeholder="Enter Button 2 Link" required>

                <label for="image${pointerCount}" class="form-label">Image</label>
                <input type="file" class="form-control mb-2" name="image[]" id="image${pointerCount}" accept="image/*">

                <div class="sub-pointer-area">
                    <div class="sub-pointer mb-3" data-sub-pointer-id="0">
                        <label for="pointerSubTitle${pointerCount}_0" class="form-label">Sub Pointer Title</label>
                        <input type="text" class="form-control mb-2" name="pointerSubTitle[${pointerCount}][]" id="pointerSubTitle${pointerCount}_0" placeholder="Enter pointer sub title">

                        <label for="pointerSubDescription${pointerCount}_0" class="form-label">Sub Pointer Description</label>
                        <textarea class="form-control mb-2" name="pointerSubDescription[${pointerCount}][]" id="pointerSubDescription${pointerCount}_0" placeholder="Enter pointer sub description"></textarea>
                        
                        <button type="button" class="btn btn-danger btn-sm remove-sub-pointer">Remove Sub Pointer</button>
                    </div>
                </div>
                <button type="button" class="btn btn-success add-sub-pointer">Add Sub Pointer</button>
            </div>
            <button type="button" class="btn btn-danger btn-sm remove-pointer">Remove Pointer</button>
        </div>
    `;

        // Append the new pointer field to the container
        document.getElementById('pointerFields').appendChild(newDiv);
    });

    // Event delegation for remove/add sub-pointers and pointers
    document.getElementById('pointerFields').addEventListener('click', function(e) {
        // Remove Pointer
        if (e.target.classList.contains('remove-pointer')) {
            e.target.closest('.pointer-field').remove();
        }

        // Remove Sub Pointer
        if (e.target.classList.contains('remove-sub-pointer')) {
            e.target.closest('.sub-pointer').remove();
        }

        // Add Sub Pointer
        if (e.target.classList.contains('add-sub-pointer')) {
            let pointerField = e.target.closest('.pointer-field');
            let subPointerCount = pointerField.querySelectorAll('.sub-pointer').length;
            let subPointer = document.createElement('div');
            subPointer.classList.add('sub-pointer', 'mb-3');
            subPointer.setAttribute('data-sub-pointer-id', subPointerCount);
            subPointer.innerHTML = `
            <label for="pointerSubTitle${pointerField.getAttribute('data-pointer-id')}_${subPointerCount}" class="form-label">Sub Pointer Title</label>
            <input type="text" class="form-control mb-2" name="pointerSubTitle[${pointerField.getAttribute('data-pointer-id')}][${subPointerCount}]" id="pointerSubTitle${pointerField.getAttribute('data-pointer-id')}_${subPointerCount}" placeholder="Enter pointer sub title">

            <label for="pointerSubDescription${pointerField.getAttribute('data-pointer-id')}_${subPointerCount}" class="form-label">Sub Pointer Description</label>
            <textarea class="form-control mb-2" name="pointerSubDescription[${pointerField.getAttribute('data-pointer-id')}][${subPointerCount}]" id="pointerSubDescription${pointerField.getAttribute('data-pointer-id')}_${subPointerCount}" placeholder="Enter pointer sub description"></textarea>
            
            <button type="button" class="btn btn-danger btn-sm remove-sub-pointer">Remove Sub Pointer</button>
        `;
            pointerField.querySelector('.sub-pointer-area').appendChild(subPointer);
        }
    });
</script>


@endsection