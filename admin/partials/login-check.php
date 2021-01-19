
<?php 
    // Authorization 
    // check wether user is loged in or not
    if(!isset($_SESSION['user'])) // if user session is not set
    {
        // user is not loged in 
        $_SESSION['no-login-message']="<div class='error text-center'>Please Login to access Admin Pannel.</div>";
        //redirect to login page
        header('location:'.$SITEURL.'admin/login.php');
        
    }  

?>