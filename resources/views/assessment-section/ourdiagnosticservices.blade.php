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
                               
                                <!-- Extra Pointers Section -->

                                <div class="mb-3">
                                    <h5>Card Details</h5>
                                    <div id="pointerFields">
                                        <!-- Empty Pointer Fields -->
                                        <div class="pointer-field mb-3" data-pointer-id="0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="pointerTitle0"> Title</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                                    <input type="text" id="pointerTitle0" class="form-control mb-2" name="pointerTitle[]" placeholder="Enter title">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="pointerDescription0"> Description</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful description that summarizes the purpose of this section."></i>
                                                    <input type="text" id="pointerDescription0" class="form-control mb-2" name="pointerDescription[]" placeholder="Enter description">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="button1Text0">Button Text</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful button text that summarizes the purpose of this section."></i>
                                                    <input type="text" id="button1Text0" class="form-control mb-2" name="button1Text[]" placeholder="Enter Button Text">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="button1Link0">Button Link</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful button link that summarizes the purpose of this section."></i>
                                                    <input type="text" id="button1Link0" class="form-control mb-2" name="button1Link[]" placeholder="Enter Button Link">
                                                </div>

                                                <div class="col-md-12">
                                                    <label for="image0">Image</label>
                                                    <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                                    <img id="blah" src="#" alt="Image Preview" style="width: 130px; display:none" />
                                                    <input type="file" id="image0" class="form-control mb-2" name="image[]" accept="image/*">
                                                </div>
                                            </div>
                                            <h5>Add Sub Card</h5>
                                            <div class="sub-pointer-area ">
                                                <div class="sub-pointer mb-3 " data-sub-pointer-id="0">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input type="checkbox"> <label for="pointerSubTitle0_0"> Title</label>
                                                            <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                                            <input type="text" id="pointerSubTitle0_0" class="form-control mb-2" name="pointerSubTitle[0][]" placeholder="Enter title">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="pointerSubDescription0_0"> Description</label>
                                                            <i class="fas fa-info-circle" title="Enter a meaningful description that summarizes the purpose of this section."></i>
                                                            <input id="pointerSubDescription0_0" class="form-control mb-2" name="pointerSubDescription[0][]" placeholder="Enter description">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="checkbox"> <label for="pointerSubTitle0_0"> Title</label>
                                                            <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                                            <input type="text" id="pointerSubTitle0_0" class="form-control mb-2" name="pointerSubTitle[0][]" placeholder="Enter title">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="pointerSubDescription0_0"> Description</label>
                                                            <i class="fas fa-info-circle" title="Enter a meaningful description that summarizes the purpose of this section."></i>
                                                            <input id="pointerSubDescription0_0" class="form-control mb-2" name="pointerSubDescription[0][]" placeholder="Enter description">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="checkbox"> <label for="pointerSubTitle0_0"> Title</label>
                                                            <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                                            <input type="text" id="pointerSubTitle0_0" class="form-control mb-2" name="pointerSubTitle[0][]" placeholder="Enter title">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="pointerSubDescription0_0"> Description</label>
                                                            <i class="fas fa-info-circle" title="Enter a meaningful description that summarizes the purpose of this section."></i>
                                                            <input id="pointerSubDescription0_0" class="form-control mb-2" name="pointerSubDescription[0][]" placeholder="Enter description">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>


                                        </div>

                                    </div>
                                    <button type="button" class="btn btn-primary">Add sub Card</button>
                                    <button type="button" class="btn btn-primary1" style="margin-left: 86%;"> Delete Sub card </button>

                                </div>
                                <div>
                                </div>
                                <div class="mb-3">
                                    <h5>Card Details</h5>
                                    <div id="pointerFields">
                                        <!-- Empty Pointer Fields -->
                                        <div class="pointer-field mb-3" data-pointer-id="0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="pointerTitle0"> Title</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                                    <input type="text" id="pointerTitle0" class="form-control mb-2" name="pointerTitle[]" placeholder="Enter title">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="pointerDescription0"> Description</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful description that summarizes the purpose of this section."></i>
                                                    <input type="text" id="pointerDescription0" class="form-control mb-2" name="pointerDescription[]" placeholder="Enter description">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="button1Text0">Button Text</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful button text that summarizes the purpose of this section."></i>
                                                    <input type="text" id="button1Text0" class="form-control mb-2" name="button1Text[]" placeholder="Enter Button Text">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="button1Link0">Button Link</label>
                                                    <i class="fas fa-info-circle" title="Enter a meaningful button link that summarizes the purpose of this section."></i>
                                                    <input type="text" id="button1Link0" class="form-control mb-2" name="button1Link[]" placeholder="Enter Button Link">
                                                </div>

                                                <div class="col-md-12">
                                                    <label for="image0">Image</label>
                                                    <i class="fas fa-info-circle" title="Upload an image that visually represents this section."></i>
                                                    <img id="blah" src="#" alt="Image Preview" style="width: 130px; display:none" />
                                                    <input type="file" id="image0" class="form-control mb-2" name="image[]" accept="image/*">
                                                </div>
                                            </div>
                                            <h5>Add Sub Card</h5>
                                            <div class="sub-pointer-area ">
                                                <div class="sub-pointer mb-3 " data-sub-pointer-id="0">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="pointerSubTitle0_0"> Title</label>
                                                            <i class="fas fa-info-circle" title="Enter a meaningful title that summarizes the purpose of this section."></i>
                                                            <input type="text" id="pointerSubTitle0_0" class="form-control mb-2" name="pointerSubTitle[0][]" placeholder="Enter title">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="pointerSubDescription0_0"> Description</label>
                                                            <i class="fas fa-info-circle" title="Enter a meaningful description that summarizes the purpose of this section."></i>
                                                            <input id="pointerSubDescription0_0" class="form-control mb-2" name="pointerSubDescription[0][]" placeholder="Enter description">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>


                                        </div>

                                    </div>


                                </div>
                                <div class="buttons">
                                    <button type="button" class="btn btn-primary">Add Card</button>
                                    <button type="button" class="btn btn-primary1" style="https://vcanaglobal.in/cognition-caremargin-left: 75%;">Delete Card</button>
                                    <button type="button" class="btn btn-primary" >Add sub Card</button>
                                    <button type="button" class="btn btn-primary1" > Delete Sub card </button>
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
    // Initialize CKEditor
    CKEDITOR.replace('description');
</script>

@endsection

<style>
    .buttons button.btn.btn-primary {
        margin-left: 17px;
    }

    button.btn.btn-primary1 {
        background: #e2e2e2 !important;
        color: #000;
    }

    button.btn.btn-primary1:hover {
        background: red !important;
        color: #fff !important;
    }

    hr {
        opacity: 0;
    }

    button.btn.btn-primary {
        margin-left: 10px;
    }
</style>