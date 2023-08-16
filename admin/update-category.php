<?php include('partials/menu.php');?> 

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>

        <br><br>

        <?php
            //Check whether id is set or not
            if(isset($_GET['id']))
            {
                //Get id and other details
                //echo "Getting started";
                $id = $_GET['id'];

                //Create SQL statement
                $sql = "SELECT * FROM tbl_category WHERE id=$id";

                //Execute the Query 
                $res = mysqli_query($conn, $sql);

                //Check if the data is present in the DB.
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    //There is data in Database, get them.
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];

                }
                else
                {
                    //There is no data in DB, redirect to manage admin page with message
                    $_SESSION['no-category-found'] = "<div class='error'> Category not Found</div>";

                    header('location:'.SITEURL.'admin/manage-category.php');
                }
            }
            else
            {
                //Redirect to Manage category
                header('location:'.SITEURL.'admin/manage-category.php');

            }
        ?>


        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                            if($current_image != "")
                            {
                                //Display the image
                                ?>
                                    <img src="<?php echo SITEURL;?>images/category/<?php echo $current_image;?>" width="100px">
                                <?php
                            }
                            else
                            {
                                //Display error Message
                                echo "<div class='error'>Image Not Added</div>";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>New Image:</td>
                    <td>
                        <input type="file" name="image" >
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>

                        <input <?php if($featured == "Yes") { echo "checked";} ?> type="radio" name="featured" value="Yes">Yes

                        <input <?php if($featured == "No") { echo "checked";} ?> type="radio" name="featured" value="No" >No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if($active == "Yes") { echo "checked";} ?> type="radio" name="active" value="Yes">Yes

                        <input <?php if($active == "No") { echo "checked";} ?> type="radio" name="active" value="No" >No
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image?>">
                        <input type="hidden" name="id" value="<?php echo $id?>">
                        <input type="submit" name="submit" value="update-category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        
        <?php
        
            if(isset($_POST['submit']))
            {
                //Get all the variables from form
                $id = mysqli_real_escape_string($conn, $_POST['id']);
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $current_image = mysqli_real_escape_string($conn, $_POST['current_image']);
                $featured = mysqli_real_escape_string($conn, $_POST['featured']);
                $active = mysqli_real_escape_string($conn, $_POST['active']);

                //2. Updating New Image if selected
                if(isset($_FILES['image']['name']))
                {
                    //Get the Image details
                    $image_name =$_FILES['image']['name'];
                    
                    //Check if the image is available or not
                    if($image_name != "")
                    {
                        //image Available
                        //A. Upload the new image
                        
                            //Auto Rename the image
                            //Get the extension of the image (jpg,png,)
                            $ext = end(explode('.', $image_name));

                            //Rename the image
                            $image_name = "Food_Category_".rand(000, 999).".".$ext;

                            $source_path =  $_FILES['image']['tmp_name'];

                            $destination_path = "../images/category/".$image_name;
                            
                            //Finally Upload the image
                            $upload = move_uploaded_file($source_path, $destination_path);

                            //Check Whether the image is uploaded or not
                            //if the image doesnt upload,we stop the process and give an error.
                            if($upload==false)
                            {
                                //Set the message
                                $_SESSION['upload'] = "<div class='error'>Failed to upload image</div>";

                                //Redirect to Add category page
                                header('location:'.SITEURL.'admin/manage-category.php');

                                //Stop the Process
                                die();
                            }

                            //B. Remove the image
                            if($current_image!="")
                            {
                                $remove_path ="../images/category/".$current_image;

                                $remove = unlink($remove_path);

                                //Check whether the image is removed or not
                                //If it failed to remove, then dispaly error message and stop the process.
                                if($remove==false)
                                {
                                    //Failed to remove image
                                    $_SESSION['not-removed'] = "<div class='error'>Failed to remove current Image</div>";

                                    header('location:'.SITEURL.'admin/manage-category.php');

                                    die();
                                }
                            }
                            

                    }
                    else
                    {
                        $image_name = $current_image;
                    }
                    
                }
                else
                {
                    $image_name = $current_image;
                }
                //3. Update the DB
                $sql2 = "UPDATE tbl_category SET 
                    title = '$title',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id
                ";

                //Execute the Query
                $res2 = mysqli_query($conn, $sql2);

                //Check whether the query is executed or not
                if($res2==true)
                {
                    //Category updated
                    $_SESSION['update'] = "<div class='success'>Category Updated Successfully</div>";

                    //Redirect to manage category
                    header('location:'.SITEURL.'admin/manage-category.php');

                }
                else
                {
                     //Category failed update
                     $_SESSION['update'] = "<div class='error'>Category Failed Update </div>";

                     //Redirect to manage category
                     header('location:'.SITEURL.'admin/manage-category.php');
  
                }
            

            }
        ?>
    </div>
</div>
<?php include('partials/footer.php');?> 
