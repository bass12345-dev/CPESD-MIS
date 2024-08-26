<!doctype html>
<html class="no-js" lang="en">

<head>
   @include('global_includes.meta')
   @include('systems.rfa.includes.css')
</head>

<body>
   @include('components.pmas_rfa.preloader')
   <div class="page-container sbar_collapsed">
      <div class="main-content">
         @include('systems.rfa.includes.components.add_rfa_topbar')
         <div class="main-content-inner">
            <div class="row">
               <div class="col-12 mt-3">
                  <section class="wizard-section" style="background-color: #fff;">
                     <div class="row no-gutters">
                        @include('systems.pmas.user.pages.add.sections.table')
                        @include('systems.pmas.user.pages.add.sections.form')
                     </div>
                  </section>
               </div>
            </div>
         </div>
      </div>

</body>
@include('global_includes.js.global_js')
@include('systems.rfa.includes.js')
@include('systems.rfa.includes.custom_js.layout_js')
@include('global_includes.js.custom_js.wizard_js')
@include('global_includes.js.custom_js.alert_loader')
<script>

   $(document).ready(function () {
      $('.js-example-basic-single').select2();
   });
   $('#date_and_time').datetimepicker({
      "allowInputToggle": true,
      "showClose": true,
      "showClear": true,
      "showTodayButton": true,
      "format": "YYYY/MM/DD hh:mm:ss A",
   });
   $('#id_1').datetimepicker({
      "allowInputToggle": true,
      "showClose": true,
      "showClear": true,
      "showTodayButton": true,
      "format": "YYYY/MM/DD hh:mm:ss A",
   });
   $('#id_2').datetimepicker({
      "allowInputToggle": true,
      "showClose": true,
      "showClear": true,
      "showTodayButton": true,
      "format": "YYYY/MM/DD hh:mm:ss A",
   });

   function get_last_pmas_number() {
      $.ajax({
         url: base_url + '/user/act/pmas/get-last-pmas-number',
         type: 'GET',
         dataType: 'text',
         success: function (result) {
            $('input[name=pmas_number]').val(result);
         }
      });
   }

   function list_all_transactions() {
      $.ajax({
         url: base_url + '/user/act/pmas/get-pending-transaction-limit',
         type: "GET",
         dataType: "json",
         success: function (data) {
            $('#new_transactions_table').DataTable({
               scrollY: 500,
               scrollX: true,
               "ordering": false,
               pageLength: 20,
               "data": data,
               "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
               buttons: [{
                  extend: 'excel',
                  text: 'Excel',
                  className: 'btn btn-default ',
                  exportOptions: {
                     columns: 'th:not(:last-child)'
                  }
               }, {
                  extend: 'pdf',
                  text: 'pdf',
                  className: 'btn btn-default',
               }, {
                  extend: 'print',
                  text: 'print',
                  className: 'btn btn-default',
               },],
               'columns': [{
                  data: null,
                  render: function (data, type, row) {
                     return '<b><a href="javascript:;"   data-id="' + data['res_center_id'] + '"  style="color: #000;"  >' + data['pmas_no'] + '</a></b>';
                  }
               }, {
                  data: null,
                  render: function (data, type, row) {
                     return '<a href="javascript:;"   data-id="' + data['res_center_id'] + '"  style="color: #000;"  >' + data['date_and_time_filed'] + '</a>';
                  }
               }, {
                  data: null,
                  render: function (data, type, row) {
                     return '<b><a href="javascript:;"   data-id="' + data['res_center_id'] + '"  style="color: #000;"  >' + data['type_of_activity'] + '</a></b>';
                  }
               }, {
                  data: null,
                  render: function (data, type, row) {
                     return '<a href="javascript:;"   data-id="' + data['res_center_id'] + '"  style="color: #000;"  >' + data['name'] + '</a>';
                  }
               },]
            })
         }
      })
   }


   $(document).ready(function () {
      get_last_pmas_number();
      list_all_transactions();
   });

</script>

</html>