<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title> @yield('title') </title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('/images/r.png') }}" rel="icon">
    <link href="{{ asset('/images//r.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">

</head>

<header id="header" class="fixed-top d-flex align-items-cente">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-lg-between">

        <h1 class="logo me-auto me-lg-0"><a href="/">Restaurantly</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

        <nav id="navbar" class="navbar order-last order-lg-0">
            <ul>
                <li><a class="nav-link scrollto {{ Request::is('/') ? 'active' : '' }}"
                        href="{{ route('home.index') }}">Home</a></li>


                <li><a class="nav-link scrollto {{ Request::is('menu') ? 'active' : '' }}"
                        href="{{ route('home.menu') }}">Menu</a></li>
                <li><a class="nav-link scrollto {{ Request::is('contact') ? 'active' : '' }}"
                        href="{{ route('home.contact') }}">Contact</a></li>
                <li><a class="nav-link scrollto {{ Request::is('reservations') ? 'active' : '' }}"
                        href="{{ route('home.reservations') }}">Book a table &nbsp;</a></li>
                        @auth
                <li>
            
                    <a class="nav-link scrollto {{ Request::is('cart.show') ? 'active' : '' }}"
                        href="{{ route('cart.show', auth()->id()) }}">Cart &nbsp;&nbsp;&nbsp;&nbsp;</a>
                </li>
                <li>
                    <?php $notifications = auth()->user()->unreadNotifications;$c=0; ?>
                    @if(isset($notifications[0]->data))
                    <li class="dropdown"><a href="#"><span>Notifications&nbsp;<img src="{{ asset('/images/active.png') }}" style="display:inline;"></span> <i class="bi bi-chevron-down"></i></a>
                    @else
                    <li class="dropdown"><a href="#"><span>Notifications</span> <i class="bi bi-chevron-down"></i></a>
                        @endif   <ul>
                            
                            @forelse($notifications as $notification)
                                            <?php $c++ ?>
                                            <li class="alert alert-success text-xs" role="alert">
                                            {{ $notification->data['user_id'] }} {{ $notification->data['message'] }}
                                            <a href="{{ route('marks',$notification->id ) }}" class=" text-xs mark-as-read" style="display: inline;" >X
                                                </a></li>
                                        @empty
                                        <li class="text-dark">&nbsp No recent notifications</li>
                                        @endforelse
                        </ul>
                      </li>
                </li>
               
                @endauth
                <ul>
                    @if (Route::has('login'))
                        <div class="d-flex  p-0 text-right  mt-1">
                            @auth
                                <div class="d-flex p-0 mb-n5">
                                    <x-app-layout>

                                    </x-app-layout>
                                </div>
                            @else
                                <li class="dropdown book-a-table-btn"><a
                                        href="#"><span>Account&nbsp;&nbsp;&nbsp;</span> <i
                                            class="bi bi-chevron-down"></i></a>
                                    <ul>
                                        <li><a href="{{ route('login') }}"
                                                class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                                                in</a></li>
                                        @if (Route::has('register'))
                                            <li><a href="{{ route('register') }}"
                                                    class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                                            </li>
                                        @endif
                                    </ul>
                            </li>@endauth
                        </div>
                    @endif
                    </a>
                </ul>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->
    </div>
</header>
