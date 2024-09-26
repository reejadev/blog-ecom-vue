<div class="header_section">
    <div class="header_main">
        <div class="mobile_menu">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <!--div class="logo_mobile"><a href="index.html"><img src="images/logo.png"></a><div-->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">Home</a>
                            </li>  -->
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="about.html">About</a>
                        </li> -->
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="services.html">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="blog.html">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="contact.html">Contact</a>
                        </li> -->
                    </ul>



                </div>
            </nav>
        </div>



        <div class="container-fluid">

            <!-- <div class="logo"><a href="index.html"><img src="images/logo.png"></a></div> -->
            <div class="menu_main">

                <ul>
                    <li class="active"><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="about.html">About</a></li>

                    <!-- <li><a href="blog.html">Blog</a></li> -->

                    @if(Route::has('login'))
                    @auth

                    <li>


                        <x-app-layout>
                            <!-- Contents of your app layout component -->
                        </x-app-layout>
                    </li>


                    <li><a href="{{ url('my_post') }}">My Post</a></li>
                    <li class="active"><a href="{{ url('create_post') }}">Create Post</a></li>
                    @else
                    <!-- <li><a href="{{ route('login') }}">Login</a></li> -->
                    <!-- <li><a href="{{ route('register') }}">Register</a></li> -->
                    @endauth
                    @endif


                </ul>

                <div class="topnav d-flex justify-content-end">

                    <form class="form-inline my-2 my-lg-0 ml-auto" method="get" action="{{ url('search') }}">
                        <input class="form-control mr-sm-2" name="query" type="search" placeholder="Search"
                            aria-label="Search">
                        <button class="btn btn-outline-success my-2 " type="submit">Search</button>
                    </form>
                </div>





            </div>


        </div>


    </div>