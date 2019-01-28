<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="app/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="app/assets/css/custom.css">

    <script src="app/assets/js/jquery.min.js"></script>
    <script src="app/assets/js/bootstrap.min.js"></script>

    <!-- bootbox for confirm pop up -->
    <script src="app/assets/js/bootbox.min.js"></script>

    <!-- app js script -->
    <script src="app/view/index.js"></script>

    <!-- products scripts -->
    <script src="app/view/product/read-products.js"></script>
    <script src="app/view/product/create-product.js"></script>
    <script src="app/view/product/read-one-product.js"></script>
    <script src="app/view/product/update-product.js"></script>
    <script src="app/view/product/delete-product.js"></script>

    <!-- set the page title, for seo purposes too -->
    <title><?php echo isset($page_title) ? strip_tags($page_title) : "Roman Hacking Project"; ?></title>
    <?php
    // core configuration
    include_once "./app/config/core.php";

    // set page title
    $page_title="Index";

    // include login checker
    $require_login=true;
    include_once "./app/login_checker.php";
    ?>
</head>
<body>
<!-- include the navigation bar -->
<?php
// include page header HTML
include_once 'layout_head.php';

echo "<div class='col-md-12'>";

// to prevent undefined index notice
$action = isset($_GET['action']) ? $_GET['action'] : "";

// if login was successful
if($action=='login_success'){
    echo "<div class='alert alert-info'>";
     echo "<strong>Hi " . $_SESSION['firstname'] . ", welcome back!</strong>";
    echo "</div>";
}

// if user is already logged in, shown when user tries to access the login page
else if($action=='already_logged_in'){
    echo "<div class='alert alert-info'>";
     echo "<strong>You are already logged in.</strong>";
    echo "</div>";
}

// content once logged in
echo "<div class='alert alert-info'>";
echo "<main role='main' class='container starter-template'>";

    echo "<div class='row'>";
        echo "<div class='col'>";

//            <!-- where prompt / messages will appear -->
            echo "<div id='response'></div>";

//            <!-- where main content will appear -->
            echo "<div id='content'></div>";
       echo "</div>";
    echo "</div>";

echo "</main>";
echo "</div>";


echo "</div>"; ?>

<!--<div id='app'></div>-->

<?php
// footer HTML and JavaScript codes
include 'layout_foot.php';
?>



</body>
</html>