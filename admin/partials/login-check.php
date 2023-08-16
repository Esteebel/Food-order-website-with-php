<?php
    //Authorization -Access Control
    //Check if the User is logged in or not
    if(!isset($_SESSION['user']))   //user session is not set
    {
        //User is not logged in
         
        $_SESSION['no-login-message'] = "<div class='error text-center'>Please login to access Admin panel.</div>";

        //Redirect to login page with message
        header('location:'.SITEURL.'admin/login.php');
    }

?>