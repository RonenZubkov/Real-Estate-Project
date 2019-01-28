<?php
// show error reporting
error_reporting(E_ALL);

/* Switch Config to Normal App Outside of API? WTF*/
// start php session
session_start();

/*Auto Loader for Addons*/
//require_once __DIR__ . '../../vendor/autoload.php';
//require_once ('../../vendor/autoload.php');

// variables used for jwt
$key = "example_key";
$iss = "http://example.org";
$aud = "http://example.com";
$iat = 1356999524;
$nbf = 1357000000;

// set your default time-zone
date_default_timezone_set('Asia/Jerusalem');


/* Dot Enviroment */
// Take care of this shit later
//$dotenv = new Dotenv\Dotenv(__DIR__ . '');
//$dotenv->load();

//$session = new \Symfony\Component\HttpFoundation\Session\Session();
//$session->start();

// home page url
$home_url="http://localhost:63342/htdocs/";

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// set number of records per page
$records_per_page = 5;

// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;
