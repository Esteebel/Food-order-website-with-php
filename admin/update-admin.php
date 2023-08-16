<?php include('partials/menu.php');?>

    <div class = "main-content">
        <div class="wrapper">
            <h1>Update Admin</h1>

            <br><br>

            <?php
            
                //1. Get ID of Selected Admin
                $id=$_GET['id'];

                //2. Create SQL Query to get the details
                $sql="SELECT * FROM tbl_admin WHERE id=$id";

                //3. Execute the Query
                $res=mysqli_query($conn, $sql);
                
                //Check whether the query is executed or not
                if($res==TRUE)
                {
                    //Check whether thr data is available or not
                    $count = mysqli_num_rows($res);

                    //Check whether we have Admin data or not
                    if($count==1)
                    {
                        //Get the Details
                        $row=mysqli_fetch_assoc($res);

                        $full_name = $row['full_name'];
                        $user_name = $row['user_name'];
                    }
                    else
                    {
                        //Redirect to Manage Admin
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                }


            
            ?>

            <form action="" method="POST">
                <table class="tbl-30">
                    <tr>
                        <td>Full Name:</td>
                        <td> 
                            <input type="text" name="full_name" value="<?php echo $full_name;?>">
                        </td>  
                    </tr>
                    <tr>
                        <td>User Name:</td>
                        <td> 
                            <input type="text" name="user_name" value="<?php echo $user_name;?>">
                        </td>  
                    </tr>
                    <tr>
                        <td colspan="2"> 
                            <input type="hidden" name="id" value="<?php echo $id; ?>" >
                            <input type="submit" name="submit" value="update Admin" class="btn-secondary">
                        </td>  
                    </tr>
                </table>

            </form>
        
        </div>
    </div>
    <?php
    
        //Check if the Submit Button is Clicked or not
        if(isset($_POST['submit']))
        {
           // echo 'Button Clicked';
           //Get all form values for update
            $id = mysqli_real_escape_string($conn, $_POST['id']);
            $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
            $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);

            //Create a SQL Querry to Update the DB
            $sql="UPDATE tbl_admin SET 
            full_name = '$full_name',
            user_name = '$user_name' 
            WHERE id='$id'
            ";

            //Execute a SQL Query 
            $res=mysqli_query($conn, $sql);

            //Check whether the Query is Executed or not
            if($res==true)
            {
                $_SESSION['update'] = "<div class='success'>Admin Updated Successfully</div>";
               
                //Redirect to Manage Admin Page
                header('location:'.SITEURL.'admin/manage-admin.php');

            }
            else
            {
                $_SESSION['update'] = "<div class='error'>Failed to update Admin</div>";
               
                //Redirect to Manage Admin Page
                header('location:'.SITEURL.'admin/manage-admin.php');

            }

        }
        
    ?>

<?php include('partials/footer.php');?>
