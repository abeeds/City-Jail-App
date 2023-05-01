<?php
    // force username cookie to expire
    if (isset($_COOKIE['username'])) {
        setcookie('username', "", time() - 3600);
    }

    header('Location: ../User/criminals.php');
?>