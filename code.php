<?php include("includes/header.php")?>

    <div id="login">
        
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div class="alert alert-success alert-dismissible fade show mt-lg-5 mt-sm-5 mt-md-5" role="alert">
                    <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div id="login-column" class="col-md-6 bg-danger">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="" method="post">
                            <h3 class="text-center text-dark mb-sm-5 mb-md-5 mb-lg-5">Enter Code</h3>
                            <div class="form-group mb-sm-4 mb-md-4 mb-lg-4">
                                <input type="text" name="username" id="username" class="form-control text-center" placeholder="********">
                            </div>
                            
                            <div class="form-group mt-sm-2 mt-md-2 mt-lg-2">
                                <input type="submit" name="submit" class="btn btn-warning btn-md float-left font-weight-bold" value="Back">
                                <input type="submit" name="submit" class="btn btn-info font-weight-bold btn-md float-right" value="Enter">
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

