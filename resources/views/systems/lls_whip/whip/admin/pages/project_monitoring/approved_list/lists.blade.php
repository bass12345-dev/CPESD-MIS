@extends('systems.lls_whip.whip.admin.layout.admin_master')
@section('title', $title)
@section('content')
@include('systems.lls_whip.whip.admin.pages.project_monitoring.approved_list.sections.table')
@endsection
@section('js')
@include('systems.lls_whip.includes.custom_js.nature_js')

</script>
@endsection