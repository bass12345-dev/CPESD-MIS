@extends('systems.lls_whip.whip.user.layout.user_master')
@section('title', $title)
@section('content')
<div class="notika-status-area">
    <div class="container">
        <div class="row">
            @include('systems.lls_whip.whip.user.pages.project_monitoring.view_monitoring.sections.monitoring_information')
        </div>
        <hr>
    </div>
</div>

@endsection
@section('js')
<script>


</script>
@endsection