<?php include('partials/menu.php');?>


<?php 
    //Check Whether id is set or not
    if(isset($_GET['id']))
    {
        //Get all the details
        $id = $_GET['id'];

        //SQL query to get selected folder
        $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

        //Execute the query
        $res2 = mysqli_query($conn, $sql2);

        //Get the value based on query selected
        $row2 = mysqli_fetch_assoc($res2);

        //Get the individual values from the selected food
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];
    }
    else
    {
        //Redirect to manage food 
        header('location:'.SITEURL.'admin/manage-food.php');

    }
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
           <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" value="<?php echo $title;?>" name="title" placeholder="Food title goes here">
                    </td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td>
                        <textarea name="description"  cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price;?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                            if($current_image == "")
                            {
                                //Image not available
                                echo '<div class="error">Image not Available</div>';
                            }
                            else
                            {
                                //Image Available
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px" >
                                <?php
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Select New Image:</td>
                    <td>
                        <input value="" type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category" >
                            <?php
                                //Query to Get Active category from the DB
                                $sql = "SELECT * FROM tbl_category WHERE active = 'yes'";
                                //Execute the query
                                $res = mysqli_query($conn, $sql);
                                //Count Rows
                                $count = mysqli_num_rows($res);
                                
                                //Check if the category is available or not
                                if($count >0)
                                {
                                    //Category Available
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        $category_title = $row['title'];
                                        $category_id = $row['id'];

                                        //echo "<option value='$category_id'>$category_title</option>";
                                        ?>
                                            <option <?php if($current_category==$category_id){echo "selected";}?> value="<?php echo $category_id ;?>"><?php echo $category_title;?></option>
                                        <?php
                                    }
                                }
                                else
                                {
                                    //Category Not available
                                    echo "<option value='0'>Category Not Available</option>";
                                }

                            ?>
                            
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes"){echo 'checked';}?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if($featured=="No"){echo 'checked';}?> type="radio" name="featured" value="No">No

                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes"){echo 'checked';}?> type="radio" name="active" value="Yes">Yes
                        <input <?php if($active=="No"){echo 'checked';}?> type="radio" name="active" value="No">No

                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image;?>">
                        <input type="submit" name="submit" value="update-food" class="btn-secondary">
                    </td>
                </tr>
           </table>
        </form>

        <?php

            if(isset($_POST['submit']))
            {
                //echo "Button Clicked";
                //1. Get all the details from the form
                $id = mysqli_real_escape_string($conn, $_POST['id']);
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $description = mysqli_real_escape_string($conn, $_POST['description']);
                $price = mysqli_real_escape_string($conn, $_POST['price']);
                $current_image = mysqli_real_escape_string($conn, $_POST['current_image']);
                $category = mysqli_real_escape_string($conn, $_POST['category']);
                $featured = mysqli_real_escape_string($conn, $_POST['featured']);
                $active = mysqli_real_escape_string($conn, $_POST['active']);

                //2. Upload the image if selected

                //Check whether upload button is clicked or not
                if(isset($_FILES['image']['name'])) 
                {
                    $image_name = $_FILES['image']['name']; //new image name

                    //Check whether the file is available or not
                    if($image_name!="")
                    {
                        $ext = end(explode('.', $image_name));

                        $image_name = "Food_Category".rand(0000, 9999).'.'.$ext;   //THis renames the image

                        //Get the source path and destination path of the image
                        $src_path = $_FILES['image']['tmp_name'];
                        $dest_path = "../images/food/".$image_name;

                        //A Upload the image
                        $upload = move_uploaded_file($src_path, $dest_path);

                        //Check whether the image is uploaded or not
                        if($upload==false)
                        {
                            //Failed to upload the image
                            $_SESSION['upload'] = "<div class='error'>Failed to upload new image</div>";

                            //Redirect to Manage Food
                            header('location:'.SITEURL.'admin/manage-food.php');
                            //Stop the process
                            die();
                        }
                        //3. remove the image if the new image is uploaded and current image exists

                        //B. Remove current image if available
                        if($current_image != "")
                        {
                            //Current Image is available
                            //Remove the image
                            $remove_path = "../images/food/".$current_image;

                            $remove = unlink($remove_path);

                            //Check whether the image is removed or not
                            if($remove==false)
                            {
                                //failed to remove current image
                                $_SESSION['remove-failed'] = "<div class='error'>Failed to remove current image</div>";
                                //Redirect to Manage Food
                                header('location:'.SITEURL.'admin/manage-food.php');
                                //Stop the process
                                die();
                            }
                        }
                    }
                    else
                    {
                        $image_name = $current_image;   //Default image when image is not selected
                    }
                }
                else
                {
                    $image_name = $current_image;       //Default image when image is not clicked
                } 


                //4. Update the food in DB
                $sql3 = "UPDATE tbl_food SET 
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id 
                ";
                //Execute the query
                $res3 = mysqli_query($conn, $sql3);

                //Check Whether the query succeeded
                if($res3==true)
                {
                    //Querry Executed and Food updated
                    $_SESSION['update'] = "<div class='success'>Food Updated</div>";
                    //Redirect to Manage Food
                    header('location:'.SITEURL.'admin/manage-food.php');
                    
                }
                else
                {
                    $_SESSION['update'] = "<div class='error'>Food not Updated</div>";
                    //Redirect to Manage Food
                    header('location:'.SITEURL.'admin/manage-food.php');
                }

                //Redirect to manage food with Session Message
            }
        ?>

    </div>
</div>
<?php include('partials/footer.php')?>