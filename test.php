<?php
//======
//====== HELPER FUNCTIONS ------------------------------------------------------
//======
function clean($string){
    return htmlentities($string);
}

function redirect($location){
    return header("Location:{$location}");
    
}


function set_message($message){

    if(!empty($message)){
        $_SESSION['message'] = $message;
    }
    else{
        $message = "";
    }
}

function display_message(){
    if(isset($_SESSION['message'])){
        echo $_SESSION['message'];

        unset($_SESSION['message']);
    }
}

function token_generator(){
    $token = $_SESSION['token'] = md5(uniqid(mt_rand(),true));
    return $token;

    
}

function validation_errors($error_message){
    $alert_error_message = "
    <div class='alert alert-danger alert-dismissible' role='alert'>
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
    <strong>Warning!</strong>
    {$error_message}
    </div>
    ";
    return $alert_error_message;
}


function email_exists($email){

    $sql = "SELECT id FROM users WHERE email = '$email'";
    $result = query($sql);
    confirm($result);

    if(row_count($result) >= 1){
        return true;
    }
    return false;
}

function username_exists($userName){

    $sql = "SELECT id FROM users WHERE userName = '$userName'";
    $result = query($sql);
    confirm($result);

    if(row_count($result) >= 1){
        return true;
    }
    return false;
}

function send_email($email, $subject, $msg, $header){

    return mail($email, $subject, $msg, $header);
}

//======
//====== VALIDATION FUNCTIONS --------------------------------------------------
//======


function validate_user_registration(){
    
    $errors = [];
    $max = 25;
    $min = 3;
    
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $first_Name       = clean($_POST['first_Name']);
        $last_Name        = clean($_POST['last_Name']);
        $userName         = clean($_POST['userName']);
        $email            = clean($_POST['email']);
        $password         = clean($_POST['password']);
        $confirm_password = clean($_POST['confirm_password']);
        


        $errors = validate_length($errors, $first_name, "first name", $min, $max);
        $errors = validate_length($errors, $last_name, "last name", $min, $max);
        $errors = validate_length($errors, $email, "email", $min, $max);

        if(email_exists($email)){
            $errors[] = "Email already exists";
        }

        if(username_exists($userName)){
            $errors[] = "Username already exists";
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors[] = "Invalid email";
        }

        if($password != $confirm_password){
            $errors[] = "Password didn't match";
        }

       // Validate password strength
        
        
        if(!empty($errors)){
            foreach($errors as $error){
                echo validation_errors($error);
            }
        }else{
            if(register_user($first_Name, $last_Name, $userName, $email, $password )){

                set_message("<h4 class='alert alert-info text-center'>please check your email for activate</h4>");
                redirect("index.php");
            }else{
                set_message("<h4 class='alert alert-info text-center '>Sorry, we could not find you.</h4>");
                redirect("index.php");
            }
        }

    } //post request
}//function

function validate_length($errors, $string, $label, $min, $max){

    if(strlen($string) < $min){
        $errors[] = "Your {$label} cannot be less than {$min} characters";
    }
    else if(strlen($string) > $max){
        $errors[] = "Your {$label} cannot be greater than {$max} characters";
    }

    return $errors;
}

//======
//====== REGISTER USER FUNCTIONS -----------------------------------------------
//======

function register_user($first_Name, $last_Name, $userName, $email, $password ){

    $first_Name = escape($first_Name);
    $last_Name  = escape($last_Name);
    $userName   = escape($userName);
    $email      = escape($email);
    $password   = escape($password);
        


        if(email_exists($email) || username_exists($userName)){
            return false;
        }
        

            $password = md5($password);
            $validation = md5($userName . microtime());

            $sql = "INSERT INTO users (first_Name, last_Name, userName, email, password, validation_code, active) ";
            $sql.= "values ('{$first_Name}', '{$last_Name}', '{$userName}', '{$email}', '{$password}', '{$validation}', 0)";
            $result = query($sql);
            confirm($result);


            $subject="Activate account";
            $msg="please click the link to activate you account
            http://localhost/login/activate.php?email=$email&code=$validation";
            $header = "From: noreply@thiswebsite.com";

            send_email($email, $subject, $msg, $header);
            return true;

        }


//======
//====== ACTIVATE USER FUNCTIONS -----------------------------------------------
//======

function activate_user(){
    if($_SERVER['REQUEST_METHOD'] == "GET"){

        
        if(isset($_GET['email'])){
            
            $email = clean($_GET['email']);
            $validation_code = clean($_GET['code']);

            $sql="SELECT id FROM users WHERE email = '".escape($_GET['email'])."' AND validation_code = '".escape($_GET['code'])."'  ";
            $result = query($sql);
            confirm($result);

            if(row_count($result) == 1){

            $sql2="UPDATE users SET active = 1, validation_code = 0 WHERE email = '".escape($email)."' AND validation_code = '".escape($validation_code)."' ";
            $result2 = query($sql2);
            confirm($result2);

                set_message("<h5 class='alert-success text-center'>Your Account has been activated. Please Log in</h5>") ;
                redirect("login.php");
            }
            else{
                set_message("<h5 class='alert-danger text-center'>Your Account has not activated. Please Activate </h5>") ;
                redirect("login.php");

            }
        }
    }
}


//======
//====== VALIDATE USER LOGIN FUNCTIONS -----------------------------------------
//======

function validate_user_login(){
    $errors = [];

    $min = 3;
    $max = 20;

    if(!isset($_POST['email']) && !isset($_POST['password'])){
        return;
    }

        $email     = clean($_POST['email']);
        $password  = clean($_POST['password']);
        $remember  = clean($_POST['remember']);

        if(empty($email)){
            $errors[] = "Recheck email field";
        }

        if(empty($password)){
            $errors[] = "Recheck password field";
        }


        if(!empty($errors)){
            foreach($errors as $error){
                echo validation_errors($error);
            }
        }
        else{
            if(login_user($email, $password, $remember)){
                redirect("admin.php");
            }
            else{
                echo validation_errors("Your credentials are not correct");
            }
        }
    }


//======
//====== USER LOGIN FUNCTIONS --------------------------------------------------
//======


function login_user($email, $password, $remember){
    $sql = "SELECT password, id FROM users WHERE email = '".escape($email)."' AND active=1 ";

    $result=query($sql);
    if(row_count($result) == 1) {
        $row = fetch_array($result);

        $db_password = $row['password'];
        if(md5($password) == $db_password){

            if($remember == "on"){
                setcookie('email', $email, time() +1200);
            }
            $_SESSION['email']=$email;

            return true;
        }
    }

    return false;
}//end of functions


















?>