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
                        <div class="card-header" style="background-color:#0476b4">
                            <h3 class="card-title">Add Footer</h3>
                        </div>
                        <form action="{{ route('footer.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Enter title">
                                </div>
                                <div class="form-group">
                                    <label for="link">Address</label>
                                    <input type="text" class="form-control" name="address" id="address" placeholder="Enter Address">
                                </div>
                                <div class="form-group">
                                    <label for="email">Fooetr Description</label>
                                    <textarea class="form-control" name="description" id="description" placeholder="Enter Text" ></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="phone_no">Contact Info</label>
                                    <input type="phone" class="form-control" name="phone_no" id="phone_no">
                                </div>

                                 <div class="form-group">
                                    <label for="phone_no">Email</label>
                                    <input type="email" class="form-control" name="email" id="email">
                                </div>

                              <div class="row">
                                <div class="col-12">
                                        <label for="headers">Select Display Data</label>
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

                                <div class="form-group">
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
                                </div>



                                <div class="form-group">
                                    <label for="background_color">Background Center Color</label>
                                    <input type="color" class="form-control" name="background_color" id="background_color">
                                </div>
                                
                                <div class="form-group">
                                    <label for="background_image">Background Center Image</label>
                                    <img id="bg_image" src="#" alt="Background Image Preview" style="width: 130px; display:none" />
                                    <input type="file" class="form-control" name="background_image" id="background_image" accept="image/*">
                                    @error('background_image')
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
