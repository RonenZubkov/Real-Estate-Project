<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Real Estate</title>


    <link rel="stylesheet" href="app/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="app/assets/css/custom.css">

    <script src="app/assets/js/jquery.min.js"></script>
    <script src="app/assets/js/bootstrap.min.js"></script>

    <script src="js/main.js"></script>

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
    ?>
</head>