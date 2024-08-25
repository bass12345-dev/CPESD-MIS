<!doctype html>
<html class="no-js" lang="en">
<head>
    @include('global_includes.meta')
    @include('systems.rfa.includes.css')
    
</head>
<body>
    @include('components.pmas_rfa.preloader')
    <div class="page-container">       
        @include('systems.rfa.admin.layout.includes.sidebar')
        <div class="main-content">           
            @include('systems.rfa.includes.topbar')
                @include('components.pmas_rfa.breadcrumbs')
                <div class="main-content-inner">
                    @yield('content')
            </div>
        </div>
    </div>     
@include('global_includes.js.global_js')
@include('systems.rfa.includes.js')
@include('systems.rfa.includes.custom_js.layout_js')
@yield('js')
@include('global_includes.js.custom_js.datatable_settings')
@include('global_includes.js.custom_js.alert_loader')
@include('global_includes.js.custom_js._ajax')
@include('systems.rfa.includes.custom_js.count_total_pending_js')
</body>
</html>

