@extends('systems.lls_whip.whip.user.layout.user_master')
@section('title', $title)
@section('content')
@include('systems.lls_whip.whip.user.pages.project_monitoring.approved_list.sections.table')
@endsection
@section('js')
@include('global_includes.js.custom_js.select_by_month')
<script>

</script>
@endsection