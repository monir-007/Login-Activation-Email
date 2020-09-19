<?php include("includes/header.php"); ?>
<?php include("includes/navbar.php"); ?>

<main class="login-form">
    <div class="cotainer">

    <div class="row justify-content-center">
        <div class="col-md-8">

        <?php display_message();?>
        <?php validate_user_login();?>
        

        </div>
    </div>
        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-secondary text-light">
                        <h3>Login</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" id="login-form" role="form">
                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail
                                </label>
                                <div class="col-md-6">
                                    <input type="text" id="email_address" class="form-control" name="email-address"
                                        required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input type="password" id="password" class="form-control" name="password" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-info" name="login-submit" id="login-submit" tabindex="4">
                                    Enter
                                </button>
                                <a href="#" class="btn btn-link text-primary">
                                    Forgot Your Password?
                                </a>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

</main>