<!doctype html>
<html lang="en">
  <head>
    <title>Mini Social Media</title>
    <link rel="icon" href="css_login/images/login2.jpg" type="image/x-icon" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
       
    <link rel="stylesheet" href="{{ asset('css_login/style.css')}}">

    </head>
    <body>

        <div class="container mt-5">
            <div class="row justify-content-center">
            </div>
            <div class="row justify-content-center ">
                <div class="col-md-12 col-lg-10">
                    <div class="wrap d-md-flex">
                        <div class="img" style="background-image: url('css_login/images/login2.jpg');">
                        </div>
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h3 class="mb-4">Sign In</h3>
                                </div>
                                        <div class="w-100">
                                            <p class="social-media d-flex justify-content-end">
                                                <a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-facebook"></span></a>
                                                <a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-twitter"></span></a>
                                            </p>
                                        </div>
                            </div>

                            <!-- Session Status -->
                            <x-auth-session-status class="mb-4 text-black" :status="session('status')" />

                            <!-- Validation Errors -->
                            <x-auth-validation-errors class="mb-4 text-red-600" :errors="$errors" />


                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <label class="label" :value="__('Email')">Email</label>
                                    <input id="email" class="form-control" type="email" name="email" :value="old('email')" placeholder="Email" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label" for="password">Password</label>
                                  <input id="password" class="form-control" type="password" name="password" placeholder="Password" required autocomplete="current-password">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="form-control rounded submit px-3 text-white" style="background-color: #0D6EFD ">Sign In</button>
                                </div>
                            </form>
                             <p class="text-center">Not a member? <a data-toggle="tab" href="{{ route('register') }}">Sign Up</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>

