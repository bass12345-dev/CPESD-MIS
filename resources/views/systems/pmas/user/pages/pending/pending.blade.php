@extends('systems.pmas.user.layout.user_master')
@section('title', $title)
@section('content')
<div class="row">
    <div class="col-12 mt-5">
        <div class="card" style="border: 1px solid;">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn  mb-3 mt-2 sub-button pull-right mr-2" id="reload_user_pending_transaction">
                            Reload <i class="ti-loop"></i></button>
                    </div>
                </div>
                <div class="row">
                    @include('systems.pmas.user.pages.pending.sections.table')
                </div>
            </div>
        </div>
    </div>
</div>
@include('systems.pmas.user.pages.pending.modals.view_remarks_modal')
@include('systems.pmas.user.pages.pending.modals.pass_to_modal')
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/js-loading-overlay@1.1.0/dist/js-loading-overlay.min.js"></script>
<script>

    $(document).on('click', 'button#reload_user_pending_transaction', function (e) {
        $('#pending_transactions_table').DataTable().destroy();
        fetch_user_pending_transactions();

        JsLoadingOverlay.show({
            'overlayBackgroundColor': '#666666',
            'overlayOpacity': 0.6,
            'spinnerIcon': 'pacman',
            'spinnerColor': '#000',
            'spinnerSize': '2x',
            'overlayIDName': 'overlay',
            'spinnerIDName': 'spinner',
        });

    });

    function fetch_user_pending_transactions() {
        $.ajax({
            url: base_url + '/user/act/pmas/get-user-pending-transactions',
            type: "GET",
            dataType: "json",
            success: function (data) {
                JsLoadingOverlay.hide();
                $('#pending_transactions_table').DataTable({
                    scrollY: 800,
                    scrollX: true,
                    "ordering": false,
                    "data": data,
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
                            return '<a href="javascript:;"   data-id="' + data['res_center_id'] + '"  style="color: #000;"  >' + data['type_of_activity_name'] + '</a>';
                        }
                    }, {
                        data: null,
                        render: function (data, type, row) {
                            return '<a href="javascript:;"   data-id="' + data['res_center_id'] + '"  style="color: #000;"  >' + data['name'] + '</a>';
                        }
                    }, {
                        data: null,
                        render: function (data, type, row) {
                            return row.s;
                        }
                    }, {
                        data: null,
                        render: function (data, type, row) {
                            return row.action;
                        }
                    },]
                })
            }
        })
    }
    fetch_user_pending_transactions();
    $(document).on('click', 'a#pass_to', function (e) {

        $('.pass-to-title').text('PMAS NO ' + $(this).data('name'));
        $('input[name=pmas_id]').val($(this).data('id'));

    });

    $('#pass_to_form').on('submit', function (e) {
        e.preventDefault();

        var pass_to_id = $('#pass_to_id').find('option:selected').val();
        var button = $('.pass-button');

        if (pass_to_id == '') {
            alert('Please select user');
        } else {

            $.ajax({
                type: "POST",
                url: base_url + '/user/act/pmas/pass-pmas',
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function () {
                    button.html('<div class="loader"></div>');
                    button.prop("disabled", true);
                    loader()
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (data) {
                    if (data.response) {
                        $('#pass_to_form')[0].reset();
                        button.prop("disabled", false);
                        button.text('Submit');
                        toast_message_success(data.message)

                    } else {
                        button.prop("disabled", false);
                        button.text('Submit');
                        toast_message_success(data.message)

                    }
                    JsLoadingOverlay.hide();
                    $('#pass_to_modal').modal('hide');
                    $('#pending_transactions_table').DataTable().destroy();
                    fetch_user_pending_transactions();

                },
                error: function (xhr) {
                    alert("Error occured.please try again");
                    button.prop("disabled", false);
                    button.text('Submit');
                },
            })

        }
    });


</script>
@endsection