<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <title>Login</title>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card" style="width: 48rem; height: 28rem;">
            <div class="row">
                <div class="col">
                    <div class="text-left my-4 px-4">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="img-fluid" style="max-height: 50px;">
                    </div>
                    @error('email')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                    <form action="{{ route('login_store') }}" method="POST" class="p-4 w-100">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control w-100" name="email" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control w-100" name="password" placeholder="Password">
                        </div>
                        <button type="submit" class="btn btn-main btn-block">Login</button>
                    </form>
                </div>
                <div class="col d-block">
                    <img src="{{ asset('assets/img/loginpage.png') }}" class="d-block" width="100%" height="100%" alt="">
                </div>
            </div>
        </div>
    </div>
</body>
</html>

