<?php
session_start();
//if (isset($_SESSION['user'])) {
//    // logged in
//} else {
//    // not logged in
//}
//
//if(isset($_SESSION['use']))   // Checking whether the session is already there or not if
//    // true then header redirect it to the home page directly
//{
//    header("Location:home.php");
//}
//$_SESSION['user'] = $user_id;

// check if users / customer was logged in
// if user was logged in, show "Edit Profile", "Orders" and "Logout" options


/*TODO Declare SQL Variables*/
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    /*
      TODO: 1.Another validation Variable to validate the form.
            2. validating 2 passwords and than INSERTING into SQL
            3. More Validation Form functions and checks
            4. Hashing the password with MD5.
            6. Validating same email in DataBase
            7. Define Variables
    */
//    var_dump($_POST['reg_user']);
//    print_r($_POST['reg_user']);
//    $reg_form = $_POST['reg_user'];
//    debug_to_console($reg_form);

    /* Register PHP API*/
    if (isset($reg_form)){

        try{
            $MySQLdb = new PDO("mysql:host=127.0.0.1;dbname=real estate", "AreZi", "H7c2q5uVZsoP1Wda");
            $MySQLdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];

            // Check that data was sent to the mailer.
            if ( empty($username) OR empty($password) OR !filter_var($email, FILTER_VALIDATE_EMAIL) OR empty($firstName OR empty($lastName))){
                // Set a 400 (bad request) response code and exit.
                http_response_code(400);
                echo "Oops! There was a problem with your submission. Please complete the form and try again.";
                exit;
            }

            $sql = "INSERT INTO users (email, first_name, last_name, password, username) value (:email,:firstName,:lastName,:password,:username)";
            $cursor = $MySQLdb->prepare($sql);
            $cursor->execute(array(
                ":email"=> $email,
                ":firstName"=> $firstName,
                ":lastName"=> $lastName,
                ":password"=> $password,
                ":username"=> $username,
            ));
        }

        catch (PDOException $e) {
            echo $e->getMessage();
            debug_to_console($e->getMessage());
        }
    }

//    elseif (isset($_POST['login_user'])){

        $email = trim($_POST['email']);

        /* TODO Must be resolved from MD5*/
        $password = trim($_POST['password']);

        try{
            $MySQLdb = new PDO("mysql:host=127.0.0.1;dbname=real estate", "AreZi", "H7c2q5uVZsoP1Wda");
            $MySQLdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if($email && $password){
                debug_to_console( 'Login Request After UserName & Password' );
                $sql = "SELECT id, password, email FROM users WHERE email='$email'";
                $cursor = $MySQLdb->prepare($sql);
                $cursor->execute(array(
                    ":email"=> $email,
                    ":password"=> $password
                ));

                if($cursor -> rowCount()){
                    /* After Fetch */
                    /*TODO Validating Password Between SQL and POST*/
                    debug_to_console('Fetch is working!, We are inside Fetch IF',$cursor);
//                    $_SESSION["username"] = $_POST["username"];
//                    header("location:login_success.php");
                    echo '<h3>Login Success, Welcome - '.$_SESSION["username"].'</h3>';
                }
            }

        }
        catch (PDOException $e) {
            echo "Connection failed : ". $e->getMessage();
            debug_to_console($e->getMessage());
        }

//    }
}




////logout.php
//session_start();
//session_destroy();
//header("location:pdo_login.php");
//if($_SERVER['REQUEST_METHOD'] == 'GET'){}
//if($_SERVER['REQUEST_METHOD'] == 'PUT'){}




    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
//    if (empty($username)) { array_push($errors, "Username is required"); }
//    if (empty($email)) { array_push($errors, "Email is required"); }
//    if (empty($password_1)) { array_push($errors, "Password is required"); }
//    if ($password_1 != $password_2) {
//        array_push($errors, "The two passwords do not match");
//}

// create SQL based on HTTP method
//switch ($method) {
//    case 'GET':
//        $sql = "select * from `$table`".($key?" WHERE id=$key":''); break;
//    case 'PUT':
//        $sql = "update `$table` set $set where id=$key"; break;
//    case 'POST':
//        $sql = "insert into `$table` set $set"; break;
//    case 'DELETE':
//        $sql = "delete `$table` where id=$key"; break;
////}
//if(isset($_POST['login'])){
//
//    //Retrieve the field values from our login form.
//    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
//    $passwordAttempt = !empty($_POST['password']) ? trim($_POST['password']) : null;
//
//    //Retrieve the user account information for the given username.
//    $sql = "SELECT id, username, password FROM users WHERE username = :username";
//    $stmt = $pdo->prepare($sql);
//
//    //Bind value.
//    $stmt->bindValue(':username', $username);
//
//    //Execute.
//    $stmt->execute();
//
//    //Fetch row.
//    $user = $stmt->fetch(PDO::FETCH_ASSOC);
//
//    //If $row is FALSE.
//    if($user === false){
//        //Could not find a user with that username!
//        //PS: You might want to handle this error in a more user-friendly manner!
//        die('Incorrect username / password combination!');
//    } else{
//        //User account found. Check to see if the given password matches the
//        //password hash that we stored in our users table.
//
//        //Compare the passwords.
//        $validPassword = password_verify($passwordAttempt, $user['password']);
//
//        //If $validPassword is TRUE, the login has been successful.
//        if($validPassword){
//
//            //Provide the user with a login session.
//            $_SESSION['user_id'] = $user['id'];
//            $_SESSION['logged_in'] = time();
//
//            //Redirect to our protected page, which we called home.php
//            header('Location: home.php');
//            exit;
//
//        } else{
//            //$validPassword was FALSE. Passwords do not match.
//            die('Incorrect username / password combination!');
//        }
//    }
//
//}
