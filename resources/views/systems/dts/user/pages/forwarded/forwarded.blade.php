@extends('systems.dts.user.layout.user_master')
@section('title', $title)
@section('content')
@include('global_includes.title')

<div class="row">
   <div class="col-md-12 col-12   ">
        @include('systems.dts.user.pages.forwarded.sections.table')
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
         "processing": '<div class="d-flex justify-content-center ">'+table_image_loader+'</div>'
      },
      "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
      buttons: datatables_buttons(),
      ajax: {
        url: base_url + "/user/act/dts/forwarded-documents",
         method: 'GET',
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
         },
         dataSrc: ""
      },
      columns: [{
         data: 'number',
      }, {
         data: 'tracking_number'
      }, {
         data: null
      }, {
         data: 'forwarded_to'
      }, {
         data: 'type_name'
      }, {
         data: null
      }, {
         data: 'released_date'
      }, {
         data: null
      }, ],
    
      columnDefs: [ 
         {
            targets: 2,
            data: null,
            render: function (data, type, row) {
               return '<a href="' + base_url + '/dts/user/view?tn=' + row.tracking_number + '" data-toggle="tooltip" data-placement="top" title="View ' + row.tracking_number + '">' + row.document_name + '</a>';
            }
         },
         {
            targets: 5,
            data: null,
            render: function (data, type, row) {
               var remarks = row.remarks == null ? '<span class="text-danger">no remarks</span>' : row.remarks;
               return remarks+'<br><a href="javascript:;" id="update_remarks" class="text-success" data-history-id="'+row.history_id+'" data-remarks="'+row.remarks+'" >Update Remarks</a>';
            }
         },
         
         {
            targets: -1,
            data: null,
            render: function (data, type, row) {
               return '<div class="btn-group dropstart">\
                             <i class="fa fa-ellipsis-v " class="dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false"></i>\
                             <ul class="dropdown-menu">\
                                  <li><a class="dropdown-item " id="forward_icon"  data-remarks="'+row.remarks+'" data-history-id="'+row.history_id+'" data-tracking-number="'+row.tracking_number+'"  href="javascript:;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" >Update Forward To</a></li>\
                                 \
                                </ul>\
                           </div>';
            }
         }
      
   ]
   });
});

</script>

@endsection