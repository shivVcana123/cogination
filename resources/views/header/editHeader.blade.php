@extends('layouts.guest')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Header Section</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('header.index')}}">Header</a></li>
                        <li class="breadcrumb-item active">Update Form</li>
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
                        <div class="card-header">
                            <h3 class="card-title">Update Header Details</h3>
                        </div>
                        <form action="{{ route('header.update',$headerData[0]->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <!-- <div class="form-group">
                                    <label for="link">Page Link</label>
                                    <input type="text"  class="form-control" name="link" id="link"  value=""    placeholder="Page Link" readonly>
                                </div> -->
                                <div class="form-group">
                                    <label for="category">Category (Edit)</label>
                                    <input type="text" oninput="categorySlug(this)" class="form-control" name="category" id="category" placeholder="Enter Category" value="{{ old('category', $headerData[0]->category) }}">
                                    @error('category')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                @if ($headerData[0]->children->isEmpty())
                                @if($headerData[0]->link == '/')
                                <div class="form-group">
                                    <label for="link">Slug</label>
                                    <input type="text" class="form-control" name="link" id="link" placeholder="Enter link" value="http://localhost:5173/" readonly>
                                    @error('link')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                @else
                                <div class="form-group">
                                    <label for="link">Slug</label>
                                    <input type="text" class="form-control" name="link" id="link" placeholder="Enter link" value="{{ old('link', $headerData[0]->link) }}" readonly>
                                    @error('link')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                @endif
                                @endif
                                <!-- @if($headerData[0]->children->isNotEmpty()) -->
                                <div class="form-group">
                                    <label>Subcategories</label>
                                    <div id="subcategory-container">
                                        @php
                                        // Use old values if available, otherwise fallback to existing data
                                        $subcategories = old('subcategories', $headerData[0]->children->map(function ($child) {
                                        return [
                                        'category' => $child->category,
                                        'link' => $child->link,
                                        ];
                                        })->toArray());
                                        @endphp

                                        @foreach ($subcategories as $value)
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="category">Sub Category (Edit)</label>
                                                <div class="input-group">
                                                    <input type="text" name="subcategories[]" class="form-control" placeholder="Enter Subcategory" value="{{ $value['category'] }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="link">Slug</label>
                                                <div class="input-group form-group">
                                                    <input type="text" name="subcategorieslink[]" class="form-control" placeholder="Enter SubcategoryLink" value="{{ $value['link'] }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <!-- <button type="button" class="btn btn-success" id="add-subcategory">Add Subcategory</button> -->
                                </div>
                                <!-- @endif -->

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    // document.getElementById('add-subcategory').addEventListener('click', function() {
    //     const container = document.getElementById('subcategory-container');
    //     const newInputGroup = document.createElement('div');
    //     newInputGroup.classList.add('input-group', 'mb-2');
    //     newInputGroup.innerHTML = `
    //         <input type="text" name="subcategories[]" class="form-control" placeholder="Enter Subcategory">
    //         <div class="input-group-append">

    //         </div>
    //     `;
    //     // <button class="btn btn-danger remove-subcategory" type="button">Remove</button>
    //     container.appendChild(newInputGroup);
    // });

    // document.getElementById('subcategory-container').addEventListener('click', function(event) {
    //     if (event.target.classList.contains('remove-subcategory')) {
    //         event.target.closest('.input-group').remove();
    //     }
    // });

    // function categorySlug(that) {
    //     // Convert the input value to lowercase
    //     const value = that.value.toLowerCase();

    //     // Replace spaces and special characters with hyphens
    //     const slug = value
    //         .trim()
    //         .replace(/[\s_]+/g, '-') // Replace spaces and underscores with hyphens
    //         .replace(/[^\w\-]+/g, ''); // Remove all non-word characters

    //     // Set the slug to the link input
    //     document.getElementById('link').value = slug;
    // }
</script>

@endsection