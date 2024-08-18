@extends('systems.dts.receiver.layout.receiver_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
@include('systems.dts.receiver.pages.incoming.sections.table')
@include('systems.dts.includes.components.final_action_off_canvas')
@endsection
@section('js')
<script>

    document.addEventListener("DOMContentLoaded", function () {
        table = $("#datatable_with_select").DataTable({
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
                url: base_url + "/receiver/act/dts/g-r-i-d",
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                dataSrc: "",
                error: function (xhr, textStatus, errorThrown) {
                    toast_message_error('Documents is not displaying... Please Reload the Page Or Contact the developer')
               }
            },
            columns: [{
                data: 'data',
            }, 
            
            // {
            //     data: null,
            // },
            {
                data: 'number'
            },
            {
                data: 'tracking_number'
            }, {
                data: null
            }, {
                data: 'from'
            }, {
                data: 'type_name'
            }, {
                data: 'remarks'
            }, {
                data: 'released_date'
            },],
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
                // {
                //     targets: 1,
                //     data: null,
                //     render: function (data, type, row) {
                //         return ' <a class="btn btn-success received_document" data-track="' + row.tracking_number + '"  data-id="' + row.history_id + '"><i class="fas fa-hand"></i></a> ';
                //     }
                // },
                {
                    targets: 3,
                    data: null,
                    render: function (data, type, row) {
                        return '<a href="' + base_url + '/dts/user/view?tn=' + row.tracking_number + '" data-toggle="tooltip" data-placement="top" title="View ' + row.tracking_number + ' ?>">' + row.document_name + '</a>';
                    }
                }
            ]
        });
    });



    var myOffcanvas = document.getElementById('offcanvasExample1');
    var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);

    $(document).on('click', 'button#complete', function () {
        let array = get_select_items_datatable();
        let html = '';
        let arr = [];
        if (array.length > 0) {
            bsOffcanvas.show();

            $('input[name=user_type]').val('receiver');
            array.forEach(element => {
                const myArray = element.split(",");
                const first = myArray[0];
                const second = myArray[1];
                arr.push(first + '-' + second);

                html += '<li class="text-danger h3">' + second + '</li>';
            });
            $('input[name=c_t_number]').val(arr);
            $('.display_tracking_number2').html(html);
        } else {
            toast_message_error('Please Select at least One')
        }
    });

</script>
@include('systems.dts.includes.custom_js.complete_action')
@endsection