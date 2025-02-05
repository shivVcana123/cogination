@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Footer Data</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('footer') }}">Footer</a></li>
                        <li class="breadcrumb-item active">Add Footer</li>
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
                        <div class="card-header" style="background-color:#0377ce">
                            <h3 class="card-title">Add Footer</h3>
                        </div>

                        <form action="{{ route('save-footer') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" class="form-control" name="id" id="id" value="{{$footerData[0]->id ?? ''}}" placeholder="Enter title1">

                            <div class="card-body">
                                <div class="row">

                                    <div class="form-group col-md-6">
                                        <label for="phone_no">Email</label><i class="fas fa-info-circle" title="Enter a rmail for Footer Section ."></i>
                                        <input type="email" class="form-control" name="email" id="email" value="{{$footerData[0]->email ?? ''}}" required>
                                        @error('email')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="phone_no">Contact Info</label><i class="fas fa-info-circle" title="Enter a Phone number for Footer Section ."></i>
                                        <input type="phone" class="form-control" name="phone_no" value="{{$footerData[0]->phone_no ?? ''}}" id="phone_no" required>
                                        @error('phone_no')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="link">Address</label><i class="fas fa-info-circle" title="Enter a Address for Footer Section ."></i>
                                        <input type="text" class="form-control" name="address" id="address" value="{{$footerData[0]->address ?? ''}}" placeholder="Enter Address" required>
                                        @error('address')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="timing">Timing</label><i class="fas fa-info-circle" title="Enter the working hours for Footer Section."></i>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input
                                                    type="time"
                                                    class="form-control"
                                                    name="start_time"
                                                    id="start_time"
                                                    title="Start Time"
                                                    placeholder="Start Time"
                                                    value="{{$footerData[0]->start_time ?? ''}}">
                                            </div>
                                            <div class="col-md-4">
                                                <input
                                                    type="time"
                                                    class="form-control"
                                                    name="end_time"
                                                    id="end_time"
                                                    title="End Time"
                                                    placeholder="End Time"
                                                    value="{{$footerData[0]->end_time ?? ''}}">
                                            </div>
                                            <div class="col-md-4">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="days"
                                                    id="days"
                                                    placeholder="e.g., Mon to Sat"
                                                    title="Enter the days (e.g., Mon to Sat)"
                                                    value="{{$footerData[0]->days ?? ''}}">
                                            </div>
                                        </div>
                                    </div>



                                </div>
                                <hr>
                                <div class="row">

                                    <div class="form-group col-md-12">
                                        <label for="title">Title </label><i class="fas fa-info-circle" title="Enter a first title for Footer Section ."></i>
                                        <input type="text" class="form-control" name="title1" id="title1" value="{{$footerData[0]->title1 ?? ''}}" placeholder="Enter title1" required>
                                        @error('title1')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                                    </div>
                                    <div class="row data-clss">
                                        <div class="col-12">
                                            <label class="selct-data" for="headers">Select Display Data</label>
                                            <i class="fas fa-info-circle" title="Select the values you want to show in the footer."></i>
                                        </div>

                                        @php
                                        // Decode display_data into an array of objects
                                        $footerValue = isset($footerData[0]) && !empty($footerData[0]->display_data)
                                        ? json_decode($footerData[0]->display_data, true)
                                        : [];
                                        @endphp

                                        @foreach ($headers as $header)
                                        @php
                                        // Check if $header->category exists in $footerValue as 'name'
                                        $isChecked = collect($footerValue)->contains('name', $header->category);
                                        @endphp
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input
                                                        type="checkbox"
                                                        class="form-check-input"
                                                        name="dats_display[{{ $header->category }}]"
                                                        id="header_{{ $header->id }}"
                                                        value="{{ $header->link }}"
                                                        {{ $isChecked ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="header_{{ $header->id }}">
                                                        {{ $header->category }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                               
                                <hr>
                                <div class="form-group">
                                    <label for="image">WebSite Logo</label>
                                    <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                    <img id="blah" src="{{asset($footerData[0]->image ?? '')}}" alt="Image Preview" style="width: 130px; display: {{ empty($footerData[0]->image) ? 'none' : 'block' }};" />
                                    <input type="file" class="form-control" name="image" id="imgInp" accept="image/*">
                                    @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <hr>
                                <div class="form-group col-md-12">
                                    <label for="email">Footer Description</label><i class="fas fa-info-circle" title="Enter a description for Footer Section."></i>
                                    <textarea class="form-control" name="description" id="description" placeholder="Enter Text">{{$footerData[0]->description ?? ''}}</textarea>
                                    @error('description')
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
        </div>
    </section>

</div>



@endsection
@section('java_script')
<script>
    CKEDITOR.replace('description');
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

    document.addEventListener("DOMContentLoaded", function() {
        const container = document.querySelector("#link-url-container");
        const addMoreButton = document.querySelector("#add-more-link-url");

        // Add More Button Functionality
        addMoreButton.addEventListener("click", function() {
            const newRow = document.createElement("div");
            newRow.classList.add("link-url-row");
            newRow.innerHTML = `
            <div class="row">
                <input type="text" class="form-control col-md-6 mb-2" name="name[]" placeholder="Enter Link Name">
                <input type="text" class="form-control col-md-6 mb-2" name="link[]" placeholder="Enter URL">
                <button type="button" class="btn btn-danger btn-sm remove-link-url">Remove</button>
            </div>
        `;
            container.appendChild(newRow);

            // Update Remove Button Visibility
            toggleRemoveButtonVisibility();
        });

        // Event Delegation for Remove Buttons
        container.addEventListener("click", function(e) {
            if (e.target && e.target.classList.contains("remove-link-url")) {
                // Remove the closest row
                const rowToRemove = e.target.closest(".link-url-row");
                if (rowToRemove) {
                    rowToRemove.remove();
                }

                // Update Remove Button Visibility
                toggleRemoveButtonVisibility();
            }
        });

        // Function to Toggle Remove Button Visibility
        function toggleRemoveButtonVisibility() {
            const rows = container.querySelectorAll(".link-url-row");
            const showRemoveButton = rows.length > 1;

            rows.forEach(row => {
                const removeButton = row.querySelector(".remove-link-url");
                if (removeButton) {
                    removeButton.style.display = showRemoveButton ? "inline-block" : "none";
                }
            });
        }

        // Initialize Remove Button Visibility on Page Load
        toggleRemoveButtonVisibility();
    });
</script>
@endsection