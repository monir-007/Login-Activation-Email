<?php include("includes/header.php"); ?>
<?php include("includes/navbar.php"); ?>

<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php validate_user_registration();?>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-warning">
                        <h3>Register</h3>
                    </div>
                    <div class="card-body">
                        <form id="register-form" method="post" role="form">
                            <div class="form-group">
                                <input type="text" name="first_Name" id="first_Name" tabindex="1" class="form-control"
                                    placeholder="First Name" value="" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="last_Name" id="last_Name" tabindex="1" class="form-control"
                                    placeholder="Last Name" value="" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="userName" id="userName" tabindex="1" class="form-control"
                                    placeholder="Username" value="" required>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" id="register_email" tabindex="1" class="form-control"
                                    placeholder="Email Address" value="" required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" id="password" tabindex="2" class="form-control"
                                    placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="confirm_password" id="confirm-password" tabindex="2"
                                    class="form-control" placeholder="Confirm Password" required>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6 col-sm-offset-3">
                                        <input type="submit" name="register-submit" id="register-submit" tabindex="4"
                                            class="form-control btn btn-register " value="Register Now">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
<?php include("includes/footer.php")?>