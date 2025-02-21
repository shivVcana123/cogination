@extends('layouts.guest')
@section('content')
<style>
    .dt-buttons {
    /* margin-top: -2px !important; */
    margin-left: 10px !important;
}
</style>
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
                            <th><input type="checkbox" id="selectAll"> Select All</th>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<!-- @section('java_script')
<script>
    $(document).ready(function() {
        // $('#subscriberEmail').DataTable({
        //     dom: 'Bfrtip',
        //     buttons: ['copy', 'excel', 'csv', 'pdf', 'print']
        // });



        $('#subscriberEmail').DataTable({
            dom: 'lBfrtip', // "l" adds the "Show entries" dropdown
            pageLength: 10, // Default selection: 10 records per page
            lengthMenu: [
                [10, 25, 50, 100, 500],
                [10, 25, 50, 100, "500"]
            ], // Dropdown options
            stateSave: true, // Remembers user's selection
            buttons: [{
                    extend: 'copy',
                    text: 'Copy',
                    action: function(e, dt, node, config) {
                        exportData(dt, 'copy');
                    }
                },
                {
                    extend: 'excel',
                    text: 'Excel',
                    action: function(e, dt, node, config) {
                        exportData(dt, 'excel');
                    }
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    action: function(e, dt, node, config) {
                        exportData(dt, 'csv');
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    action: function(e, dt, node, config) {
                        exportData(dt, 'pdf');
                    }
                },
                {
                    extend: 'print',
                    text: 'Print',
                    className:'buttons-html5',
                    action: function(e, dt, node, config) {
                        exportData(dt, 'print');
                    }
                }
            ],
            initComplete: function() {
                $(".buttons-html5").css({ "padding": "4px 10px 4px 10px", "font-size": "13px" });
            }
        });

        /**
         * Function to export clean data without HTML tags, blank columns, or extra spaces.
         */
        function exportData(dt, type) {
            let selectedRows = [];

            // Get selected rows
            $('#subscriberEmail tbody input[type="checkbox"]:checked').each(function() {
                let row = $(this).closest('tr');
                let rowData = dt.row(row).data();
                selectedRows.push(rowData);
            });

            // If no rows are selected, export all filtered data
            let exportData = selectedRows.length > 0 ? selectedRows : dt.rows({
                search: 'applied'
            }).data().toArray();

            // Clean data: remove HTML tags, trim spaces, and remove empty columns
            let cleanData = exportData.map(row =>
                row.map(cell => $('<div>').html(cell).text().trim()) // Remove HTML tags & trim spaces
                .filter(cell => cell !== "") // Remove empty columns
            ).filter(row => row.length > 0); // Remove completely empty rows

            // Export based on the selected format
            if (type === 'copy') {
                navigator.clipboard.writeText(cleanData.map(row => row.join("\t")).join("\n"));
                alert("Copied to clipboard!");
            } else if (type === 'excel' || type === 'csv' || type === 'pdf') {
                let ws = XLSX.utils.aoa_to_sheet(cleanData);
                let wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "Subscribers");
                let fileType = type === 'excel' ? 'xlsx' : type === 'csv' ? 'csv' : 'pdf';
                XLSX.writeFile(wb, `SubscriberData.${fileType}`);
            } else if (type === 'print') {
                let printableData = cleanData.map(row => row.join("\t")).join("\n");
                let printWindow = window.open("", "_blank");
                printWindow.document.write("<pre>" + printableData + "</pre>");
                printWindow.document.close();
                printWindow.print();
            }
        }


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
@endsection -->
@section('java_script')
<script>
    $(document).ready(function() {
        let table = $('#subscriberEmail').DataTable({
            dom: 'lBfrtip',
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100, 500], [10, 25, 50, 100, "500"]],
            stateSave: true,
            buttons: [
                { extend: 'copy', text: 'Copy', action: function(e, dt) { exportData(dt, 'copy'); }},
                { extend: 'excel', text: 'Excel', action: function(e, dt) { exportData(dt, 'excel'); }},
                { extend: 'csv', text: 'CSV', action: function(e, dt) { exportData(dt, 'csv'); }},
                { extend: 'pdf', text: 'PDF', action: function(e, dt) { exportData(dt, 'pdf'); }},
                { extend: 'print', text: 'Print', className: 'buttons-html5', action: function(e, dt) { exportData(dt, 'print'); }}
            ],
            initComplete: function() {
                $(".buttons-html5").css({ "padding": "4px 10px", "font-size": "13px" });
            }
        });

        let hasSelectedRows = false;
        $(document).on("change", ".selectRow", function() {
            hasSelectedRows = $(".selectRow:checked").length > 0;
        });

        function exportData(dt, type) {
            let selectedRows = $(".selectRow:checked").map(function() {
                return dt.row($(this).closest('tr')).data();
            }).get();

            let exportData = selectedRows.length ? selectedRows : dt.rows({ search: 'applied' }).data().toArray();
            let cleanData = exportData.map(row => row.map(cell => $('<div>').html(cell).text().trim()).filter(cell => cell !== "")).filter(row => row.length > 0);

            if (type === 'copy') {
                navigator.clipboard.writeText(cleanData.map(row => row.join("\t")).join("\n"));
                Swal.fire("Copied!", "Data copied to clipboard.", "success");
            } else if (type === 'excel' || type === 'csv' || type === 'pdf') {
                let ws = XLSX.utils.aoa_to_sheet(cleanData);
                let wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "Subscribers");
                XLSX.writeFile(wb, `SubscriberData.${type === 'excel' ? 'xlsx' : type}`);
            } else if (type === 'print') {
                let printableData = cleanData.map(row => row.join("\t")).join("\n");
                let printWindow = window.open("", "_blank");
                printWindow.document.write("<pre>" + printableData + "</pre>");
                printWindow.document.close();
                printWindow.print();
            }
        }

        $("#selectAll").on("click", function() {
            $(".selectRow").prop("checked", this.checked);
        });

        function deleteRecords(ids) {
            $.ajax({
                url: "{{ route('delete-emails') }}",
                type: "POST",
                data: { ids: ids, _token: "{{ csrf_token() }}" },
                success: function() {
                    Swal.fire({ text: "The record(s) have been deleted.", icon: "success" }).then(() => location.reload());
                },
                error: function() {
                    Swal.fire("Error!", "Something went wrong.", "error");
                },
            });
        }

        $(document).on("click", ".deleteEmail", function() {
            let id = $(this).data("id");
            Swal.fire({
                title: "Are you sure?",
                text: "This record will be deleted permanently.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#069aef",
                cancelButtonColor: "#dd3333",
                confirmButtonText: "Yes",
                cancelButtonText: "No"
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteRecords([id]);
                }
            });
        });

        $("#deleteSelected").on("click", function() {
            let selectedIds = $(".selectRow:checked").map(function() { return $(this).val(); }).get();
            if (!selectedIds.length) {
                Swal.fire("Warning!", "Please select at least one record.", "warning");
                return;
            }
            Swal.fire({
                title: "Are you sure?",
                text: "These records will be deleted permanently.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#069aef",
                cancelButtonColor: "#dd3333",
                confirmButtonText: "Yes",
                cancelButtonText: "No"
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteRecords(selectedIds);
                }
            });
        });
    });
</script>
@endsection
