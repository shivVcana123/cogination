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
                        <li class="breadcrumb-item"><a href="{{ route('footer.index') }}">Footer</a></li>
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
                        <form action="{{ route('footer.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Title 1</label><i class="fas fa-info-circle" title="Enter a first title for Footer Section ."></i>
                                    <input type="text" class="form-control" name="title1" id="title1" placeholder="Enter title1">
                                </div>

                                 <div class="form-group">
                                    <label for="title">Title 2</label><i class="fas fa-info-circle" title="Enter a second title for Footer Section ."></i>
                                    <input type="text" class="form-control" name="title2" id="title2" placeholder="Enter title2">
                                </div>

                                <div class="form-group">
                                    <label for="link">Address</label><i class="fas fa-info-circle" title="Enter a Address for Footer Section ."></i>
                                    <input type="text" class="form-control" name="address" id="address" placeholder="Enter Address">
                                </div>
                                <div class="form-group">
                                    <label for="email">Fooetr Description</label><i class="fas fa-info-circle" title="Enter a description for Footer Section ."></i>
                                    <textarea class="form-control" name="description" id="description" placeholder="Enter Text" ></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="phone_no">Contact Info</label><i class="fas fa-info-circle" title="Enter a Phone number for Footer Section ."></i>
                                    <input type="phone" class="form-control" name="phone_no" id="phone_no">
                                </div>

                                 <div class="form-group">
                                    <label for="phone_no">Email</label><i class="fas fa-info-circle" title="Enter a rmail for Footer Section ."></i>
                                    <input type="email" class="form-control" name="email" id="email">
                                </div>

                              <div class="row">
                                <div class="col-12">
                                        <label for="headers">Select Display Data</label><i class="fas fa-info-circle" title="Select the values you want to show in the footer."></i>
                                    </div>
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
                                                >
                                                <!-- Label for the Checkbox -->
                                                <label class="form-check-label" for="header_{{ $header->id }}">
                                                    {{ $header->category }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                                {{-- <div class="form-group">
                                    <label for="background_color">Link Name</label>
                                    <input type="text" class="form-control" name="link" id="link">
                                </div>
                                <div class="form-group">
                                    <label for="background_color">Url</label>
                                    <input type="text" class="form-control" name="url" id="url">
                                </div> --}}

                                {{-- <div class="form-group">
                                    <label for="link_name">Link Name</label>
                                    <div id="link-url-container">
                                        <!-- Default Input Fields -->
                                        <div class="link-url-row">
                                            <input type="text" class="form-control mb-2" name="links[0][name]" placeholder="Enter Link Name">
                                            <input type="text" class="form-control mb-2" name="links[0][url]" placeholder="Enter URL">
                                            <button type="button" class="btn btn-danger btn-sm remove-link-url" style="display: none;">Remove</button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-success btn-sm add_more" id="add-more-link-url">Add More</button>
                                </div> --}}
                                <div class="form-group">
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
                                            >
                                        </div>
                                        <div class="col-md-4">
                                            <input 
                                                type="time" 
                                                class="form-control" 
                                                name="end_time" 
                                                id="end_time" 
                                                title="End Time" 
                                                placeholder="End Time"
                                            >
                                        </div>
                                        <div class="col-md-4">
                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                name="days" 
                                                id="days" 
                                                placeholder="e.g., Mon to Sat" 
                                                title="Enter the days (e.g., Mon to Sat)"
                                            >
                                        </div>
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
 background_image.onchange = evt => {
        const [file] = background_image.files;

        if (file) {
            bg_image.src = URL.createObjectURL(file);
            bg_image.style.display = "block"; // Show the image
        } else {
            bg_image.style.display = "none"; // Hide the image if no file is selected
            bg_image.src = "#"; // Reset the src
        }
    };

  document.addEventListener("DOMContentLoaded", function () {
        let counter = 1; // Counter for input naming

        // Add More Button Functionality
        document.querySelector("#add-more-link-url").addEventListener("click", function () {

            const container = document.querySelector("#link-url-container");
            const newRow = document.createElement("div");
            newRow.classList.add("link-url-row");
            newRow.innerHTML = `
                <input type="text" class="form-control mb-2" name="links[${counter}][name]" placeholder="Enter Link Name">
                <input type="text" class="form-control mb-2" name="links[${counter}][url]" placeholder="Enter URL">
                <button type="button" class="btn btn-danger btn-sm remove-link-url">Remove</button>
            `;
            container.appendChild(newRow);
            counter++;
        });

        // Remove Button Functionality
        document.querySelector("#link-url-container").addEventListener("click", function (e) {
            if (e.target && e.target.classList.contains("remove-link-url")) {
                e.target.parentElement.remove();
            }
        });
    });

</script>
@endsection
