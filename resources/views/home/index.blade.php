<!DOCTYPE html>
<html>

<head>
    @include('global_includes.meta')
    <link rel="shortcut icon" href="mis/peso_logo.png" />
    <link rel="stylesheet" type="text/css" href="{{asset('home_assets/home2.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <div class="header-top-area">
        <div class="greetings">
            <h3>Welcome {{session('user_type') == 'user' ? 'User' : 'Administrator  '}}!</h3>
        </div>
        <div class="cpesd">
            <h1>CPESD MIS</h1>
        </div>
        <div class="menu">
            <ul>
                <li><a href="{{url('/admin/sysm/dashboard')}}">System Management</a></l>
                <li><a href="#">My Profile</a></li>
                <li><a href="{{url('/logout')}}">Logout</a></li>
            </ul>
        </div>
    </div>
    <div class="bg-img">
        <img src="{{ asset('assets/img/peso_flag.jpg')}}">
    </div>
    <div class="welcome">
        <div class="welcome-container">
            <div class="left-welcome">
                <img class="top-logo " src="{{ asset('assets/logo/oroquieta_logo.png')}}">
                <img class="top-logo right-l" src=" {{ asset('assets/logo/peso_logo.png')}}">
            </div>
            <div class="middle-welcome">
                <p>Republic of the Philippines</p>
                <p class="office-city-mayor">Office of the City Mayor</p>
                <p class="oro">Oroquieta City</p>
                <p class="oro capital">The Capital of Misamis Occidental</p>
            </div>
            <div class="right-welcome">
                <img class="top-logo" src="{{ asset('assets/logo/bagong_pilipinas.png')}} ">
                <img class="top-logo" src="{{ asset('assets/img/dts/asenso_logo.png')}} ">
            </div>
        </div>
        <div class="below-header">
            <h2>Cooperative & Public Employment Service Division</h2>
        </div>
    </div>
    <div class="links">
        <div class="card-container">
            <a href="" class="card l-bg-orange-dark">
                <i class="fas fa-file"></i>
                <span>PMAS</span>
                <svg class="material-icons" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z" />
                </svg>
            </a>
            <a href="http://cpesd-infosys.wuaze.com/mis/" class="card l-bg-orange-dark">
                <i class="fas fa-file"></i>
                <span>RFA</span>
                <svg class="material-icons" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z" />
                </svg>
            </a>
            <a href="http://cpesd-is.rf.gd/watchlisted" class="card l-bg-cherry">
                <i class="fas fa-eye"></i>
                <span class="mr-2">Watchlisted </span>
                <svg class="material-icons" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z" />
                </svg>
            </a>
            <a href="{{url('/user/dts/dashboard')}}" class="card l-bg-blue-dark">
                <i class="fas fa-search"></i>
                <span>Document Tracker </span>
                <svg class="material-icons" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z" />
                </svg>
            </a>
            <a href="{{url($link . '/lls/dashboard')}}" class="card l-bg-blue-dark">
                <i class="fas fa-building"></i>
                <span>Labor Localization</span>
                <svg class="material-icons" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z" />
                </svg>
            </a>
            <a href="{{url($link . '/whip/dashboard')}}" class="card l-bg-blue-dark">
                <i class="fas fa-building"></i>
                <span>WHIP</span>
                <svg class="material-icons" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z" />
                </svg>
            </a>
        </div>
    </div>
</body>

</html>