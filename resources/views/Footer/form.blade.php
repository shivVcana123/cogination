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
                                        <input type="email" class="form-control" name="email" id="email" value="{{$footerData[0]->email ?? ''}}">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="phone_no">Contact Info</label><i class="fas fa-info-circle" title="Enter a Phone number for Footer Section ."></i>
                                        <input type="phone" class="form-control" name="phone_no" value="{{$footerData[0]->phone_no ?? ''}}" id="phone_no">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="link">Address</label><i class="fas fa-info-circle" title="Enter a Address for Footer Section ."></i>
                                        <input type="text" class="form-control" name="address" id="address" value="{{$footerData[0]->address ?? ''}}" placeholder="Enter Address">
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

                                    <div class="form-group col-md-12">
                                        <label for="email">Footer Description</label><i class="fas fa-info-circle" title="Enter a description for Footer Section."></i>
                                        <textarea class="form-control" name="description" id="description" placeholder="Enter Text">{{$footerData[0]->description ?? ''}}</textarea>
                                    </div>

                                </div>
                                <hr>
                                <div class="row">

                                    <div class="form-group col-md-12">
                                        <label for="title">Title 1</label><i class="fas fa-info-circle" title="Enter a first title for Footer Section ."></i>
                                        <input type="text" class="form-control" name="title1" id="title1" value="{{$footerData[0]->title1 ?? ''}}" placeholder="Enter title1">
                                    </div>


                                    <div class="row">
                                        <div class="col-12">
                                            <label for="headers">Select Display Data</label><i class="fas fa-info-circle" title="Select the values you want to show in the footer."></i>
                                        </div>

                                        @php
                                        $footerValue = isset($footerData[0]) && !empty($footerData[0]->display_data)
                                        ? json_decode($footerData[0]->display_data)
                                        : []; // Decode JSON to an array
                                        @endphp

                                        @foreach ($headers as $header)
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <!-- Checkbox Input -->
                                                    <input
                                                        type="checkbox"
                                                        class="form-check-input"
                                                        name="dats_display[]"
                                                        id="header_{{ $header->id }}"
                                                        value="{{ $header->category }}"
                                                        {{ in_array($header->category, $footerValue ?? []) ? 'checked' : '' }}>
                                                    <!-- Label for the Checkbox -->
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
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="title">Title 2</label><i class="fas fa-info-circle" title="Enter a second title for Footer Section."></i>
                                        <input type="text" class="form-control" name="title2" id="title2" value="{{$footerData[0]->title2 ?? ''}}" placeholder="Enter title2">
                                    </div>

                                    @php
    $linkValues = isset($footerData[0]) && !empty($footerData[0]->link)
        ? json_decode($footerData[0]->link)
        : [];
@endphp

<div class="form-group col-md-12">
    <label for="link_name">Link Name</label>
    <div id="link-url-container">
        @if (!empty($linkValues))
            @foreach ($linkValues as $value)
                <div class="link-url-row">
                    <div class="row">
                        <input type="text" class="form-control col-md-6 mb-2" name="name[]" placeholder="Enter Link Name" value="{{ $value->name ?? '' }}">
                        <input type="text" class="form-control col-md-6 mb-2" name="link[]" placeholder="Enter URL" value="{{ $value->link ?? '' }}">
                        <button type="button" class="btn btn-danger btn-sm remove-link-url">Remove</button>
                    </div>
                </div>
            @endforeach
        @else
            <div class="link-url-row">
                <div class="row">
                    <input type="text" class="form-control col-md-6 mb-2" name="name[]" placeholder="Enter Link Name">
                    <input type="text" class="form-control col-md-6 mb-2" name="link[]" placeholder="Enter URL">
                    <button type="button" class="btn btn-danger btn-sm remove-link-url">Remove</button>
                </div>
            </div>
        @endif
    </div>
    <!-- Add More Button outside the container -->
    <button type="button" class="btn btn-success btn-sm mt-2" id="add-more-link-url">Add More</button>
</div>



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



<script>
    // background_image.onchange = evt => {
    //     const [file] = background_image.files;

    //     if (file) {
    //         bg_image.src = URL.createObjectURL(file);
    //         bg_image.style.display = "block"; // Show the image
    //     } else {
    //         bg_image.style.display = "none"; // Hide the image if no file is selected
    //         bg_image.src = "#"; // Reset the src
    //     }
    // };

    document.addEventListener("DOMContentLoaded", function () {
    const container = document.querySelector("#link-url-container");
    const addMoreButton = document.querySelector("#add-more-link-url");

    // Add More Button Functionality
    addMoreButton.addEventListener("click", function () {
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
    container.addEventListener("click", function (e) {
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