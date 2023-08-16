



<?php
    ob_start();
    include("partials/menu.php"); 
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>
        <?php
        
        if(isset($_SESSION['uploaded'])){
            // print_r(2);
            $message= $_SESSION['uploaded'];
            echo "<div class='alert alert-error'>
                <strong> $message </strong>
            </div>";    
            // echo $_SESSION['uploaded']; //displayimg session message
            unset($_SESSION['uploaded']);  //removing session message
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>

                <tr>
                    <td> Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the food"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                        
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>

                    <td>
                        <select name="category" id="">
                       
                            <?php 
                                //Create PHP code to display categories from Database
                                //1. CReate SQL to get all active categories from database
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                                //Executing query
                                $res = mysqli_query($conn, $sql);

                                //Count rows to check whether we have category or not
                                $count = mysqli_num_rows($res);

                                //If count is greater than zeo, we have category else we do  not have categories
                                if($count>0){   
                                    //we have categories
                                    while($row=mysqli_fetch_assoc($res)){
                                        //get the details of categories
                                        $id = $row['id'];
                                        $title = $row['title'];
                                        ?>
                                            
                                            <option value=" <?php echo $id ?>"><?php echo $title; ?></option>
                                        <?php
                                    }

                                }
                                else{

                                    // no categories found
                                    ?>
                                        <option value="0">No Category Found</option>
                                    <?php

                                }


                                //Display on drop down
                            ?>
                            
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> YES
                        <input type="radio" name="featured" value="No"> NO
                    </td>
                </tr>

                <tr>
                    <td>value: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> YES
                        <input type="radio" name="active" value="No"> NO
                    </td>
                </tr>

                <tr>
                    <td colspan="2" >
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                        
                </tr>
            </table>
        </form>


        <?php  
        
            //Check whether the button is clicked or not. 
            if(isset($_POST['submit'])){
                // Add the Food in database

                //1. Get the data from FORM
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $description = mysqli_real_escape_string($conn, $_POST['description']);
                $price = mysqli_real_escape_string($conn, $_POST['price']);
                $category = mysqli_real_escape_string($conn, $_POST['category']);

                //Check whether radio button for featured and active are checked or not
                if(isset($_POST['featured'])){
                    $featured = $_POST['featured'];
                    
                }
                else{
                    $featured = "No"; //Settin gthe default value

                }

                if(isset($_POST['active'])){
                    $active = $_POST['active'];
                    
                }
                else{
                    $active = "No";  //Settin gthe default value

                }

                //2. upload the image if selected
                //check whether select image is clicked or not and upload image only if the image is clicked or not
                if(isset($_FILES['image']['name'])){
                    //Get the details of the selected image
                    $image_name = $_FILES['image']['name'];

                    //check whether the im age is selected or not and uploadimage only if selected
                    if($image_name != ""){
                        // it means image is selected
                        // A. rename the Image
                        //get the extension of selected image (jpg, png, git, etc)
                        $ext = end(explode('.', $image_name));

                        //Create new name for the image
                        $image_name = "Food_Category".rand(0000,9999).".".$ext; //New image name may be like "Food-Name"

                        // B. upload the image
                        //get the Src path and destination path


                        //Source path is the current location of the image
                        $src = $_FILES['image']['tmp_name'];

                        //Destination path for the image to be uploaded
                        $dst = "../images/food/".$image_name;

                        //finally upload the food image
                        $upload = move_uploaded_file($src, $dst);

                        //check whethern image uploaded or not
                        if($upload ==false){
                            //failed to uploaded the image
                            //redirect to add food page with error message
                            $_SESSION['uploaded'] = "<div class='error'>failed to upload image.</div>";
                            header('location:'.SITEURL.'admin/add-food.php');
                            //stop the process
                            die();
                        }

                    }
                }
                else{
                    $image_name = ""; //setting defaul value as blank
                }

                //3. inport into database
                //create the sql  query to save or add food
                $sql2 = "INSERT INTO tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active'
                ";

                //Execute the query
                $res2 = mysqli_query($conn, $sql2);

                //check whether data inserted or not
                // 4. redirect with message to manage food page

                if($res2 == true){
                    //data inserted successfully
                    $_SESSION['add'] = "<div class='success'>Food added succesfully.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else{
                    $_SESSION['add'] = "<div class='error'>Failed to add food.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }

            }
        
        
        
        ?>



    </div>
</div>


<?php include("partials/footer.php"); ?>
