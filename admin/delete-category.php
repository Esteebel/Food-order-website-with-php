<?php
    include('../config/constants.php');
  //echo 'Delete page';  
  //Check whether the id and the image name is set or not
  if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //echo 'Get Value and Delete';
        //GEt the variables
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];
        
        //Remove the physical image from the folder
        if($image_name !='')
        {
            //image name is available so remove it
            $path = "../images/category/".$image_name;

            //Remove the image
            $remove = unlink($path);

            //If it fails to remove
            if($remove==false)
            {
                //Set the session me ssage
                $_SESSION['remove'] = "<div class='error'>Failed to Remove Category Image.</div>";

                //Redirect to Manage category page
                header('location'.SITEURL.'admin/manage-category.php');

                //Stop the process
                die();
            }
        }
        
            
                //Delete Data from DB
                $sql = "DELETE FROM tbl_category WHERE id=$id";

                //Execute the query
                $res = mysqli_query($conn, $sql);

                //check if the query succeeded
                if($res==true)
                {
                    //Set the session message
                    $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully.</div>";
                    
                    //Redirect to admin category page
                    header('location:'.SITEURL.'admin/manage-category.php');
            
                }
                else
                {
                    //Redirect to manage category with message
                    //Set the session message
                    $_SESSION['delete'] = "<div class='error'> Failed to Delete Category.</div>";
                        
                    //Redirect to admin category page
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
            
    }
  else
  {
    //redirect to Manage category page
    header('location:'.SITEURL.'admin/manage-category.php');
  }

?>