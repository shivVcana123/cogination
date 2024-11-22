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
                            <h3 class="card-title">Add News</h3>
                        </div>
                        <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Enter title">
                                </div>
                                <div class="form-group">
                                    <label for="link">Address</label>
                                    <input type="text" class="form-control" name="link" id="link" placeholder="Enter link">
                                </div>
                                <div class="form-group">
                                    <label for="description_1">Email</label>
                                    <textarea class="form-control" name="description_1" id="description_1" placeholder="Enter email"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="phone_no">Contact Info</label>
                                    <input type="tel" class="form-control" name="phone_no" id="phone_no">
                                </div>

                              <div class="row">
                                <label for="phone_no">Select Display Data</label>

                                @foreach ($headers as $header)
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <!-- Checkbox Input -->
                                                <input 
                                                    type="checkbox" 
                                                    class="form-check-input" 
                                                    name="headers[]" 
                                                    id="header_{{ $header->id }}" 
                                                    value="{{ $header->id }}"
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


                                <div class="form-group">
                                    <label for="background_color">Background Color</label>
                                    <input type="color" class="form-control" name="background_color" id="background_color">
                                </div>
                                
                                <div class="form-group">
                                    <label for="background_image">Background Image</label>
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

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script>
    // Initialize intl-tel-input for phone input
    const phoneInput = document.querySelector("#phone_no");
    if (phoneInput) {
        const iti = window.intlTelInput(phoneInput, {
            initialCountry: "auto",
            geoIpLookup: function (callback) {
                fetch("https://ipinfo.io/json?token=YOUR_TOKEN_HERE")
                    .then((response) => response.json())
                    .then((data) => callback(data.country))
                    .catch(() => callback("us"));
            },
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });

        document.querySelector("form").addEventListener("submit", function (e) {
            const fullNumber = iti.getNumber(); // Get full number with country code
            console.log("Full Number:", fullNumber);
        });
    }

    // Preview for image upload
    document.querySelector("#imgInp").addEventListener("change", (evt) => {
        const [file] = evt.target.files;
        const imgPreview = document.querySelector("#blah");
        if (file) {
            imgPreview.src = URL.createObjectURL(file);
            imgPreview.style.display = "block";
        } else {
            imgPreview.src = "#";
            imgPreview.style.display = "none";
        }
    });

    // Preview for background image upload
    document.querySelector("#background_image").addEventListener("change", (evt) => {
        const [file] = evt.target.files;
        const bgPreview = document.querySelector("#bg_image");
        if (file) {
            bgPreview.src = URL.createObjectURL(file);
            bgPreview.style.display = "block";
        } else {
            bgPreview.src = "#";
            bgPreview.style.display = "none";
        }
    });
</script>
@endpush
