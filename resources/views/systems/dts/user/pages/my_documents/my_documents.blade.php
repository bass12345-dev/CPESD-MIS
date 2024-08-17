@extends('systems.dts.user.layout.user_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
<div class="row">
   <div class="col-md-12 col-12   ">
      @include('systems.dts.user.pages.my_documents.sections.table')
   </div>
</div>
@include('systems.dts.user.pages.my_documents.modals.cancel_modal')
@include('systems.dts.user.pages.my_documents.modals.update_document_modal')
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
            "processing": '<div class="d-flex justify-content-center ">' + table_image_loader + '</div>'
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
            data: 'data'
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
         },],
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
               return '<div class="btn-group dropstart"><i class="fa fa-ellipsis-v " class="dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false"></i><ul class="dropdown-menu"><li><a class="dropdown-item update_document" data-tracking-number="' + row.tracking_number + '" data-name            ="' + row.document_name + '"data-type            ="' + row.doc_type + '"data-description     ="' + row.description + '"data-destination     ="' + row.destination_type + '" data-origin          ="' + row.origin_id + '" href="javascript:;" class="" data-bs-toggle="modal" data-bs-target="#update_document">Update</a></li></ul></div>';
            }
         }]
      });
   });


   $(document).on('click', 'a.update_document', function (e) {
      $('input[name=t_number]').val($(this).data('tracking-number'));
      $('input[name=document_name]').val($(this).data('name'));
      $('select[name=document_type]').val($(this).data('type'));
      $('textarea[name=description]').val($(this).data('description'));
      $('select[name=origin]').val($(this).data('origin'));
      $('select[name=type]').val($(this).data('destination'));
   });
   $('#update_document_form').on('submit', function (e) {
      e.preventDefault();
      $(this).find('button').prop('disabled', true);
      $(this).find('button').html('<div class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>');
      var url = '/user/act/dts/update-document';
      let form = $(this);
      _updatetAjax(url, form, table);
   });


   
</script>
@include('systems.dts.includes.custom_js.print_slip')
@endsection