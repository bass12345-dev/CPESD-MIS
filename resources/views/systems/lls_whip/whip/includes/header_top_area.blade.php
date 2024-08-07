    <!-- Start Header Top Area -->
    <div class="header-top-area">
        <div class="container">
            <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="header-top-menu">
                        <ul class="nav navbar-nav notika-top-nav">
                            <li class="nav-item dropdown">
                                <a href="{{url('/home')}}" ><i class="notika-icon notika-left-arrow"></i></></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div class="logo-area">
                        <a href="">
                            <h3>WHIP - {{session('user_type') == 'user' ? 'User' : 'Administrator  '}}</h3>
                            <!-- <img src="img/logo/logo.png" alt="" /> -->
                        </a>
                    </div>
                </div>
          
            </div>
        </div>
    </div>
    <!-- End Header Top Area -->