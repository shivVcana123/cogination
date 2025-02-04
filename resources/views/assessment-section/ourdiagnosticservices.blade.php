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
                                @php
                                // Check if the $ourDiagnostic exists and contains data before attempting to decode
                                $pointers = isset($ourDiagnostic[0]) && !empty($ourDiagnostic[0]->pointers)
                                ? json_decode($ourDiagnostic[0]->pointers)
                                : [];
                                @endphp
                                <!-- Extra Pointers Section -->
                                <div class="mb-3">
                                    <h5>Card Details</h5>
                                    <div id="cardContainer">
                                    @if(!empty($pointers) && is_array($pointers))
                                        @foreach ($pointers as $pointer)
                                        <div class="card mt-3 p-3 border">
                                            <h5>Card Details</h5>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label>Title</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                                    <input type="text" class="form-control" name="card_title[]" placeholder="Enter title" value="{{$pointer->pointerTitle ?? ''}}">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Description</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful description that summarizes the purpose of this section."></i>
                                                    <input type="text" class="form-control" name="card_description[]" placeholder="Enter description" value="{{$pointer->pointerDescription ?? ''}}">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Button Text</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful button text that summarizes the purpose of this section."></i>
                                                    <input type="text" class="form-control" name="card_button_text[]" placeholder="Enter Button Text" value="{{$pointer->button1Text ?? ''}}">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Button Link</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful button link that summarizes the purpose of this section."></i>
                                                    <input type="text" class="form-control" name="card_button_link[]" placeholder="Enter Button Link" value="{{$pointer->button1Link ?? ''}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Image</label>
                                                <i class="fas fa-info-circle" title="Enter a meaningful image that summarizes the purpose of this section."></i>
                                                <img id="blah" src="{{asset($pointer->sub_image ?? '')}}" alt="Image Preview" style="width: 130px; display:{{empty($pointer->sub_image) ? 'none' : 'block'}}" />

                                                <input type="file" class="form-control" name="card_image[]">
                                            </div><br>
                                            <h6>Sub Card</h6>
                                            <div class="subCardContainer">
                                                @foreach ($pointer->sub_pointer as $sub_pointers)
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label>Title</label>
                                                        <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                                        <input type="text" class="form-control" name="sub_card_title[]" placeholder="Enter title" value="{{$sub_pointers->pointerSubTitle1}}">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Description</label>
                                                        <i class="fas fa-info-circle" title="Enter a meaningful description that summarizes the purpose of this section."></i>
                                                        <input type="text" class="form-control" name="sub_card_description[]" placeholder="Enter description" value="{{$sub_pointers->pointerSubDescription1}}">
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-danger removeSubCard">Remove Sub Card</button>
                                                @endforeach
                                            </div><br>
                                            <div class="d-flex justify-content-between">
                                                <button type="button" class="btn btn-success addSubCard mr-2">Add Sub Card</button>
                                                <button type="button" class="btn btn-danger removeCard">Remove Card</button>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <div class="card mt-3 p-3 border">
                                            <h5>Card Details</h5>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label>Title</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                                    <input type="text" class="form-control" name="card_title[]" placeholder="Enter title">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Description</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful description that summarizes the purpose of this section."></i>
                                                    <input type="text" class="form-control" name="card_description[]" placeholder="Enter description">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Button Text</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful button text that summarizes the purpose of this section."></i>
                                                    <input type="text" class="form-control" name="card_button_text[]" placeholder="Enter Button Text">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Button Link</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful button link that summarizes the purpose of this section."></i>
                                                    <input type="text" class="form-control" name="card_button_link[]" placeholder="Enter Button Link">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Image</label>
                                                <i class="fas fa-info-circle" title="Enter a meaningful image that summarizes the purpose of this section."></i>
                                                <input type="file" class="form-control" name="card_image[]">
                                            </div><br>
                                            <h6>Sub Card</h6>
                                            <div class="subCardContainer">
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label>Title</label>
                                                        <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                                        <input type="text" class="form-control" name="sub_card_title[]" placeholder="Enter title">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Description</label>
                                                        <i class="fas fa-info-circle" title="Enter a meaningful description that summarizes the purpose of this section."></i>
                                                        <input type="text" class="form-control" name="sub_card_description[]" placeholder="Enter description">
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-danger removeSubCard">Remove Sub Card</button>
                                            </div><br>
                                            <div class="d-flex justify-content-between">
                                                <button type="button" class="btn btn-success addSubCard mr-2">Add Sub Card</button>
                                                <button type="button" class="btn btn-danger removeCard">Remove Card</button>
                                            </div>
                                        </div>
                                        @endif
                                        
                                    </div>
                                    <div class="row btnn-add">
                                        <div class="col-md-6 ml-3">
                                            <button type="button" class="btn btn-success" id="addCard">Add Card</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <input type="checkbox" id="status" name="status" {{ ($ourDiagnostic[0]->status ?? '') === 'on' ? 'checked' : '' }}>
                                    <label for="status">Show On Website</label>
                                    <button type="submit" id="formSubmit" class="btn btn-primary">Submit</button>
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
<!-- <script>
    $(document).ready(function() {
        // Add new Card
        $('#addCard').click(function() {
            let cardHtml = `
        <div class="card mt-3 p-3 border">
            <h5>Card Details</h5>
             <div class="row">
            <div class="form-group col-md-6">
                <label>Title</label>
                <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                <input type="text" class="form-control" name="card_title[]" placeholder="Enter title">
            </div>
            <div class="form-group col-md-6">
                <label>Description</label>
                <i class="fas fa-info-circle" title="Enter a meaningful description that summarizes the purpose of this section."></i>
                <input type="text" class="form-control" name="card_description[]" placeholder="Enter description">
            </div>
            <div class="form-group col-md-6">
                <label>Button Text</label>
                <i class="fas fa-info-circle" title="Enter a meaningful button text that summarizes the purpose of this section."></i>
                <input type="text" class="form-control" name="card_button_text[]" placeholder="Enter Button Text">
            </div>
            <div class="form-group col-md-6">
                <label>Button Link</label>
                <i class="fas fa-info-circle" title="Enter a meaningful button link that summarizes the purpose of this section."></i>
                <input type="text" class="form-control" name="card_button_link[]" placeholder="Enter Button Link">
            </div>
             </div>
            <div class="form-group">
                <label>Image</label>
                <i class="fas fa-info-circle" title="Enter a meaningful Image that summarizes the purpose of this section."></i>
                <input type="file" class="form-control" name="card_image[]">
            </div><br>
            
            <h6>Sub Card</h6>
            <div class="subCardContainer">
              <div class="row">
             <div class="form-group col-md-6">
                    <label>Title</label>
                    <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                    <input type="text" class="form-control" name="sub_card_title[]" placeholder="Enter title">
                </div>
                <div class="form-group col-md-6">
                    <label>Description</label>
                    <i class="fas fa-info-circle" title="Enter a meaningful description that summarizes the purpose of this section."></i>
                    <input type="text" class="form-control" name="sub_card_description[]" placeholder="Enter description">
                </div>
                </div>
                <button type="button" class="btn btn-danger removeSubCard">Remove Sub Card</button>
            </div><br>
            
         <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-success addSubCard mr-2">Add Sub Card</button>
                <button type="button" class="btn btn-danger removeCard">Remove Card</button>
        </div>
        </div>`;

            $('#cardContainer').append(cardHtml);
        });

        // Remove Card
        $(document).on('click', '.removeCard', function() {
            $(this).closest('.card').remove();
        });

        // Add new Sub Card
        $(document).on('click', '.addSubCard', function() {
            let subCardHtml = `
        <div class="subCard p-2 border rounded mt-2">
         <div class="row">
            <div class="form-group col-md-6">
                <label>Title</label>
                <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                <input type="text" class="form-control" name="sub_card_title[]" placeholder="Enter title">
            </div>
            <div class="form-group col-md-6">
                <label>Description</label>
                <i class="fas fa-info-circle" title="Enter a meaningful description that summarizes the purpose of this section."></i>
                <input type="text" class="form-control" name="sub_card_description[]" placeholder="Enter description">
            </div>
             </div>
            <button type="button" class="btn btn-danger removeSubCard">Remove Sub Card</button>
        </div>`;

            $(this).closest('.card').find('.subCardContainer').append(subCardHtml);
        });

        // Remove Sub Card
        $(document).on('click', '.removeSubCard', function() {
            $(this).closest('.subCard').remove();
        });
    });
</script> -->

<script>
    $(document).ready(function() {
        // Function to update remove button visibility
        function updateRemoveButtonVisibility() {
            $(".removeCard").toggle($(".card").length > 1);
            $(".subCardContainer").each(function() {
                $(this).find(".removeSubCard").toggle($(this).find(".subCard").length > 1);
            });
        }

        // Add new Card
        $('#addCard').click(function() {
            let cardHtml = `
        <div class="card mt-3 p-3 border">
            <h5>Card Details</h5>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Title</label>
                    <input type="text" class="form-control card-title" name="card_title[]" placeholder="Enter title">
                </div>
                <div class="form-group col-md-6">
                    <label>Description</label>
                    <input type="text" class="form-control card-description" name="card_description[]" placeholder="Enter description">
                </div>
                <div class="form-group col-md-6">
                    <label>Button Text</label>
                    <input type="text" class="form-control card-button-text" name="card_button_text[]" placeholder="Enter Button Text">
                </div>
                <div class="form-group col-md-6">
                    <label>Button Link</label>
                    <input type="text" class="form-control card-button-link" name="card_button_link[]" placeholder="Enter Button Link">
                </div>
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="file" class="form-control card-image" name="card_image[]">
            </div><br>

            <h6>Sub Card</h6>
            <div class="subCardContainer">
                <div class="subCard p-2 border rounded mt-2">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Title</label>
                            <input type="text" class="form-control sub-card-title" name="sub_card_title[]" placeholder="Enter title">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Description</label>
                            <input type="text" class="form-control sub-card-description" name="sub_card_description[]" placeholder="Enter description">
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger removeSubCard">Remove Sub Card</button>
                </div>
            </div><br>

            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-success addSubCard">Add Sub Card</button>
                <button type="button" class="btn btn-danger removeCard">Remove Card</button>
            </div>
        </div>`;

            $('#cardContainer').append(cardHtml);
            updateRemoveButtonVisibility();
        });

        // Remove Card
        $(document).on('click', '.removeCard', function() {
            $(this).closest('.card').remove();
            updateRemoveButtonVisibility();
        });

        // Add new Sub Card
        $(document).on('click', '.addSubCard', function() {
            let subCardHtml = `
        <div class="subCard p-2 border rounded mt-2">
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Title</label>
                    <input type="text" class="form-control sub-card-title" name="sub_card_title[]" placeholder="Enter title">
                </div>
                <div class="form-group col-md-6">
                    <label>Description</label>
                    <input type="text" class="form-control sub-card-description" name="sub_card_description[]" placeholder="Enter description">
                </div>
            </div>
            <button type="button" class="btn btn-danger removeSubCard">Remove Sub Card</button>
        </div>`;

            $(this).closest('.card').find('.subCardContainer').append(subCardHtml);
            updateRemoveButtonVisibility();
        });

        // Remove Sub Card
        $(document).on('click', '.removeSubCard', function() {
            $(this).closest('.subCard').remove();
            updateRemoveButtonVisibility();
        });

   

        // Remove validation error on input change
        $(document).on('input', '.is-invalid', function() {
            $(this).removeClass('is-invalid');
        });

        // Initialize button visibility
        updateRemoveButtonVisibility();
    });
</script>

@endsection