<?php

// required headers
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// core configuration
include_once "./config/core.php";

// generate json web token
include_once 'config/core.php';
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;


// set page title
$page_title = "Login";

// include login checker
$require_login=false;
include_once "login_checker.php";

// default to false
$access_denied=false;


/* TODO to check $_Post vs Server request method === post, which one will be better*/
if($_POST){

    // include classes
    include_once "./config/Database.php";
    include_once "./model/objects/User.php";

// get database connection
    $database = new Database();
    $db = $database->getConnection();

// initialize objects
    $user = new User($db);

// check if email and password are in the database
    $user->email=$_POST['email'];

// check if email exists, also get user details using this emailExists() method
    $email_exists = $user->emailExists();

// login validation will be here
    // validate login
    if ($email_exists && password_verify($_POST['password'], $user->password) && $user->status==1){

        /* Delete After! */
//        $utils = new Utils();
//        $utils->debug_to_console('We are inside the emails Exists');

        // if it is, set the session value to true
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $user->id;
        $_SESSION['access_level'] = $user->access_level;
        $_SESSION['firstname'] = htmlspecialchars($user->firstname, ENT_QUOTES, 'UTF-8') ;
        $_SESSION['lastname'] = $user->lastname;

        // if access level is 'Admin', redirect to admin section
        if($user->access_level=='Admin'){
            header("Location: {$home_url}admin/index.php?action=login_success");
        }

        // else, redirect only to 'Customer' section
        else{
            header("Location: {$home_url}index.php?action=login_success");
        }
    }

// if username does not exist or password is wrong
    else{
        $access_denied=true;
    }
}

// include page header HTML
include_once "../layout_head.php";

echo "<div class='col-sm-6 col-md-4 col-md-offset-4'>";

// get 'action' value in url parameter to display corresponding prompt messages
$action=isset($_GET['action']) ? $_GET['action'] : "";

// tell the user he is not yet logged in
if($action =='not_yet_logged_in'){
    echo "<div class='alert alert-danger margin-top-40' role='alert'>Please login.</div>";
}

// tell the user to login
else if($action=='please_login'){
    echo "<div class='alert alert-info'>
        <strong>Please login to access that page.</strong>
    </div>";
}

// tell the user if access denied
if($access_denied){
    echo "<div class='alert alert-danger margin-top-40' role='alert'>
        Access Denied.
        <br /><br />
        Your username or password maybe incorrect
    </div>";
}

// actual HTML login form
echo "<div class='account-wall'>";
    echo "<div id='my-tab-content' class='tab-content'>";
        echo "<div class='tab-pane active' id='login'>";
            echo "<img class='profile-img' src='images/login-icon.png'>";
            echo "<form class='form-signin' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>";
                echo "<input type='text' name='email' class='form-control' placeholder='Email' required autofocus />";
                echo "<input type='password' name='password' class='form-control' placeholder='Password' required />";
                echo "<input type='submit' class='btn btn-lg btn-primary btn-block' value='Log In' />";
            echo "</form>";
        echo "</div>";
    echo "</div>";
echo "</div>";

echo "</div>";

// footer HTML and JavaScript codes
include_once "../layout_foot.php";
