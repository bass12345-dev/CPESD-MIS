@extends('systems.lls_whip.whip.user.layout.user_master')
@section('title', $title)
@section('content')
<style>
    .b {
        background-color: #121212;

    }

    .wb-traffic-inner {
        border-radius: 28px;
        padding: 30px 20px;
        overflow: hidden;
        position: relative;
    }

    .website-traffic-ctn span,
    p {
        color: #fff;
    }

    .website-traffic-ctn p {
        color: #fff;
    }

    .ag-courses-item {
        height: 128px;
        width: 128px;
       

        z-index: 1;
        position: absolute;
        top: -75px;
        right: -75px;

        border-radius: 50%;

        -webkit-transition: all .5s ease;
        -o-transition: all .5s ease;
        transition: all .5s ease;
    }

    .bg1 {
        background-color: #f9b234;
    }
    .bg2 {
        background-color: #3ecd5e;
    }
    .bg3 {
        background-color: #e44002;
    }

    .wb-traffic-inner:hover .website-traffic-ctn {
        z-index: 1;

    }

    .wb-traffic-inner:hover .ag-courses-item {
        -webkit-transform: scale(10);
        -ms-transform: scale(10);
        transform: scale(10);

    }
</style>
<div class="notika-status-area " style="margin-bottom: 20px;">
    <div class="container ">
        <div class="row dash" style="margin-bottom: 20px;">
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 ">
                <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30 b ">
                    <div class="ag-courses-item bg1 "></div>
                    <div class="website-traffic-ctn">
                        <h2><span class="counter">{{$count_contractors}}</span></h2>
                        <p>Contractors</p>
                    </div>

                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30 b">
                    <div class="ag-courses-item bg2"></div>
                    <div class="website-traffic-ctn">
                        <h2><span class="counter">{{$pending_projects}}</span></h2>
                        <p>Pending Projects</p>
                    </div>

                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30 dk-res-mg-t-30 b">
                    <div class="ag-courses-item bg3"></div>
                    <div class="website-traffic-ctn">
                        <h2><span class="counter">{{$completed_projects}}</span></h2>
                        <p>Pending Projects</p>
                    </div>

                </div>
            </div>
        </div>

        <div class="row dash">
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 ">
                <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30 b ">
                    <div class="ag-courses-item bg1 "></div>
                    <div class="website-traffic-ctn">
                        <h2><span class="counter">{{$count_whip_positions}}</span></h2>
                        <p>Positions</p>
                    </div>

                </div>
            </div>

    
            

        </div>

    </div>
</div>
@endsection
@section('js')
@endsection