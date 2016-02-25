<?php
    session_start();
    unset($_SESSION['member_username']);
    // Redirects to login page (index.php)
    header("Location: ./");