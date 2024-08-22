@extends('systems.watchlisted.user.layout.user_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
@include('systems.watchlisted.both.add.add_form')
@endsection
@section('js')
<script>

$('#add_form').on('submit', function (e) {
        e.preventDefault();
        $(this).find('button').prop('disabled', true);
        $(this).find('button').html('<div class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>')
        var url = '/user/act/watchlisted/i-p';
        let form = $(this);
        _insertAjax(url, form, table);
       
    });

</script>
@endsection