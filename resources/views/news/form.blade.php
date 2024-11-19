@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add News Data</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">News</a></li>
                        <li class="breadcrumb-item active">News Form</li>
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
                                    <label for="title">Decription 1</label>
                                    <textarea type="text" class="form-control" name="description_1" id="description_1" ></textarea>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="title">Subtitle</label>
                                    <input type="text" class="form-control" name="subtitle" id="subtitle" placeholder="Enter Subtitle">
                                </div>
                                <div class="form-group">
                                    <label for="title">Decription 2</label>
                                    <textarea type="text" class="form-control" name="description_2" id="description_2" ></textarea>
                                </div> -->
                                 <!-- <div class="form-group">
                                    <label>Pointers</label>
                                    <div id="Pointers-container">
                                        <div class="input-group mb-2">
                                            <input type="text" name="pointers[]" class="form-control" placeholder="Enter Pointers">
                                            <div class="input-group-append">
                                                <button class="btn btn-danger remove-Pointers" type="button">Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-success" id="add-Pointers">Add Pointer</button>
                                </div> -->
                                <!-- <div class="form-group">
                                    <label for="title">Button Text</label>
                                    <input type="text" class="form-control" name="button_content" id="button_content" placeholder="Enter Button Text">
                                </div>
                                <div class="form-group">
                                    <label for="title">Button Link</label>
                                    <input type="text" class="form-control" name="button_link" id="button_link" placeholder="Enter Button Link">
                                </div> -->
                                <div class="form-group">
                                    <label for="title">Background Color</label>
                                    <input type="color" class="form-control" name="background_color" id="background_color">
                                </div>
                                <div class="form-group">
                                    <label for="title">Image</label>
                                    <input type="file" class="form-control" name="image" id="image">
                                </div>
                                 <div class="form-group">
                                    <label for="title">Background Image</label>
                                    <input type="file" class="form-control" name="background_image" id="background_image">
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
    document.getElementById('add-Pointers').addEventListener('click', function () {
        const container = document.getElementById('Pointers-container');
        const newInputGroup = document.createElement('div');
        newInputGroup.classList.add('input-group', 'mb-2');
        newInputGroup.innerHTML = `
            <input type="text" name="pointers[]" class="form-control" placeholder="Enter Pointers">
            <div class="input-group-append">
                <button class="btn btn-danger remove-Pointers" type="button">Remove</button>
            </div>
        `;
        container.appendChild(newInputGroup);
    });

    document.getElementById('Pointers-container').addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-Pointers')) {
            event.target.closest('.input-group').remove();
        }
    });
</script>

@endsection
