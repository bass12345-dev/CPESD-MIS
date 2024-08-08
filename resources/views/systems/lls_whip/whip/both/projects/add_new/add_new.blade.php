@extends('systems.lls_whip.whip.' . session('user_type') . '.layout.' . session('user_type') . '_master')
@section('title', $title)
@section('content')
@include('systems.lls_whip.whip.both.projects.add_new.sections.form')
@endsection
@section('js')
@include('systems.lls_whip.includes.custom_js.location_js')
<script>
    $('input[name=contractor]').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, {
        name: 'Contractor',
        source: function (query, process, processAsync) {

            return $.ajax({
                url: base_url + '/user/act/whip/search-query?key=' + $('input[name="contractor"]').val(),
                type: 'GET',
                dataType: 'json',
                success: function (data) {

                    processAsync($.map(data, function (row) {
                        return [{
                            'contractor_id': row.contractor_id,
                            'contractor_name': capitalizeFirstLetter(row.contractor_name)
                        }];
                    }));
                },
                error: function (jqXHR, except) { }
            });

        },
        name: 'contractor',
        displayKey: 'contractor_name',
        templates: {
            header: '<div class="header-typeahead">Employees</div>',
            empty: [
                '<div class="tt-suggestion tt-selectable">No Record <i class="fa-regular fa-face-sad-tear"></i> </div>'
            ].join('\n'),
            suggestion: function (data) {
                return '<li>' + data.contractor_name + '</li>'
            }
        },
    }).bind('typeahead:selected', function (obj, data, name) {
        $('input[name="contractor_id"]').val(data.contractor_id);
        $('input[name="contractor"]').val(data.contractor);
    });
    $('#add_form').on('submit', function (e) {
        e.preventDefault();
        if($('input[name=contractor_id]').val() == null){
            toast_message_error('Please Seach Contractor');
        }else {
            table = null;
        $(this).find('button').prop('disabled', true);
        $(this).find('button').html('<span class="loader"></span>')
        var url = '/user/act/whip/insert-project';
        let form = $(this);
        _insertAjax(url, form, table);
        }
       

    });

</script>
@endsection