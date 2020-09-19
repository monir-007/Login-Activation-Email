<?php

// help functions

function clean($string){
    return htmlentities($string);
}

function redirect($location){
    return header("Location:{$location}");
    
}



function set_message($message){
    if(!empty($message)){
        $_SESSION['message'] = $message;
    }else{
        $message="";
    }
}

function display_message(){
    if(isset($_SESSION['message'])){
        echo $_SESSION['message'];

        unset($_SESSION['message']);
    }
}

function token_generator(){
    $token=$_SESSION['token']=md5(uniqid(mt_rand(),true));
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



// <!-- Validation Functions -->


function validate_user_registration(){
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $errors=[];
        $max=20;
        $min=3;

        $first_Name = clean($_POST['first_Name']);
        $last_Name = clean($_POST['last_Name']);
        $userName = clean($_POST['userName']);
        $email = clean($_POST['email']);
        $password = clean($_POST['password']);
        $confirm_password=clean($_POST['confirm_password']);
        


        if(strlen($first_Name)<$min){
            $errors[]="name canot be less than {$min}";
        }

        if(empty($first_Name)){
            $errors[]="Name cannot be empty.";

        }

        if(strlen($last_Name)<$min){
            $errors[]="name canot be less than {$min}";
        }

        if(email_exists($email)){
            $errors[]="email already exists";
        }

        if(username_exists($userName)){
            $errors[]="Username already exists";
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors[]="Invalid email";
        }

        if($password != $confirm_password){
            $errors[]="Password didn't match";
        }

       // Validate password strength
        
       
       if(!empty($errors)){
            foreach($errors as $error){
                echo validation_errors($error);
            }
        }else{
            if(register_user($first_Name, $last_Name, $userName, $email, $password )){

                set_message("<p class='text-center bg-info'>please check your email for activate</p>");
                redirect("index.php");
            }else{
                set_message("<p class='text-center bg-info'>Sorry, we could not find you.</p>");
                redirect("index.php");
            }
        }



    } //post request
}//function



//======
//====== REGISTER USER FUNCTIONS -----------------------------------------------
//======

function register_user($first_Name, $last_Name, $userName, $email, $password ){

        $first_Name = escape($_POST['first_Name']);
        $last_Name = escape($_POST['last_Name']);
        $userName = escape($_POST['userName']);
        $email = escape($_POST['email']);
        $password = escape($_POST['password']);
        

        if(email_exists($email)){
            return false;
        }else if(username_exists($userName)){
            return false;
        }else{

            // $password = md5($password);
            // $validation_code = md5($userName + microtime());

            // $sql="INSERT INTO users (first_Name, last_Name, userName, pasword, email,  validation_code, active)";

            // $sql.="VALUES('$first_Name','$last_Name','$userName','$password','$email','$validation_code', 0)";

            // $result=query($sql);
            // confirm($result);

            $password = md5($password);
            $validation = md5($userName . microtime());

    $sql = "INSERT INTO users (first_Name, last_Name, userName, email, password, validation_code, active) ";
    $sql.= "values ('{$first_Name}', '{$last_Name}', '{$userName}', '{$email}', '{$password}', '{$validation}', 0)";
    $result = query($sql);
    confirm($result);

            return true;

        }
}



?>








