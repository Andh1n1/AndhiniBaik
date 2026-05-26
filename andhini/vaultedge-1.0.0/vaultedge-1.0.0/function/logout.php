<?php 
    session_start();
    session_destroy();
    $_SESSION = [];
    header('Location: ../forms/login_page/login_page.php');
    exit();
?>