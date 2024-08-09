@extends('systems.lls_whip.whip.user.layout.user_master')
@section('title', $title)
@section('content')
<div class="notika-status-area">
    <div class="container">
        <div class="row">
            @include('systems.lls_whip.whip.user.pages.project_monitoring.view_monitoring.sections.monitoring_information')
        </div>
        <hr>
        <div class="row">
        @include('systems.lls_whip.whip.user.pages.project_monitoring.view_monitoring.sections.employee_table')
        </div>
    </div>
</div>
@include('systems.lls_whip.whip.user.pages.project_monitoring.view_monitoring.modals.add_update_employee_modal')
@endsection
@section('js')
@include('systems.lls_whip.includes.custom_js.typeahead_search_employee')
<script>
    var information_table = $('#table-information');
    $(document).on('click', 'button.edit-information', function () {

        information_table.find('textarea').removeClass('hidden');
        information_table.find('input[name=date_of_monitoring]').prop("type", "date");
        information_table.find('select').attr('hidden', false)
        information_table.find('span.title1').attr('hidden', true);
        $('.cancel-edit').removeClass('hidden');
        $('.submit').removeClass('hidden');
        $(this).addClass('hidden');
    });

    $(document).on('click', 'button.cancel-edit', function () {
        information_table.find('textarea').addClass('hidden');
        information_table.find('input[name=date_of_monitoring]').prop("type", "hidden");
        information_table.find('span.title1').attr('hidden', false);
        information_table.find('select').attr('hidden', true)
        $(this).addClass('hidden');
        $('.submit').addClass('hidden');
        $('button.edit-information').removeClass('hidden');
    });
    $(document).ready(function () {
        $('button.edit-information').prop('disabled', false);
    });

    $(document).on('click', 'button.submit', function() {
        let form = {
            project_monitoring_id: $('input[name=project_monitoring_id]').val(),
            date_of_monitoring: $('input[name=date_of_monitoring]').val(),
            specific_activity: $('textarea[name=specific_activity]').val(),
            annotations: $('textarea[name=annotations]').val(),
        }

        $.ajax({
            url: base_url + '/user/act/whip/u-p-m',
            method: 'POST',
            data: form,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            beforeSend: function() {
                $('button.submit').prop('disabled', true);
                $('button.submit').html('<span class="loader"></span>')
            },
            success: function(data) {
                if (data.response) {
                    toast_message_success(data.message);
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            },
            error: function(err) {
                toast_message_error('Server Error');
                setTimeout(() => {
                        location.reload();
                    }, 1500);
            }


        });
    });


    
    $('#add_update_form').on('submit', function(e) {
        e.preventDefault();

        $(this).find('button[type="submit"]').prop('disabled', true);
        $(this).find('button[type="submit"]').html('<span class="loader"></span>')
        var url = '/user/act/whip/i-u-p-e';
        let form = $('#add_update_form');
        var status = $('select[name=employment_status] :selected').val();

        if (!form.find('input[name=project_monitoring_id]').val()) {
            _insertAjax(url, form, table);
        } else {
            _updatetAjax(url, form, table);
        }

        // setTimeout(() => {

        //     load_positions_chart();
        //     load_gender_outside_chart();
        //     load_gender_inside_chart();
        // }, 1000);


    });



    $(document).ready(function() {
        table = $('#data-table-basic').DataTable({
            responsive: true,
            ordering: false,
            processing: true,
            searchDelay: 500,
            pageLength: 25,
            language: {
                "processing": '<div class="d-flex justify-content-center "><img class="top-logo mt-4" src="{{asset("assets/img/dts/peso_logo.png")}}"></div>'
            },
            "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
                "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: datatables_buttons(),
            ajax: {
                url: base_url + "/user/act/whip/g-a-p-e",
                method: 'POST',
                data: {
                    id: $('input[name=project_monitoring_id]').val(),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                dataSrc: "",
                error: function(xhr, textStatus, errorThrown) {
                    toast_message_error('Employees List is not displaying... Please Reload the Page')
                }
            },
            columns: [{
                    data: 'project_employee_id'
                },

                {
                    data: null
                },
                {
                    data: null
                },
                {
                    data: 'full_address'
                },
                {
                    data: 'position'
                },
                {
                    data: null
                },
                {
                    data: 'status_of_employment'
                },
                
                {
                    data: null
                },
                {
                    data: null
                },
            ],
            'select': {
                'style': 'multi',
            },
            columnDefs: [{
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true
                    }
                },

                {
                    targets: 1,
                    data: null,
                    orderable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return '<a href="' + base_url + '/admin/lls/employee/' + row.employee_id +
                            '">' + row.full_name + '</a>';

                    }
                },
                {
                    targets: 2,
                    data: null,
                    orderable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return capitalizeFirstLetter(row.gender);

                    }
                },

                {
                    targets: 5,
                    data: null,
                    orderable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return capitalizeFirstLetter(row.nature_of_employment);

                    }
                },
                {
                    targets: -2,
                    data: null,
                    orderable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        var result = row.level_of_employment.replaceAll('_', ' ');
                        return capitalizeFirstLetter(result);

                    }
                },

                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        //return '<button class="btn btn-success">Update</button> <button class="btn btn-success">Delete</button>';
                        return '<div class="actions">\
                                <div ><button class="btn btn-success update-establishment-employee" data-toggle="modal" data-target="#add_employee_modal" \
                                data-id="' + row.project_employee_id + '"\
                                data-employee-id="' + row.employee_id + '"\
                                data-employee-name="' + row.full_name + '"\
                                data-nature="' + row.nature_of_employment + '"\
                                data-position="' + row.position_id + '"\
                                data-status="' + row.status_id + '"\
                                data-start="' + row.start_date + '"\
                                data-end="' + row.end_date + '"\
                                data-level="' + row.level_of_employment + '"\
                                ><i class="fas fa-pen"></i></button> </div>\
                                </div>\
                                ';
                    }
                }
            ]

        });
    });

</script>
@endsection