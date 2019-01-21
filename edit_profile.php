<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Real Estate</title>


    <link rel="stylesheet" href="app/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="app/assets/css/custom.css">

    <script src="app/assets/js/jquery.min.js"></script>
    <script src="app/assets/js/bootstrap.min.js"></script>

<!--    <script src="js/main.js"></script>-->

    <!-- set the page title, for seo purposes too -->
    <title><?php echo isset($page_title) ? strip_tags($page_title) : "Store Front"; ?></title>
    <?php
    // core configuration
    include_once "api/config/core.php";

    // set page title
    $page_title="Edit Profile";

    // include login checker
    $require_login=true;
    include_once "./login_checker.php";

    // default to false
    $access_denied=false;

    //For testing into cOnsole.
    include_once "./libs/php/utils.php";

    // include database and object files
    include_once 'api/config/database.php';
    include_once 'objects/User.php';
    ?>

</head>
<?php
// include page header HTML
include_once 'layout_head.php';

echo "<div class='col-md-12'>";


// to prevent undefined index notice
$action = isset($_GET['action']) ? $_GET['action'] : "";

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare product object
$user = new User($db);

if($_POST){
    // get id of product to be edited
    $data = json_decode(file_get_contents("php://input"));

// set ID property of product to be edited
    $user->id = $_SESSION['user_id'];

// set user property values
    $user->firstname = $data->first_name;
    $user->lastname = $data->last_name;
    $user->password = $data->password;
    $user->email = $data->email;
    $user->address = $data->address;
    $user->contact_number = $data->contact_number;

// get id of product to be edited
    /* Consult if to get it from Session or anything else $_SESSION['id']*/
//$user_id = session user_id
    /*First Stage*/
//$get_user = "SELECT * FROM users WHERE id = '$user_id'";

//$result_get_user = mysqli_query($connect, $get_user);
//$_SESSION['data'] = mysqli_fetch_assoc($result_get_user);

    if($user->update()){

        // set response code - 200 ok
        http_response_code(200);

        // tell the user
        echo json_encode(array("message" => "Product was updated."));
    }

// if unable to update the product, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to update product."));
    }

}
?>

<form action='register.php' method='post' id='register'>

    <table class='table table-responsive'>

        <tr>
            <td class='width-30-percent'>Firstname</td>
            <td><input type='text' name='firstname' class='form-control' required value="<?php echo isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname'], ENT_QUOTES) : "";  ?>" /></td>
        </tr>

        <tr>
            <td>Lastname</td>
            <td><input type='text' name='lastname' class='form-control' required value="<?php echo isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname'], ENT_QUOTES) : "";  ?>" /></td>
        </tr>

        <tr>
            <td>Contact Number</td>
            <td><input type='text' name='contact_number' class='form-control' required value="<?php echo isset($_POST['contact_number']) ? htmlspecialchars($_POST['contact_number'], ENT_QUOTES) : "";  ?>" /></td>
        </tr>

        <tr>
            <td>Address</td>
            <td><textarea name='address' class='form-control' required><?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address'], ENT_QUOTES) : "";  ?></textarea></td>
        </tr>

        <tr>
            <td>Email</td>
            <td><input type='email' name='email' class='form-control' required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES) : "";  ?>" /></td>
        </tr>

        <tr>
            <td>Password</td>
            <td><input type='password' name='password' class='form-control' required id='passwordInput'></td>
        </tr>

        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-plus"></span> Edit
                </button>
            </td>
        </tr>

    </table>
</form>


