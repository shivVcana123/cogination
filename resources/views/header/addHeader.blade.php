@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Header Section</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('header.index')}}">Header</a></li>
                        <li class="breadcrumb-item active">Header Form</li>
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
                            <h3 class="card-title">Add Header</h3>
                        </div>
                        <form action="{{ route('header.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="link">Page Link</label>
                                    <input type="text"  class="form-control" name="link" id="link"  value=""    placeholder="Page Link" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <input type="text" oninput="categorySlug(this)"  class="form-control" name="category" id="category" placeholder="Enter Category" value="{{old('category')}}">
                                    @error('category')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label>Subcategories</label>
                                    <div id="subcategory-container">
                                    @foreach (old('subcategories', ['']) as $value)
                                        <div class="input-group mb-2">
                                            <input type="text" name="subcategories[]" class="form-control" placeholder="Enter Subcategory" value="{{ $value }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-danger remove-subcategory" type="button">Remove</button>
                                            </div>
                                        </div>
                                    @endforeach

                                    </div>
                                    <button type="button" class="btn btn-success" id="add-subcategory">Add Subcategory</button>
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
    document.getElementById('add-subcategory').addEventListener('click', function() {
        const container = document.getElementById('subcategory-container');
        const newInputGroup = document.createElement('div');
        newInputGroup.classList.add('input-group', 'mb-2');
        newInputGroup.innerHTML = `
            <input type="text" name="subcategories[]" class="form-control" placeholder="Enter Subcategory">
            <div class="input-group-append">
                <button class="btn btn-danger remove-subcategory" type="button">Remove</button>
            </div>
        `;
        container.appendChild(newInputGroup);
    });

    document.getElementById('subcategory-container').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-subcategory')) {
            event.target.closest('.input-group').remove();
        }
    });

    function categorySlug(that) {
        // Convert the input value to lowercase
        const value = that.value.toLowerCase();

        // Replace spaces and special characters with hyphens
        const slug = value
            .trim()
            .replace(/[\s_]+/g, '-') // Replace spaces and underscores with hyphens
            .replace(/[^\w\-]+/g, ''); // Remove all non-word characters

        // Set the slug to the link input
        document.getElementById('link').value = slug;
    }
</script>

@endsection