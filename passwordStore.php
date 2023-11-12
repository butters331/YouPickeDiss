<?php
    session_start();
    $_SESSION['passHash'] = md5(strtolower($_POST['password']));
    header('Location:index.php');
?>