<?php
    session_start();
    if(isset($_SESSION["member_username"])) {
        unset($_SESSION['member_username']);
    }
    if(isset($_SESSION["admin_username"])) {
        unset($_SESSION['admin_username']);
    }
    // Redirects to login page (index.php)
    header("Location: ./");