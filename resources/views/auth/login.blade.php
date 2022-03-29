
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>

</head>
<body>
    <div class="container" id="login_box">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card ">
                    <center><p class="mb-0"><h1>Log Billing Software</h1></p></center>
                    <center><p class="m-0 p-0"><strong>Pathari,Morang</strong></p></center>

                    <center><p class="m-2"><h4>Login Members</h4></p></center>

                    
    
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
    
                            <div class="form-group row">
                                
                                
                                <div class="col-md-6 offset-md-3">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-user-circle" aria-hidden="true"></i></span>
                                        <input type="email" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                      </div>
    
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <br>
    
                            <div class="form-group row ">
                             
                                
                                  
    
                                <div class="col-md-6 offset-md-3">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-key" aria-hidden="true"></i></span>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" required autocomplete="current-password">
                                      </div>
    
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <br>
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
    
                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>
    
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</body>

</html>



