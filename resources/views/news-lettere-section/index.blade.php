@extends('layouts.guest')
@section('content')
<div class="content-wrapper">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">User Email Details</h3>
            </div>
            <div class="card-body">
                <table class="display" style="width:100%" id="subscriberEmail">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><input type="checkbox" id="selectAll">All</th>
                            <th> Subscriber Email</th>
                            <th>Subscription Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subscribeNewsletter as $key => $home)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><input type="checkbox" class="selectRow" value="{{ $home->id }}"></td>
                            <td>{{ $home->email }}</td>
                            <td>{{ date("Y-m-d", strtotime($home->created_at)) }}</td>
                            <td>
                                <a href="javascript:;" class="deleteEmail" data-id="{{ $home->id }}">
                                    <i class="fa fa-trash text-danger"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button id="deleteSelected" class="btn btn-danger">Delete Selected</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('java_script')
<script>
    $(document).ready(function() {
        $('#subscriberEmail').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'excel', 'csv', 'pdf', 'print']
        });

        // Select All Checkbox
        $("#selectAll").on("click", function() {
            $(".selectRow").prop("checked", this.checked);
        });

        // Delete Single Record
        $(document).on("click", ".deleteEmail", function() {
            let id = $(this).data("id");
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to delete this record!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#069aef",
                cancelButtonColor: "#dd3333",
                cancelButtonText: "No",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('delete-emails') }}",
                        type: "POST",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                text: "The record has been deleted.",
                                icon: "success"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        },
                        error: function() {
                            Swal.fire("Error!", "Something went wrong.", "error");
                        },
                    });
                }
            });
        });

        // Bulk Delete
        $("#deleteSelected").on("click", function() {
            let selectedIds = [];
            $(".selectRow:checked").each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                Swal.fire("Warning!", "Please select at least one record to delete.", "warning");
                return;
            }

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to delete these records!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#069aef",
                cancelButtonColor: "#dd3333",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('delete-emails') }}",
                        type: "POST",
                        data: {
                            ids: selectedIds,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                text: "The record has been deleted.",
                                icon: "success"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        },
                        error: function() {
                            Swal.fire("Error!", "Something went wrong.", "error");
                        },
                    });
                }
            });
        });
    });
</script>
@endsection