<?php
    session_start();
    unset($_SESSION['member_username']);
    unset($_SESSION['member_password']);
    // Redirects to login page (index.php)
    header("Location: ./");