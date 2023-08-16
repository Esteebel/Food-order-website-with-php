<?php include('partials/menu.php') ;?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Change Password</h1>

            <br><br>

            <?php 
                if(isset($_GET['id']))
                {
                    $id=$_GET['id'];
                }
                
            ?>

            <form action="" method="POST">
                <table class="tbl-30">
                    <tr>
                        <td>Current Password</td>
                        <td>
                            <input type="password" name="current_password" placeholder="Current Password">
                        </td>
                    </tr>
                    <tr>
                        <td>new Password</td>
                        <td>
                            <input type="password" name="new_password" placeholder="new Password">
                        </td>
                    </tr>
                    <tr>
                        <td>Confirm Password</td>
                        <td>
                            <input type="password" name="confirm_password" placeholder="Confirm Password">
                        </td>
                    </tr>
                    <tr>
                        
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input class="btn-secondary" type="submit" value="change password" name="submit" placeholder="Current Password">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <?php
    
        if(isset($_POST['submit']))
        {
            //Get the data from form
            $id=mysqli_real_escape_string($conn, $_POST['id']);
            $current_password=md5($_POST['current_password']);
            $new_password=md5($_POST['new_password']);
            $confirm_password=md5($_POST['confirm_password']);

            //Check if the user with the ID and current password exists or not
            $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

            //Execute the Query
            $res=mysqli_query($conn, $sql);

            if($res==true)
            {
                //check whether data is available in the DB or not
                $count=mysqli_num_rows($res);

                if($count==1)
                {
                    //user exist and password can be changed
                    //echo "User Found";
                    if($new_password==$confirm_password)
                    {
                        //update new password
                        $sql2="UPDATE tbl_admin SET 
                            password='$new_password'
                            WHERE id=$id
                         ";
                         $res=mysqli_query($conn, $sql2);

                         //Check whether the query executed or not
                         if($res==true)
                         {
                            //Dispaly Sucess Message and Rediirec to Admin
                            $_SESSION['change-pswd']="<div class='success'>Password Changed Successfully.</div>";
                            //Redirect the User
                            header('location:'.SITEURL.'admin/manage-admin.php');
                         }
                         else
                         {
                            //Display error message
                            $_SESSION['change-pswd']="<div class='error'>Unable to change Password</div>";
                            header('location:'.SITEURL.'admin/manage-admin.php');
                         }
                    }
                    else
                    {
                        //Redirect to Manage Admin
                        $_SESSION['pswd-not-match']="<div class='error'>Password did not match</div>";
                        //Redirect the User
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                }
                else
                {
                    //User doesnt exist
                    $_SESSION['user-not-found']="<div class='error'>User not found</div>";
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }

            //3. Check whether the new password and current password are the same or not


            //4. Change Password if all above is true
        }
    
    ?>

<?php include('partials/footer.php') ;?>
