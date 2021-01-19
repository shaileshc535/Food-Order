<?php
    // include constant.php for SITEURL
    include('../config/constants.php');

    // 1.Destroy the session & redirect to the login page
    session_destroy(); 

    // .2 Redirect to Login page 
    header('location:'.$SITEURL.'admin/login.php');

?>