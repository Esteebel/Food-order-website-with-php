<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h2>Add Admin</h2>

        <br> <br>
        <?php 
            if(isset($_SESSION['add']))
            {
              echo $_SESSION['add'];    //Adding Session Message
              unset($_SESSION['add']);  //Deleting Session Message
            }
            
          ?>
          <br> <br>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td> 
                        <input type="text" name="full_name" placeholder="Enter Your Name">
                    </td>  
                </tr>
                <tr>
                    <td>User Name:</td>
                    <td> 
                        <input type="text" name="user_name" placeholder="Enter Your User Name">
                    </td>  
                </tr>
                <tr>
                    <td>Password:</td>
                    <td> 
                        <input type="password" name="password" placeholder=" Your Password Here!">
                    </td>  
                </tr>
                <tr>
                    <td colspan="2"> 
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>  
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php');?>

<?php
    //process the value from form and save it in Database
    //Chech whether the submit button is checked or not
    if(isset($_POST['submit']))
    {
        //button clicked
        //echo 'button is clicked';
        
        //1. Get data from form
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
        $password = md5($_POST['password']);  //password encryption with md5

        //2. SQL Query to save the data into the Database
        $sql = "INSERT INTO tbl_admin SET
            full_name='$full_name',
            user_name='$user_name',
            password='$password'
        ";
       
       //Executing and saving Data into Database
        $res = mysqli_query($conn, $sql) or die(mysqli_error($error));

        //Check whether the Query is Executed (data is inserted) or not and display appropriate message
        if($res==true){
            //Data inserted
            //Create Session to display message
            $_SESSION['add'] = '<div class="success">Admin Added Successfully</div>';
            //redirection to Manage Admin
            header('location:'.SITEURL.'admin/manage-admin.php'); 
            
        }
        else
        {
            //failed to insert Data
            //Create Session to display message
            $_SESSION['add'] = '<div class="error">Failed to Add Admin</div>';
            //redirection to Add Admin
            header('location:'.SITEURL.'admin/add-admin.php'); 
            
        }
    }
?>

