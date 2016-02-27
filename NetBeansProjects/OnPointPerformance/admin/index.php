<?php
    session_start();
    if($_SERVER['SERVER_PORT'] != '443') { 
        header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); 
        exit();
    }
    
    // Redirects to login page if haven't logged in or trying to access page as admin
    if (isset($_SESSION['member_username'])){
        unset($_SESSION['member_username']);
    }
    elseif (!isset($_SESSION['admin_username'])) {
        header("Location: ../login");
        exit();
    }
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="refresh" content="0;url=pages/index.php">
<title>SB Admin 2</title>
<script language="javascript">
    window.location.href = "./pages/"
</script>
</head>
<body>
Go to <a href="pages/index.php">/pages/index.php</a>
</body>
</html>