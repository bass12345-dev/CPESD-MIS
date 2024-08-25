@extends('systems.rfa.admin.layout.admin_master')
@section('title', $title)
@section('content')
<div class="main-content-inner">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card" style="border: 1px solid;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">

                            <button class="btn  mb-3 mt-2 sub-button pull-right mr-2" id="reload_admin_pending_rfa">
                                Reload <i class="ti-loop"></i></button>
                        </div>
                    </div>
                    <div class="row">

                        @include('systems.rfa.admin.pages.pending.sections.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/js-loading-overlay@1.1.0/dist/js-loading-overlay.min.js"></script>
<script type="text/javascript" src="{{ asset('pmas_rfa/tinymce/tinymce.js')}}"></script>
@include('systems.rfa.includes.custom_js.tinymce_init_js')
<script>

function load_admin_pending_rfa() {
   $('#rfa_pending_table').DataTable({
      responsive: false,
      "ordering": false,
      "ajax": {
         "url": base_url + '/admin/act/rfa/get-admin-pending-rfa',
         "type": "GET",
         "dataSrc": "",
      },
      'columns': [{
         data: "ref_number",
      }, {
         data: "name",
      }, {
         data: "address",
      }, {
         data: "type_of_request_name",
      }, {
         data: "type_of_transaction",
      }, {
         data: "status1",
      }, {
         data: "encoded_by",
      }, {
         data: "action1",
      }, ]
   });
}
load_admin_pending_rfa();

    

</script>
@endsection