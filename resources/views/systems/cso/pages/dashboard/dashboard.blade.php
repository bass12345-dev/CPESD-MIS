@extends('systems.cso.layout.cso_master')
@section('title', $title)
@section('content')
@include('systems.pmas.includes.components.count_coops')
<div class="row">
@include('systems.cso.pages.dashboard.sections.graph1')
@include('systems.cso.pages.dashboard.sections.graph2')
</div>
@include('systems.cso.pages.dashboard.sections.cso_per_barangay')
@endsection
@section('js')
<script>
 
</script>
@endsection