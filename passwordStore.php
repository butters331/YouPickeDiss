<?php
    session_start();
    $_SESSION['passHash'] = md5($_POST['password']);
    header('Location:index.php');
?>