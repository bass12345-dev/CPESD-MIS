@extends('systems.watchlisted.admin.layout.admin_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
@include('systems.watchlisted.admin.pages.to_approved.sections.table')
@endsection
@section('js')
<script>

</script>
@endsection