<?php
    // force username cookie to expire
    if (isset($_COOKIE['username'])) {
        setcookie('username', "", time() - 3600, '/'); 
        unset($_COOKIE['username']);
    }

    header('Location: ../User/criminals.php');
?>