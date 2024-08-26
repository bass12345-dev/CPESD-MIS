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
                                @include('systems.pmas.user.pages.update.sections.view_transaction')
                            </div>
                        </section>
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
<script type="text/javascript" src="{{ asset('pmas_rfa/tinymce/tinymce.js')}}"></script>
<script>

    function load_transaction_data() {
        $.ajax({
            type: "POST",
            url: base_url + '/user/act/pmas/get-transaction-data',
            data: {
                'id': $('input[name=transact_id]').val()
            },
            cache: false,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
                if (data) {
                    // load_notes(data.annotations);
                    $('#project_section').attr('hidden', 'hidden');
                    $('#training_section').attr('hidden', 'hidden');
                    $('#meeting_section').attr('hidden', 'hidden');
                    $('input[name=transaction_id]').val(data.transaction_id);
                    $('input[name=update_pmas_number]').val(data.number);
                    $('input[name=update_year]').val(data.year);
                    $('input[name=update_month]').val(data.month);
                    $('select[name=update_responsible_section_id]').val(data.responsible_section_id);
                    $('select[name=update_type_of_activity_id]').val(data.type_of_activity_id);
                    $('select[name=update_responsibility_center_id]').val(data.responsibility_center_id).trigger('change');
                    $('select[name=update_cso_id]').val(data.cso_id).trigger('change');
                    $('input[name=update_date_and_time]').val(data.date_and_time);
                    $('input[name=update_select_under_type_id]').val(data.under_type_of_activity);
                    $('.pmas_no').text(data.pmas_no);
                    $('.date_and_time_filed').text(data.date_and_time_filed);
                    $('.responsible_section_name').text(data.responsible_section_name);
                    $('.type_of_activity_name').text(data.type_of_activity_name + ' - ' + data.under_type_activity);
                    $('.responsibility_center_name').text(data.responsibility_center_name);
                    $('.cso_name').text(data.cso_name);
                    $('.date_and_time').text(data.date_time);
                    $('.annotations').html(data.annotations);
                    $('.last_updated').html(data.last_updated);
                    if (data.training_data.length > 0) {
                        $('#under_type_activity_select').removeAttr('hidden').fadeIn("slow");
                        $('.for_training').removeAttr('hidden').fadeIn("slow");
                        $('.for_project_monitoring').attr('hidden', 'hidden');
                        $('.for_project_meeting').attr('hidden', 'hidden');
                        $('input[name=update_title_of_training]').val(data.training_data[0].title_of_training);
                        $('input[name=update_number_of_participants]').val(data.training_data[0].number_of_participants);
                        $('input[name=update_female]').val(data.training_data[0].female);
                        $('input[name=update_over_all_ratings]').val(data.training_data[0].overall_ratings);
                        $('input[name=update_name_of_trainor]').val(data.training_data[0].name_of_trainor);
                        $('#training_section').removeAttr('hidden');
                        $('#project_section').attr('hidden', 'hidden');
                        $('#meeting_section').attr('hidden', 'hidden');
                        $('.title_of_training').text(data.training_data[0].title_of_training);
                        $('.number_of_participants').text(data.training_data[0].number_of_participants);
                        $('.female').text(data.training_data[0].female);
                        $('.male').text(data.training_data[0].male);
                        $('.over_all_ratings').text(data.training_data[0].overall_ratings);
                        $('.name_of_trainor').text(data.training_data[0].name_of_trainor);
                    }
                    if (data.project_monitoring_data.length > 0) {
                        $('#under_type_activity_select').attr('hidden', 'hidden');
                        $('.for_training').attr('hidden', 'hidden');
                        $('.for_project_monitoring').removeAttr('hidden').fadeIn("slow");
                        $('.for_project_meeting').attr('hidden', 'hidden');
                        $('input[name=update_project_title]').val(data.project_monitoring_data[0].project_title);
                        $('input[name=update_period]').val(data.project_monitoring_data[0].period);
                        $('input[name=update_present]').val(data.project_monitoring_data[0].present);
                        $('input[name=update_absent]').val(data.project_monitoring_data[0].absent);
                        $('input[name=update_delinquent]').val(data.project_monitoring_data[0].delinquent);
                        $('input[name=update_overdue]').val(data.project_monitoring_data[0].overdue);
                        $('input[name=update_total_production]').val(data.project_monitoring_data[0].total_production);
                        $('input[name=update_total_collection]').val(data.project_monitoring_data[0].total_collection_sales.replace(",", ""));
                        $('input[name=update_total_released]').val(data.project_monitoring_data[0].total_released_purchases.replace(",", ""));
                        $('input[name=update_total_deliquent]').val(data.project_monitoring_data[0].total_delinquent_account.replace(",", ""));
                        $('input[name=update_total_overdue]').val(data.project_monitoring_data[0].total_over_due_account.replace(",", ""));
                        $('input[name=update_cash_in_bank]').val(data.project_monitoring_data[0].cash_in_bank.replace(",", ""));
                        $('input[name=update_cash_on_hand]').val(data.project_monitoring_data[0].cash_on_hand.replace(",", ""));
                        $('input[name=update_inventories]').val(data.project_monitoring_data[0].inventories.replace(",", ""));
                        $('#training_section').attr('hidden', 'hidden');
                        $('#project_section').removeAttr('hidden');
                        $('#meeting_section').attr('hidden', 'hidden');
                        $('.project_title').text(data.project_monitoring_data[0].project_title);
                        $('.period').text(data.project_monitoring_data[0].period);
                        $('.present').text(data.project_monitoring_data[0].present);
                        $('.absent').text(data.project_monitoring_data[0].absent);
                        $('.delinquent').text(data.project_monitoring_data[0].delinquent);
                        $('.overdue').text(data.project_monitoring_data[0].overdue);
                        $('.total_production').text(data.project_monitoring_data[0].total_production);
                        $('.total_collection_sales').text('₱ ' + data.project_monitoring_data[0].total_collection_sales);
                        $('.total_released_purchases').text('₱ ' + data.project_monitoring_data[0].total_released_purchases);
                        $('.total_delinquent_account').text('₱ ' + data.project_monitoring_data[0].total_delinquent_account);
                        $('.total_over_due_account').text('₱ ' + data.project_monitoring_data[0].total_over_due_account);
                        $('.cash_in_bank').text('₱ ' + data.project_monitoring_data[0].cash_in_bank);
                        $('.cash_on_hand').text('₱ ' + data.project_monitoring_data[0].cash_on_hand);
                        $('.inventories').text('₱ ' + data.project_monitoring_data[0].inventories);
                        $('.total_volume_of_business').text('₱ ' + data.project_monitoring_data[0].total_volume_of_business);
                        $('.total_cash_position').text('₱ ' + data.project_monitoring_data[0].total_cash_position);
                    }
                    if (data.project_meeting_data.length > 0) {
                        $('#update_under_type_activity_select').attr('hidden', 'hidden');
                        $('.for_training').attr('hidden', 'hidden');
                        $('.for_project_monitoring').attr('hidden', 'hidden');
                        $('.for_project_meeting').removeAttr('hidden').fadeIn("slow");
                        $('input[name=update_meeting_present]').val(data.project_meeting_data[0].meeting_present);
                        $('input[name=update_meeting_absent]').val(data.project_meeting_data[0].meeting_absent);
                        $('#training_section').attr('hidden', 'hidden');
                        $('#project_section').attr('hidden', 'hidden');
                        $('#meeting_section').removeAttr('hidden');
                        $('.meeting_present').text(data.project_meeting_data[0].meeting_present);
                        $('.meeting_absent').text(data.project_meeting_data[0].meeting_absent);
                    }
                }
            }
        });
    }
    load_transaction_data();

</script>

</html>