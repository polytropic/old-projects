<?php 
    ob_start();
    include_once 'db_connect.php';
    include_once 'functions.php';

    sec_session_start(); // secure session start

if (isset($_POST['email'], $_POST['p'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['p']; // Password param
    
    if (login($email, $password, $mysqli) == true) {
        // if login succeeds
        header("Location: ../index.php");
        exit();
    } else {
        // if it fails
        header("Location: ../index.php?error=1");
        exit();
    }
} else {
    // Problem with post vars 
    header("Location: ../error.php?err=Could not process login");
    exit();
}
