<?php
    include ('../config/constants.php');
    //1. Get the ID of the Admin to be deleted
         $id = $_GET['id'];
    //2. Create SQL Query to Delete DB
        $sql= "DELETE FROM tbl_admin WHERE id=$id";

        //Execute the Query
        $res=mysqli_query($conn,$sql);

        //Check whether the query succeeded
        if($res==true)
        {
            $_SESSION['delete'] ='<div class="success">Admin Deleted Successfully</div>';
            //Redirect to the Manage Admin page
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
        else
        {
            $_SESSION['delete'] = '<div class="error">Failed to delete Admin</div>';
            //Redirect to the Manage Admin page
            header('location:'.SITEURL.'admin/manage-admin.php');
        }

    //3. Redirect to Manage admin page with message(sucess/error)

?>