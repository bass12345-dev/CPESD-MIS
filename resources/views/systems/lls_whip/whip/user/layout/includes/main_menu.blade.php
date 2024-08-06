    <!-- Main Menu area start-->
    <div class="main-menu-area mg-tb-40">
        <div class="container">
            <div class="row">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <ul class="nav nav-tabs notika-menu-wrap menu-it-icon-pro">
                        <li><a data-toggle="tab" href="#Home1"><i class="notika-icon notika-house"></i> Home</a>
                        </li>
                        <li><a data-toggle="tab" href="#mailbox1"><i class="notika-icon notika-mail"></i>Contractors</a>
                        </li>
                        <li><a data-toggle="tab" href="#all_projects"><i class="notika-icon notika-mail"></i>Projects</a>
                        </li>
                        <li><a data-toggle="tab" href="#positions"><i class="notika-icon notika-mail"></i>Positions</a>
                        </li>
                        <li><a data-toggle="tab" href="#employees"><i class="notika-icon notika-mail"></i>Employees Record</a>
                        </li>
                        <li><a data-toggle="tab" href="#compliant"><i class="notika-icon notika-mail"></i>Compliant</a>
                        </li>

                    </ul>
                    <div class="tab-content custom-menu-content">
                        <div id="Home1" class="tab-pane in active notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="{{url('user/whip/dashboard')}}">Dashboard</a>
                                </li>
                                <li><a href="analytics.html">Analytics</a>
                                </li>

                            </ul>
                        </div>
                        <div id="mailbox1" class="tab-pane notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="{{url('user/whip/add-new-contractor')}}">Add New</a>
                                </li>
                                <li><a href="{{url('admin/whip/contractors-list')}}">Contractors List</a>
                                </li>

                            </ul>
                        </div>
                        <div id="all_projects" class="tab-pane notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="{{url('admin/whip/add-new-project')}}">Add New</a>
                                </li>
                                <li><a href="{{url('admin/whip/projects-list')}}">Projects List</a>
                                </li>
                            </ul>
                        </div>
                        <div id="positions" class="tab-pane notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="{{url('admin/whip/whip-positions')}}">Manage Positions</a>
                                </li>
                            </ul>
                        </div>
                        <div id="employees" class="tab-pane notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="{{url('admin/whip/employees-record')}}">Manage Employees Record</a>
                                </li>
                            </ul>
                        </div>
                        <div id="compliant" class="tab-pane notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="{{url('admin/whip/compliant-reports')}}">Compliant Report</a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <hr>
    </div>

    <!-- Main Menu area End-->