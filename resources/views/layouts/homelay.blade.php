<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Flatter Media Wifi</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="{{asset('assets/favicon.ico')}}" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{asset('css/styles.css')}}" rel="stylesheet" />
        <link rel="stylesheet" href="{{asset('toastify-js/src/toastify.css')}}">
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <div class="container px-4 px-lg-5">
                {{-- <a class="navbar-brand" href="#!">Flatter Event</a> --}}
                <img src="{{asset('logo2.png')}}" alt="" class="navbar-brand" width="180px">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{route('home')}}">Home</a></li>
                        {{-- <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#!">All Products</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                                <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                            </ul>
                        </li> --}}

                    </ul>
                    <div class="d-flex">
                        @auth
                            <a class="btn" data-bs-target="#modallogout" data-bs-toggle="modal">
                                <i class="bi-person me-1"></i>
                                {{Auth::user()->name}}

                            </a>

                        @else
                            <a class="btn" type="submit" href="{{route('login')}}">
                                <i class="bi-person me-1"></i>
                                Login

                            </a>

                        @endauth

                    </div>
                </div>
                {{-- <div class="d-flex">
                    <a class="nav-link dropdown-toggle profile-pic" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{asset('admin/plugins/images/users/profile.png')}}" alt="user-img" width="36"
                            class="img-circle"><span class="text-white font-medium">Steave</span></a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                    </ul>
                </div> --}}
            </div>
        </nav>
        <!-- Header-->
        <header class="bg-white py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    {{-- <h1 class="display-4 fw-bolder">Flatter media wifi</h1> --}}
                    <img src="{{asset('logo2.png')}}" alt="" class="display-4" width="300px">
                    <p class="lead fw-normal text-white-50 mb-0"></p>
                </div>
            </div>
        </header>
        @yield('content')
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Flatter Media 2023</p></div>
        </footer>
        @auth

        <!-- Modal -->
        <div class="modal fade" id="modallogout" tabindex="-1" aria-labelledby="modallogoutLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modallogoutLabel">Hi {{Auth::user()->name}}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Ini User Info kamu :</p>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <th>Nama</th>
                                        <th>:</th>
                                        <th>{{Auth::user()->name}}</th>
                                    </tr>
                                    <tr>
                                        <th>Nomor HP</th>
                                        <th>:</th>
                                        <th>{{Auth::user()->phone_number}}</th>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <th>:</th>
                                        <th>{{Auth::user()->email}}</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <form action="logout" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endauth
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{asset('admin/plugins/bower_components/jquery/dist/jquery.min.js')}}"></script>
        <script src="{{asset('js/scripts.js')}}"></script>
        <script src="{{asset('toastify-js/src/toastify.js')}}"></script>
        <script>
            function callfailmessage(){
                Toastify({
                        text: "Silahkan login terlebih dahulu",
                        duration: 3000,
                        style: {
                            background: "red",
                        }
                }).showToast();
            }
        </script>
        @if (Session::has('success'))
            <script>
                $(document).ready(function(){
                    Toastify({
                        text: "<?php echo Session::get('success') ?>",
                        duration: 3000,
                        style: {
                            background: "green",
                        }
                    }).showToast();
                })
            </script>
        @endif

        @if (Session::has('fail'))
            <script>
                $(document).ready(function(){
                    Toastify({
                        text: "<?php echo Session::get('fail') ?>",
                        duration: 3000,
                        style: {
                            background: "red",
                        }
                    }).showToast();
                })
            </script>
        @endif

        @yield('script')
    </body>
</html>
