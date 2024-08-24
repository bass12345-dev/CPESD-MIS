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
                        @include('systems.rfa.user.pages.add.sections.table')
                        @include('systems.rfa.user.pages.add.sections.form')
                     </div>
                  </section>
               </div>
            </div>
         </div>
      </div>
      @include('systems.rfa.user.pages.add.modal.search_name_modal')
      @include('systems.rfa.user.pages.add.modal.add_client_modal')
      @include('systems.rfa.user.pages.add.modal.view_client_information_modal')
</body>
@include('global_includes.js.global_js')
@include('systems.rfa.includes.js')
@include('systems.rfa.includes.custom_js.layout_js')
@include('global_includes.js.custom_js.wizard_js')
@include('global_includes.js.custom_js.alert_loader')
<script>
   $(document).on('click', 'a#reload_all_transactions', function (e) {
      $('#request_table').DataTable().destroy();
      get_last_reference_number();
      rfa_transactions();
   });
   function rfa_transactions() {
      $('#request_table').DataTable({
         scrollY: 500,
         scrollX: true,
         "ordering": false,
         pageLength: 20,
         "ajax": {
            "url": base_url + '/user/act/rfa/g-p-t-l',
            "type": "GET",
            "dataSrc": "",
         },
         'columns': [{
            data: "ref_number",
         }, {
            data: "rfa_date_filed",
         }, {
            data: "name",
         },]
      })
   }

   function get_last_reference_number() {
      $.ajax({
         url: base_url + '/user/act/rfa/g-l-r-n',
         type: 'GET',
         dataType: 'text',
         success: function (result) {
            $('input[name=reference_number]').val(result);
         },
         error: function (xhr) {
            alert("Error occured.please try again");
            // location.reload();
         },
      });
   }




   $('input[name=name_of_client]').click(function (e) {
      e.preventDefault();
      $('#search_name_modal').modal('show');
   });
   $(document).on('click', 'button#add_client', function (e) {
      $('#add_client_modal').modal('show');
   });


   $(document).on('click', 'button#search_client', function (e) {
      var first_name = $('input[name=search_first_name]').val();
      var last_name = $('input[name=search_last_name]').val();
      $('#search_name_result_table').DataTable().destroy();
      if (first_name == '' && last_name == '') {
         alert('please input First Name or Last Name');
      } else {
         search_name_result(first_name, last_name)
      }
   });


   function search_name_result(first_name, last_name) {
      $.ajax({
         url: base_url + '/user/act/rfa/s-c',
         type: "POST",
         data: {
            first_name: first_name,
            last_name: last_name
         },
         dataType: "json",
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
         },
         success: function (data) {
            $('#search_name_result').removeAttr('hidden');
            $('#search_name_result_table').DataTable({
               "ordering": false,
               search: true,
               "data": data,
               'columns': [{
                  data: 'first_name',
               }, {
                  data: 'last_name',
               }, {
                  data: 'middle_name',
               }, {
                  data: 'extension',
               }, {
                  data: null,
                  render: function (data, type, row) {
                     return '<ul class="d-flex justify-content-center">\ <li class="mr-3 "><a href="javascript:;" class="text-success action-icon" data-id="' + data['rfa_client_id'] + '" \ data-name="' + data['first_name'] + ' ' + data['middle_name'] + ' ' + data['last_name'] + ' ' + data['extension'] + '"  \ id="confirm-client"><i class="fa fa-check"></i></a></li>\ <li><a href="javascript:;" \ \ data-id="' + data['rfa_client_id'] + '"  \ data-name="' + data['first_name'] + ' ' + data['middle_name'] + ' ' + data['last_name'] + ' ' + data['extension'] + '"  \ data-address="' + data['address'] + '"  \ data-number="' + data['contact_number'] + '"  \ data-age="' + data['age'] + '"  \ data-status="' + data['employment_status'] + '"  \ id="view-client-data"  class="text-secondary action-icon"><i class="ti-eye"></i></a></li>\ </ul>';
                  }
               },]
            });
         }
      });
   }

   $(document).on('click', 'a#confirm-client', function (e) {
      $('#search_name_modal').modal('hide');
      $('input[name=search_first_name]').val('');
      $('input[name=search_last_name]').val('');
      $('#search_name_result').attr("hidden", true);
      $('input[name=name_of_client]').val($(this).data('name'));
      $('input[name=client_id]').val($(this).data('id'));
   });
   $(document).on('click', 'a#view-client-data', function (e) {
      $('#view_client_information_modal').modal('show');
      $('.complete_name').text($(this).data('name'));
      $('.address').text($(this).data('address'));
      $('.contact_number').text($(this).data('number'));
      $('.age').text($(this).data('age'));
      $('.employment_status').text($(this).data('status'));
   });
   $(document).on('click', 'button#close_search_client', function (e) {
      $('#search_name_result').attr("hidden", true);
   });



   $(document).on('change', 'select[name=type_of_transaction]', function () {
      if ($('select[name=type_of_transaction]').val() == 'simple') {
         $('#refer_to').attr('hidden', false)
      } else {
         $('#refer_to').attr('hidden', true)
      }
   });

   $('#add_client_form').on('submit', function (e) {
      e.preventDefault();
      $.ajax({
         type: "POST",
         url: base_url + '/user/act/rfa/a-c',
         data: new FormData(this),
         contentType: false,
         cache: false,
         processData: false,
         dataType: 'json',
         beforeSend: function () {
            $('.btn-add-client').text('Please wait...');
            $('.btn-add-client').attr('disabled', 'disabled');
         },
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
         },
         success: function (data) {
            if (data.response) {
               $('#add_client_modal').modal('hide');
               $('#add_client_form')[0].reset();
               $('.btn-add-client').text('Save Changes');
               $('.btn-add-client').removeAttr('disabled');
               toast_message_success(data.message)
            } else {
               $('.btn-add-client').text('Save Changes');
               $('.btn-add-client').removeAttr('disabled');
               toast_message_error(data.message)
            }
         },
         error: function (xhr) {
            alert("Error occured.please try again");
            $('.btn-add-client').text('Save Changes');
            $('.btn-add-client').removeAttr('disabled');
            location.reload();
         },
      });
   });


   $('#add_rfa_form').on('submit', function (e) {
      e.preventDefault();
      if ($('input[name=client_id]').val() == '') {
         alert('Error');
      } else {
         Swal.fire({
            title: "",
            text: "Review first before submitting",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
         }).then(function (result) {
            if (result.value) {
               $.ajax({
                  type: "POST",
                  url: base_url + '/user/act/rfa/add-rfa',
                  data: $('#add_rfa_form').serialize(),
                  dataType: 'json',
                  beforeSend: function () {
                     $('.btn-add-rfa').html('<div class="loader"></div>');
                     $('.btn-add-rfa').prop("disabled", true);
                  },
                  headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                  },
                  success: function (data) {
                     if (data.response) {
                        $('#add_rfa_form')[0].reset();
                        $('.btn-add-rfa').prop("disabled", false);
                        $('.btn-add-rfa').text('Submit');
                        toast_message_success(data.message)
                        $('a.form-wizard-previous-btn').click();
                        $('#request_table').DataTable().destroy();
                        rfa_transactions();
                     } else {
                        $('.btn-add-rfa').prop("disabled", false);
                        $('.btn-add-rfa').text('Submit');
                        toast_message_error(data.message)
                        $('a.form-wizard-previous-btn').click();
                     }
                     get_last_reference_number();
                  },
                  error: function (xhr) {
                     alert("Error occured.please try again");
                     $('.btn-add-rfa').prop("disabled", false);
                     $('.btn-add-rfa').text('Submit');
                     // location.reload();
                  },
               })
            } else if (result.dismiss === "cancel") {
               swal.close()
            }
         });
      }
   });


   $(document).ready(function () {
      rfa_transactions();
      get_last_reference_number();
   });


</script>

</html>