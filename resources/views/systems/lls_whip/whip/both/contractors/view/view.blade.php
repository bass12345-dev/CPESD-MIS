@extends('systems.lls_whip.whip.' . session('user_type') . '.layout.' . session('user_type') . '_master')
@section('title', $title)
@section('content')
<div class="notika-status-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                @include('systems.lls_whip.whip.both.contractors.view.sections.information')
            </div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                <div class="row">
                    @include('systems.lls_whip.whip.both.contractors.view.sections.count_section')
                </div>
                <div class="row">
                    @include('systems.lls_whip.whip.both.contractors.view.sections.graph')
                </div>

            </div>

        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            @include('systems.lls_whip.whip.both.contractors.view.sections.projects_table')
        </div>

    </div>
</div>


@endsection
@section('js')

<script>
    var information_table = $('#table-information');
    $(document).on('click', 'button.edit-information', function() {

        information_table.find('textarea').removeClass('hidden');
        information_table.find('input[type=hidden]').prop("type", "text");
        information_table.find('select').attr('hidden', false)
        information_table.find('span.title1').attr('hidden', true);
        $('.cancel-edit').removeClass('hidden');
        $('.submit').removeClass('hidden');
        $(this).addClass('hidden');
    });

    $(document).on('click', 'button.cancel-edit', function() {
        information_table.find('textarea').addClass('hidden');
        information_table.find('input[type=text]').prop("type", "hidden");
        information_table.find('span.title1').attr('hidden', false);
        information_table.find('select').attr('hidden', true)
        $(this).addClass('hidden');
        $('.submit').addClass('hidden');
        $('button.edit-information').removeClass('hidden');
    });
    $(document).ready(function() {
        $('button.edit-information').prop('disabled', false);
    });

    $(document).ready(function() {
        table = $('#data-table-basic').DataTable({
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
                url: base_url + "/user/act/whip/g-c-p",
                method: 'POST',
                data: {
                    id: $('input[name=contractor_id]').val(),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                dataSrc: "",
                error: function(xhr, textStatus, errorThrown) {
                    toast_message_error('Contractor Projects is not displaying... Please Reload the Page')
                }
            },
            columns: [

                {
                    data: 'i'
                },
                {
                    data: 'project_title'
                },

                {
                    data: 'project_cost'
                },
                {
                    data: 'project_location'
                },
                {
                    data: 'project_nature'
                },
                {
                    data: 'date_started'
                },
                {
                    data: 'date_completed'
                },
                {
                    data: null
                }
            ],

            columnDefs: [{
                    targets: 1,
                    data: null,
                    render: function(data, type, row) {
                        return '<a href="' + base_url + '/{{session("user_type")}}/whip/project-information/' + row.project_id + '" data-toggle="tooltip" data-placement="top" title="View ' + row.project_title + '">' + row.project_title + '</a>';
                    }
                },
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return row.project_status == 'completed' ?
                            '<span class="badge notika-bg-success">Completed</span>' :
                            '<span class="badge notika-bg-danger">Ongoing</span>';
                    }
                }
            ]


        });


    });

    function load_projects_per_barangay() {

        var id = $('input[name= contractor_id]').val();
        $.ajax({
            url: base_url + "/user/act/whip/g-p-p-b/" + id,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                try {
                    new Chart(document.getElementById("projects-chart"), {
                        type: 'bar',
                        data: {
                            labels: data.label,
                            datasets: [{
                                        label: 'Completed Projects',
                                        backgroundColor: "rgb(5, 176, 133)",
                                        borderColor: 'rgb(23, 125, 255)',
                                        data:  data.data_completed
                                    }, {
                                        label: 'Ongoing Projects',
                                        backgroundColor: 'rgb(216, 88, 79)',
                                        borderColor: 'rgb(23, 125, 255)',
                                        data:  data.data_ongoing
                                    }]
                        },
                        options: {
                            legend: {
                                position: 'top',
                                labels: {
                                    padding: 10,
                                    fontColor: '#007bff',
                                }
                            },
                            responsive: true,
                            title: {
                                display: true,
                                text: 'Projects Per Barangay'
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                        }

                    });
                } catch (error) {}
            },
            error: function(xhr, status, error) {

                toast_message_error('Contractor\'s Projects Chart is not displaying... Please Reload the Page')
            },
        });
    }

    load_projects_per_barangay();
</script>
@endsection