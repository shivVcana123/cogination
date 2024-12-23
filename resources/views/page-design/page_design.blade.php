@extends('layouts.guest')
@section('content')
<!-- Include CKEditor CSS -->
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.css">

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Styles</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('page.index')}}">Styles</a></li>
                        <li class="breadcrumb-item active">Styles Form</li>
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
                            <h3 class="card-title">Add Styles</h3>
                        </div>
                        <!-- Form Start -->
                        <form  action="{{ isset($pageData->id) ? route('page.update', $pageData->id) : route('page.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                             @if (isset($pageData->id))
                                @method('PUT')
                            @endif
                            <div class="card-body">
                              <input type="hidden" name="hidden_id" value="{{$pageData->id}}">

                              	@if(!$pageData->id)
                                <div class="col-md-12">
                                    <label for="category">Category</label>
                                    <select class="form-control" name="category" id="category">
                                        @foreach(['Title', 'Subtitle', 'Description', 'Header', 'Footer'] as $category)
                                            <option value="{{ $category }}" {{ isset($pageData) && $pageData->category == $category ? 'selected' : '' }}>
                                                {{ $category }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('font_size')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                              @endif

                                <br><br>
                                <div class="row">
                                    <div class="col-md-6">
                                         <label for="font_size">Font Size</label>
                                           <select class="form-control" name="font_size" id="font_size">
                                              @foreach(range(8, 90, 2) as $size)  <!-- Generates numbers from 8 to 90 in steps of 2 -->
                                                  <option value="{{ $size }}px" {{ old('font_size', $pageData->font_size ?? '') == "{$size}px" ? 'selected' : '' }}>
                                                      {{ $size }}px
                                                  </option>
                                              @endforeach
                                          </select>
                                            @error('font_size')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="font_weight">Font Weight</label>
                                           <select class="form-control" name="font_weight" id="font_weight">
                                                @foreach(range(100, 900, 100) as $weight)  <!-- Generates values 100, 200, ..., 900 -->
                                                    <option value="{{ $weight }}" {{ old('font_weight', $pageData->font_weight ?? '') == $weight ? 'selected' : '' }}>
                                                        {{ $weight }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            @error('font_weight')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="content_color">Color</label>
                                            <input type="color" class="form-control" name="content_color" id="content_color" value="{{ old('content_color') }}">
                                            @error('content_color')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="text_alignment">Alignment</label>
                                            <select class="form-control" name="text_alignment" id="text_alignment">
                                               @foreach(['None','Left', 'Right', 'Center', 'Justify'] as $alignment)
                                                    <option value="{{ $alignment }}" {{ isset($pageData) && $pageData->text_alignment == $alignment ? 'selected' : '' }}>
                                                        {{ $alignment }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('text_alignment')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                {{-- </div>
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                    <img id="blah" src="{{asset($pageData->logo ?? '')}}" alt="Image Preview" style="width: 130px; display:none" />
                                    <input type="file" class="form-control" name="image" id="imgInp" accept="image/*">
                                    @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div> --}}
                            
                            
                            </div>

                            <!-- Submit Button -->
                            <div class="card-footer">
                              	@if(!$pageData->id)
                             <button type="button" class="btn btn-primary apply" style=" margin-left: 3px;">Apply</button>@endif

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                        <!-- Form End -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Include CKEditor JS -->
<script src="https://cdn.ckeditor.com/4.25.0/standard/ckeditor.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  
  $('.apply').on('click',function(){
    var font_size = $('[name="font_size"]').val();
    var text_alignment = $('[name="text_alignment"]').val();
    var content_color = $('[name="content_color"]').val();
    var font_weight = $('[name="font_weight"]').val();
    var category = $('[name="category"]').val();
    var hidden_id = $('[name="hidden_id"]').val();
    var logo = $('[name="image"]').val();

    $.ajax({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : "{{ route('saveDesign') }}",
        type : 'get',
        data : {'font_size' : font_size,
        'text_alignment':text_alignment,
        'content_color':content_color,
        'font_weight':font_weight,
        'category':category,
        'image':logo,
               'hidden_id':hidden_id},
        dataType : 'json',
        success : function(result){

           Swal.fire({
                    title: result.message,
                    icon: 'success',
                    confirmButtonColor: '#02476c',
                    confirmButtonText: 'Ok',
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
        }
    });

   
  })
  

</script>


@endsection
