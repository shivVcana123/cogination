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

                                <!-- Card Section -->
                                <div class="mb-3">
                                    <h5>Card Details</h5>
                                    <div id="cardContainer">
                                        <div class="card mt-3 p-3 border">
                                            <h5>Card Details</h5>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label>Title</label>
                                                    <input type="text" class="form-control" name="card_title[]" placeholder="Enter title">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Description</label>
                                                    <input type="text" class="form-control" name="card_description[]" placeholder="Enter description">
                                                </div>
                                            
                                            <div class="form-group col-md-6">
                                                <label>Button Text</label>
                                                <input type="text" class="form-control" name="card_button_text[]" placeholder="Enter Button Text">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Button Link</label>
                                                <input type="text" class="form-control" name="card_button_link[]" placeholder="Enter Button Link">
                                            </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Image</label>
                                                <input type="file" class="form-control" name="card_image[]">
                                            </div>
<br>
                                            <h3>Sub Cards</h3>
                                            <div class="border p-2 mt-2">
                                                <h6>Sub Card</h6>
                                                <div class="subCardHtml">
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label>Title</label>
                                                            <input type="text" class="form-control" name="sub_card_title[]" placeholder="Enter title">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Description</label>
                                                            <input type="text" class="form-control" name="sub_card_description[]" placeholder="Enter description">
                                                        </div>
                                                    </div>

                                                </div>
                                                <button type="button" class="btn btn-danger removeSubCard">Remove Sub Card</button>
                                            </div>
                                            <div class="subCardContainer"></div>
                                            <button type="button" class="btn btn-success addSubCard">Add Sub Card</button>
                                            <button type="button" class="btn btn-danger removeCard">Remove Card</button>
                                        </div>
                                    </div>

                                    <div class="row btnn-add">
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-success" id="addCard">Add Card</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <input type="checkbox" id="status" name="status" {{ ($ourDiagnostic[0]->status ?? '') === 'on' ? 'checked' : '' }}>
                                <label for="status">Show On Website</label>
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
    $(document).ready(function() {
        $('#addCard').click(function() {
            let cardHtml = `
            <div class="card mt-3 p-3 border">
                <h5>Card Details</h5>
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" name="card_title[]" placeholder="Enter title">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" class="form-control" name="card_description[]" placeholder="Enter description">
                </div>
                <div class="form-group">
                    <label>Button Text</label>
                    <input type="text" class="form-control" name="card_button_text[]" placeholder="Enter Button Text">
                </div>
                <div class="form-group">
                    <label>Button Link</label>
                    <input type="text" class="form-control" name="card_button_link[]" placeholder="Enter Button Link">
                </div>
                <div class="form-group">
                    <label>Image</label>
                    <input type="file" class="form-control-file" name="card_image[]">
                </div>
                <div class="subCardContainer"></div>
                <button type="button" class="btn btn-success addSubCard">Add Sub Card</button>
                <button type="button" class="btn btn-danger removeCard">Remove Card</button>
            </div>`;

            $('#cardContainer').append(cardHtml);
        });

        $(document).on('click', '.removeCard', function() {
            $(this).closest('.card').remove();
        });

        $(document).on('click', '.addSubCard', function() {
    let subCardHtml = `
       
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Title</label>
                        <input type="text" class="form-control" name="sub_card_title[]" placeholder="Enter title">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Description</label>
                        <input type="text" class="form-control" name="sub_card_description[]" placeholder="Enter description">
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-danger removeSubCard">Remove Sub Card</button>
     `;
    
    // Append to the correct `.subCardContainer` inside the nearest `.card`
    $(this).closest('.card').find('.subCardHtml').append(subCardHtml);
});


        $(document).on('click', '.removeSubCard', function() {
            $(this).parent().remove();
        });
    });
</script>



@endsection