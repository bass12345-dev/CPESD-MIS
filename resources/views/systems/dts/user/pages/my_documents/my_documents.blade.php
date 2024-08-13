@extends('systems.dts.user.layout.user_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
<div class="row">
   <div class="col-md-12 col-12   ">
      @include('systems.dts.user.pages.my_documents.sections.table')
   </div>
</div>
@endsection
@section('js')
<script>
$(document).ready(function () {
   table = $("#my_document_table").DataTable({
      responsive: true,
      ordering: false,
      processing: true,
      searchDelay: 500,
      pageLength: 25,
      language: {
         "processing": '<div class="d-flex justify-content-center "><img class="top-logo mt-4" src="{{asset("assets/img/peso_logo.png")}}"></div>'
      },
      "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
      buttons: datatables_buttons(),
      ajax: {
         url: base_url + "/user/act/dts/g-m-d",
         method: 'POST',
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
         },
         dataSrc: ""
      },
      columns: [{
         data: 'document_id'
      }, {
         data: 'number'
      }, {
         data: 'tracking_number'
      }, {
         data: null
      }, {
         data: 'type_name'
      }, {
         data: 'created'
      }, {
         data: 'is'
      }, {
         data: null
      }, ],
      'select': {
         'style': 'multi',
      },
      columnDefs: [{
         'targets': 0,
         'checkboxes': {
            'selectRow': true
         }
      }, {
         targets: 3,
         data: null,
         render: function (data, type, row) {
            return '<a href="' + base_url + '/dts/user/view?tn=' + row.tracking_number + '" data-toggle="tooltip" data-placement="top" title="View ' + row.tracking_number + '">' + row.document_name + '</a>';
         }
      }, {
         targets: -1,
         data: null,
         orderable: false,
         className: 'text-center',
         render: function (data, type, row) {
            return '<div class="btn-group dropstart">\ <i class="fa fa-ellipsis-v " class="dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false"></i>\ <ul class="dropdown-menu">\ <li><a class="dropdown-item update_document" \ data-tracking-number="' + row.tracking_number + '" \ data-name            ="' + row.document_name + '"\ data-type            ="' + row.doc_type + '"\ data-description     ="' + row.description + '"\ data-destination     ="' + row.destination_type + '"\ data-origin          ="' + row.origin_id + '"\ href="javascript:;" class="" data-bs-toggle="modal" data-bs-target="#update_document">Update</a></li>\ \ <li><a class="dropdown-item print_button" \ data-id              ="' + row.document_id + '" \ data-track           ="' + row.tracking_number + '" \ data-name            ="' + row.document_name + '" \ data-type            ="' + row.document_type_name + '" \ data-description     ="' + row.description + '" \ data-destination     ="' + row.destination_type + '" \ data-received        ="' + row.created + '"\ data-encoded-by      ="' + row.encoded_by + '"\ data-origin          ="' + row.origin + '"\ href="javascript:;" >Print Tracking Slip</a></li>\ </ul>\ </div>'
         }
      }]
   });
});
</script>
@endsection