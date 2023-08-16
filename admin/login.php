<?php include('../config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Website</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="../css/Admin.css">
</head>
<body>
    <div class="login">
        <h1 class="text-center">Login</h1> 
        <br><br>

        <?php 
            if(isset($_SESSION['login']))
            {
                echo $_SESSION['login'];    // login Session Message
                unset($_SESSION['login']);  // Delete login Session Message
            }
            if(isset($_SESSION['no-login-message']))
            {
                echo $_SESSION['no-login-message'];    // no-login-message Session Message
                unset($_SESSION['no-login-message']);  // Delete no-login-message Session Message
            }
        ?>
        <br><br>
        <!-- login form starts here -->

        <form action="" method="POST" class="text-center">
            <label>Username:</label><br>
            <input type="text" name="username" placeholder ="Username"> <br><br>
            <label>Password:</label> <br>
            <input type="password" name="password"  placeholder ="Password"> <br><br>
            
            <input type="submit" name="submit" value="Login"> <br>
        </form>
        <!-- login form ends here -->
        <br>

        <p  class="text-center">Created By <a href="#">Esther Bamgbose</a></p>
    </div>
</body>
</html>

<?php

    if(isset($_POST['submit']))
    {
        //1. Get data from login form.
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));

        //2. Write a SQL query to chech if the username with the password exist or not
        $sql="SELECT * FROM tbl_admin WHERE user_name = '$username' AND password = '$password' ";
        print_r($sql);
        //3. Execute SQL query
        $res = mysqli_query($conn, $sql);

        //4. Count rows to check whether the user exist
        $count=mysqli_num_rows($res);

        if($count == 1)
        {
            //User available and login successfull.
            $_SESSION['login'] = "<div class='success '>Login Successful</div>";
            $_SESSION['user'] = $username;  //Check if the user is logged in or not and logout will unset it

            //Redirect to Home Page/Dashboard
            header('location:'.SITEURL.'admin/');
            
        }
        else
        {
            $_SESSION['login'] = "<div class='error text-center'>Username and Password didnt match</div>";
            header('location:'.SITEURL.'admin/login.php');


        }
    }

?>