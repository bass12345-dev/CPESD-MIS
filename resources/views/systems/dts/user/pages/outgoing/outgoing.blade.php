@extends('systems.dts.user.layout.user_master')
@section('title', $title)
@section('content')
@include('global_includes.title')

<div class="row">
    <div class="col-md-12 col-12   ">
        @include('systems.dts.user.pages.outgoing.sections.table')
    </div>
</div>

@endsection
@section('js')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        table = $("#datatables-buttons").DataTable({
            responsive: true,
            ordering: false,
            processing: true,
            pageLength: 25,
            language: {
                "processing": '<div class="d-flex justify-content-center ">' + table_image_loader + '</div>'
            },
            "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: datatables_buttons(),

            ajax: {
                url: base_url + "/user/act/dts/outgoing-documents",
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                dataSrc: ""
            },
            columns: [
                {
                    data: 'doc_id',
                },
                {
                    data: 'number',
                },
                {
                    data: 'tracking_number',
                },
                {
                    data: null,
                },

                {
                    data: 'office',
                },
                {
                    data: 'type_name',
                },
                {
                    data: null,
                },
                {
                    data: 'outgoing_date',
                }, {
                    data: null,
                },
            ],
            'select': {
                'style': 'multi',
            },
            columnDefs: [
                {
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true
                    },
                },
                {
                    targets: 6,
                    data: null,
                    render: function (data, type, row) {
                        return '<a href="javascript:;" data-remarks="' + row.remarks + '" id="view_remarks">View Remarks</a>';
                    }
                },
                {
                    targets: 3,
                    data: null,
                    render: function (data, type, row) {
                        return '<a href="' + base_url + '/dts/user/view?tn=' + row.tracking_number + '" data-toggle="tooltip" data-placement="top" title="View ' + row.tracking_number + '">' + row.document_name + '</a>';
                    }
                },
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    className: 'text-center',
                    render: function (data, type, row) {
                        return '<div class="btn-group dropstart">\
                           <i class="fa fa-ellipsis-v " class="dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false"></i>\
                              <ul class="dropdown-menu">\
                                 <li><a class="dropdown-item " data-remarks="'+ row.remarks + '" data-outgoing-id="' + row.outgoing_id + '" data-office="' + row.office_id + '" id="update_outgoing">Update</a></li>\
                              </ul>\
                           </i>\
                        </div>\
               ';



                    }
                }

            ]

        });
    });
</script>
@endsection