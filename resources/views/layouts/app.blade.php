<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('facebook_meta')
      <meta property="og:title" content="{{ env('APP_NAME') }}" />
      <meta property="og:type" content="website" />
      <meta property="og:description" content="Bridgit:the social knowledge network" />
      <meta name="twitter:title" content="{{ env('APP_NAME') }}" />
      <meta name="twitter:type" content="website" />
      <meta name="twitter:description" content="Bridgit:the social knowledge network" />
    <title>{{ config('app.name', 'Bridgit') }}</title>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    {{-- <link href="{{ asset('css/bootstrap-switch.min.css') }}" rel="stylesheet"> --}}
    
    

</head>
<body>
    <div id="app">
        <div class="container p-0">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand" href="#"><img src="{{ asset('images/logo.png') }}" alt="logo" class="img-fluid"></a>
                <button class="navbar-toggler mt-3" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto custom-menu">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="http://bridgit.io/#beta">join beta</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="http://bridgit.io/#about">About</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="http://bridgit.io/#white-paper">Whitepaper</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="http://bridgit.io/#team">Team</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="http://bridgit.io/#bounties">Bounties</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="http://bridgit.io/blog/">Blog</a>
                            </li>
                            <li class="dropdown nav-item">
                                @include('auth.login')
                            </li>
                        @else
                            @if(Auth::user()->admin ==1)
                             <li class="nav-item login-nav-text">
                                <a class="dashboard-text" href="{{ url('messages') }}">Admin</a>
                            </li>
                            @endif
                            <li class="nav-item login-nav-text">
                                <a class="dashboard-text" href="{{url(str_replace(' ','-',Auth::user()->name).'/dashboard')}}">DASHBOARD</a>
                            </li>
                             <li class="nav-item login-nav-text">
                                <a class="dashboard-text" href="{{ route('search') }}">Search</a>
                            </li>
                            <li class="nav-item">
                                <div class="custom-nav-part">
                                    <svg id="Capa_1" x="0px" y="0px" width="30px" height="30px" viewBox="0 0 612 612" class="align-middle icon-search-menu">
                                        <g>
                                            <g id="Search">
                                                <g>
                                                    <path d="M382.5,0C255.759,0,153,102.759,153,229.5c0,53.034,18.149,101.707,48.367,140.568L8.415,563.021     C2.812,568.625,0,575.949,0,583.312c0,7.344,2.812,14.688,8.415,20.292C14,609.208,21.343,612,28.688,612     s14.688-2.792,20.272-8.396l192.971-192.972C280.793,440.851,329.467,459,382.5,459C509.241,459,612,356.241,612,229.5     S509.241,0,382.5,0z M382.5,401.625c-94.917,0-172.125-77.208-172.125-172.125c0-94.917,77.208-172.125,172.125-172.125     c94.917,0,172.125,77.208,172.125,172.125C554.625,324.417,477.417,401.625,382.5,401.625z" fill="#ee467a"/>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                            </li>
                            <li class="nav-item">
                                <div class="custom-nav-part">
                                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="custom-nav-part dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <div class="img-div">
                                        <img src="{{ Auth::user()->avatar }}" alt="logo" class="img-fluid">
                                    </div>
                                </a>
                                <div class="dropdown-menu user-profile-content" aria-labelledby="navbarDropdown">
                                    <div class="user-content">
                                        <div class="user-photo">
                                            <img src="{{ Auth::user()->avatar }}" alt="logo" class="img-fluid">
                                        </div>
                                        <div class="user-details ">
                                            <p class="user-name">{{ Auth::user()->name }}</p>
                                            <p class="user-email">{{ Auth::user()->email }}</p>
                                            <div class="log-detail mt-3">
                                                <a href="{{url(str_replace(' ','-',Auth::user()->name).'/profile/'.Auth::user()->id)}}">Profile</a>
                                                <a id= 'logout' href="{{ route('logout') }}">Logout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </nav>
        </div>
       <main class="py-4 top-search mt-2">
            @yield('content')
            <div class="modal modal-right fade" id="modal-right" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content w-900px" ></div>
            </div>
        </div>
        </main>
    </div>

    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="{{asset('js/summernote-bs4.js')}}"></script>
    <link href="{{ asset('css/summernote-bs4.css') }}" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    @yield('pageScript')
    <script>

    $("document").ready(function() {
        $('.signin').click(function(){
          //start ajax
            $('.alert-danger').html('');
            var email_id = $('#exampleInputEmail3').val();
            var password = $('#exampleInputPassword3').val();
            var id = $('#exampleInputEmail3').val();
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN':csrfToken
              }
            });
            $.ajax({
                url: '{{route('login')}}',
                type:"POST",
                data: {
                    email: email_id,password:password
                },
                dataType : 'json',
                success:function(data) {
                  location.reload();
                },error: function (request, response) {
                   if(typeof request.responseJSON !== 'undefined'){
                    $.each(request.responseJSON.errors, function(key, value){
                        console.log(value);
                        $('.alert-danger').show();
                        $('.alert-danger').append('<span>'+value+'</span><br>');
                    });
                   }else{location.reload();}
                }
            });
        })
      $('.dropdown-menu').on('click', function(e) {
          if($(this).hasClass('dropdown-menu-form')) {
              e.stopPropagation();
          }
      });
      $('#logout').on('click', function(e) {
        // localStorage.setItem('bridgit-token-web','');
        window.postMessage({
            "type": "BRIDGIT-WEB",
            "token": ""}, '*');
        });
    });

    $(function() {

    $('#login-form-link').click(function(e) {
        $("#login-form").delay(100).fadeIn(100);
        $("#register-form").fadeOut(100);
        $("#register-form").css('display','none');
        $("#login-form").css('display','show');
        $('#register-form-link').removeClass('active');
        $(this).addClass('active');
        e.preventDefault();
    });
    $('#register-form-link').click(function(e) {
        $('.alert').alert('close');
        $("#register-form").delay(100).fadeIn(100);
        $("#login-form").fadeOut(100);
        $("#register-form").css('display','show');
        $("#login-form").css('display','none');
        $('#login-form-link').removeClass('active');
        $(this).addClass('active');
        e.preventDefault();
    });
    

    });
    </script>

</body>
</html>
