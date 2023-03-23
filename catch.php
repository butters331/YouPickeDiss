<?php
    session_start();
    $_SESSION["basket"] = json_encode($_POST);
?>