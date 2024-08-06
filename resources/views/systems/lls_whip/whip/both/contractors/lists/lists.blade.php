
@extends('systems.lls_whip.whip.'.session('user_type').'.layout.'.session('user_type').'_master')
@section('title', $title)
@section('content')
@include('systems.lls_whip.whip.both.contractors.lists.sections.table')
@endsection
@section('js')
@endsection