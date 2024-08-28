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
                    <div class="col-12 mt-5">
                        <div class="card border">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn sub-button pull-right mb-3 " data-toggle="modal" data-target="#print_option_modal"><i class="fa fa-print"></i> Print</button>
                                    </div>
                                </div>
                                <div class="row">

                                    @include('systems.cso.pages.view_cso.sections.cso_information')
                                    @include('systems.cso.pages.view_cso.sections.cso_officers')

                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</body>
@include('global_includes.js.global_js')
@include('systems.rfa.includes.js')
<script src="https://cdn.jsdelivr.net/npm/js-loading-overlay@1.1.0/dist/js-loading-overlay.min.js"></script>
@include('systems.rfa.includes.custom_js.layout_js')
@include('global_includes.js.custom_js.wizard_js')
@include('global_includes.js.custom_js.alert_loader')

<script>
    function get_cso_information() {

        $.ajax({
            type: "POST",
            url: base_url + '/user/act/cso/get-cso-infomation',
            data: {
                'id': $('input[name=cso_id]').val()
            },
            cache: false,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(data) {
                $('.cso_code').text(data.cso_code)
                $('.cso_name').text(data.cso_name)
                $('.cso_address').text(data.address)
                $('.contact_person').text(data.contact_person)
                $('.contact_number').text(data.contact_number)
                $('.telephone_number').text(data.telephone_number)
                $('.email').text(data.email_address)
                $('.classification').html('<span class="status-p sub-button">' + data.type_of_cso + '<span>')
                $('.cso_status').html(data.cso_status + ' ' + '<a href="javascript:;" data-id="' + data.cso_id + '" data-status="' + data.status + '"  id="update-cso-status"  class=" text-center ml-3  btn-rounded  pull-right"><i class = "fa fa-edit" aria-hidden = "true"></i> Update Status</a>')
                $('#update-cso-information').data('id', data.cso_id);



                $('input[name=cso_idd]').val(data.cso_id);
                $('input[name=cso_name]').val(data.cso_name);
                $('input[name=cso_code]').val(data.cso_code);
                // $('#cso_type option[value='+data.type_of_cso.toString().toLowerCase()+']').attr('selected','selected'); 
                $('input[name=purok]').val(data.purok_number);
                $('select[name=barangay]').val(data.barangay);
                $('select[name=cso_type]').val(data.type_of_cso);


                $('input[name=contact_person]').val(data.contact_person);
                $('input[name=contact_number]').val(data.contact_number);
                $('input[name=telephone_number]').val(data.telephone_number);
                $('input[name=email_address]').val(data.email_address);






            }

        })

    }

    function load_cso_officers() {

        $.ajax({
            url: base_url + '/user/act/cso/get-officers',
            type: "POST",
            data: {
                cso_id: $('input[name=cso_id]').val()
            },
            dataType: "json",
            success: function(data) {
                $('#officers_table').DataTable({
                    scrollY: 500,
                    scrollX: true,
                    "ordering": false,
                    "data": data,
                    "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [{
                            extend: 'excel',
                            text: 'Excel',
                            className: 'btn btn-danger',
                            exportOptions: {
                                columns: 'th:not(:last-child)'
                            }
                        },
                        {
                            extend: 'pdf',
                            text: 'pdf',
                            className: 'btn btn-default',
                            exportOptions: {
                                columns: 'th:not(:last-child)'
                            }
                        },

                        {
                            extend: 'print',
                            text: 'print',
                            className: 'btn btn-default',
                            exportOptions: {
                                columns: 'th:not(:last-child)'
                            }
                        },

                    ],
                    'columns': [{
                            data: null,
                            render: function(data, type, row) {
                                return row.name;
                            }

                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return row.title;
                            }

                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return row.contact_number;
                            }

                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return row.email_address;
                            }

                        },
                        {
                            // data: "song_title",
                            data: null,
                            render: function(data, type, row) {
                                return '<ul class="d-flex justify-content-center">\
                          <li class="mr-3 ">\
                          <a href="javascript:;" class="text-secondary action-icon" \
                          data-id="' + data['cso_officer_id'] + '"  \
                          data-position="' + data['position'] + '"  \
                          data-first-name="' + data['first_name'] + '"  \
                          data-middle-name="' + data['middle_name'] + '"  \
                          data-last-name="' + data['last_name'] + '"  \
                          data-extension="' + data['extension'] + '"  \
                          data-contact="' + data['contact_number'] + '"  \
                          data-email="' + data['email_address'] + '"  \
                          id="update-cso-officer"><i class="fa fa-edit"></i></a></li>\
                          <li class="mr-3 ">\
                          <a href="javascript:;" class="text-danger action-icon" \
                          data-id="' + data['cso_officer_id'] + '"  \
                          id="delete-cso-officer"><i class="fa fa-trash"></i></a></li>\
                          </ul>';
                            }

                        },
                    ]

                })

            }


        });


    }
    $(document).ready(function() {
        get_cso_information();
    })
</script>

</html>