@extends('systems.rfa.user.layout.user_master')
@section('title', $title)
@section('content')
<div class="main-content-inner">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card" style="border: 1px solid;">
                <div class="card-body">

                    <div class="row">
                        @include('systems.rfa.user.pages.completed.sections.table')
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
@section('js')
<script>


</script>
@endsection