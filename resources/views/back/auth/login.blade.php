<!doctype html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description" content="Admin is super flexible, powerful, clean & modern responsive admin dashboard with unlimited possibilities.">
    <meta name="author" content="GetBootstrap, design by: Newbie">

    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="asset/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="asset/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="asset/vendor/animate-css/vivify.min.css">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="asset/css/mooli.min.css">
</head>

<body>
    <div id="body" class="theme-cyan">
        <div class="auth-main">
            <div class="auth_div vivify fadeIn">
                <div class="auth_brand"></div>
                <div class="card">
                    <div class="header">
                        <p class="lead">Login Admin</p>
                    </div>
                    <div class="body">
                        <form class="form-auth-small" action="{{ route('actionlogin') }}" method="post">
                            @csrf
                            <div class="form-group c_form_group">
                                <label>Username</label>
                                <input type="text" class="form-control" name="username" placeholder="Masukkan Username">
                            </div>
                            <div class="form-group c_form_group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Masukkan Password">
                            </div>
                            <button type="submit" class="btn btn-dark btn-lg btn-block">LOGIN</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="animate_lines">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
        </div>
    </div>

    <script src="asset/bundles/libscripts.bundle.js"></script>
    <script src="asset/bundles/vendorscripts.bundle.js"></script>

    <!-- Vendor JS and theme settings -->
    <script>

    </script>
</body>

</html>
