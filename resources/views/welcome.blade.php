
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Bootstrap Css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- Main Css -->
    <link rel="stylesheet" href="{{  url('css/landing.css') }}">

    <title>{{ $website->name }}</title>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-main header sticky-top">
        <div class="container navbar-container">
            <a class="navbar-brand" href="#">
                <img class="img-fluid logo" src="assets/images/logo.png">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Blog <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Help</a>
                    </li>
                </ul>
                <form class="ml-auto">
                    @guest
                    <a href="{{ route('register') }}" class="btn btn-light rounded-pill">GET STARTED</a>
                    @endguest
                    @auth
                    <a href="{{ route('user.settings') }}" class="btn btn-light rounded-pill">
                        Settings <i class="fa fa-arrow-right"></i>
                    </a>
                    @endauth
                </form>
            </div>
        </div>
    </nav>
    <!-- / Navbar -->

    <!-- Hero -->
    <div class="container-fluid" style="background: #FBFBFB">
        <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="d-flex justify-content-center">
                    <img class="img-fluid logo-hero" src="{{ url('assets/images/logo.gif') }}">
                </div>
                <p class="text-center hero-text font-weight-bold jose mt-3">Arrange your links in one place</p>
                <p class="text-center h4 font-weight-bold jose hero-sub-text">All you need is just one link.</p>
            </div>
            <div class="col-md-6 my-auto">
                <div class="w-75 mx-auto">
                    <div class="form-group">
                        <div class="alert">
                            <p id="response"></p>
                        </div>
                    </div>
                    <form method="POST" id="form">
                        @csrf
                        <div class="form-group">
                            <input class="form-control" type="text" id="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="password" id="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-login w-100" type="submit">Login</button>
                        </div>
                    </form>
                </div>
            </div>  
        </div>
    </div>
    </div>
    <!-- / Hero -->
    <hr>
    <!-- First Feature -->
    <div class="container-fluid hero">
        <div class="container">
            <div class="row">
                <div class="col-md-6" style="display: flex;justify-content: center">
                    <img src="{{ url('assets/images/screenshot1.png') }}" class="img-fluid feature-image" alt="{{ $website->name . ' ' . $website->description }}">
                </div>
                <div class="col-md-6 my-auto">
                    <p class="feature-text">Combine scattered information into one</p>
                    <p class="text-muted h4">
                        Display multiple links and accounts <br> at once on {{ $website->name }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- / First Feature -->

    <hr>
    <!-- Second Feature -->
    <div class="container-fluid hero">
        <div class="container">
            <div class="row">
                <div class="col-md-6" style="display: flex;justify-content: center">
                    <img src="{{ url('assets/images/screenshot2.png') }}" class="img-fluid feature-image" alt="Mata on me">
                </div>
                <div class="col-md-6 my-auto">
                    <p class="feature-text">Connected anytime anywhere</p>
                    <p class="text-muted h4">
                        From website, social accounts to blog posts. All eyes on you in one landing page!
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- / Second Feature -->

    <hr>
    <!-- Third Feature -->
    <div class="container-fluid hero">
        <div class="container">
            <div class="row">
                <div class="col-md-6" style="display: flex;justify-content: center">
                    <img src="{{ url('assets/images/screenshot3.png') }}" class="img-fluid feature-image" alt="Mata on me">
                </div>
                <div class="col-md-6 my-auto">
                    <p class="feature-text">Simple usage</p>
                    <p class="text-muted h4">
                        An easy-to-use screen that can be registered in 5 minutes.
                        In the professional version, access analysis such as the
                        number of visits for each link is possible
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- / Third Feature -->

    <hr>

    <!-- Pricing -->
    <div class="container-fluid padded">
        <div class="container">
            <p class="text-center feature-text">Monthly subcription plan</p>
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header h2 text-center main-color">FREE</div>
                        <div class="card-body">
                            <p class="h4"><i class="fa fa-check main-color"></i> Page creation</p>
                            <p class="h4"><i class="fa fa-check main-color"></i> Change profile picture</p>
                            <p class="h4"><i class="fa fa-check main-color"></i> Creating a Bio (introduction)</p>
                            <br />
                            <br />
                            <br />
                            <br />
                            <br />
                            <br />
                            <br />
                            <br />
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('register') }}" class="btn btn-login w-100">GET STARTED</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header h2 text-center main-color">PREMIUM</div>
                        <div class="card-body">
                            <p class="h4"><i class="fa fa-check main-color"></i> Page creation</p>
                            <p class="h4"><i class="fa fa-check main-color"></i> Change profile picture</p>
                            <p class="h4"><i class="fa fa-check main-color"></i> Creating a Bio (introduction)</p>
                            <p class="h4"><i class="fa fa-check main-color"></i> Access analysis</p>
                            <p class="h4"><i class="fa fa-check main-color"></i> Background customization</p>
                            <p class="h4"><i class="fa fa-check main-color"></i> Customize social icons</p>
                            <p class="h4"><i class="fa fa-check main-color"></i> Change of shades</p>
                            <p class="h4"><i class="fa fa-check main-color"></i> Button customization</p>
                        </div>
                        <div class="card-footer">
                            @guest
                            <a href="{{ route('upgrade') }}" class="btn btn-login w-100">GET STARTED</a>
                            @endguest
                            @auth
                            <a href="{{ route('upgrade') }}" class="btn btn-login w-100">GO PRO</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Pricing -->

    <script>
        let form = document.getElementById('form')
        form.addEventListener('submit', async (event) => {
            event.preventDefault()
            let email = document.getElementById('email').value
            let password = document.getElementById('password').value
            window.location.href = `/login?email=${email}&password=${password}`
        })
    </script>

    <!-- Footer -->
    <div class="container-fluid bg-light">
        <div class="container py-20" style="padding-top: 40px;padding-bottom: 20px;">
            <p class="text-center">All rights reserved for Mataonme.</p>
        </div>
    </div>
    <!-- / Footer -->

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>