<?php
     include('partials/menu.php'); 
?>
    <div class="main-content">
        <div class="wrapper">
            <h1>Add Category</h1>
            
            <br><br>

            <?php
                if(isset($_SESSION['add']))
                {
                    echo $_SESSION['add'];
                    unset($_SESSION['add']); 
                }
                if(isset($_SESSION['upload']))
                {
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']); 
                }
            ?>
            <br><br>

            <!-- Add Category starts here! -->
            <form action="" method="POST" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Title:</td>
                        <td>
                            <input type="text" name="title" placeholder="Category Title">
                        </td>
                    </tr>
                    <tr>
                        <td>Select Image:</td>
                        <td>
                        <input type="file" name="image">
                        </td>
                    </tr>
                    <tr>
                        <td>Featured:</td>
                        <td>
                            <input type="radio" name="featured" value="Yes">Yes
                            <input type="radio" name="featured" value="No">No
                        </td>
                    </tr>
                    <tr>
                        <td>Active:</td>
                        <td>
                            <input type="radio" name="active" value="Yes">Yes
                            <input type="radio" name="active" value="No">No
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                        </td>
                    </tr>
                </table>    
            </form>
             
            <!-- Add Category ends here! -->
            <?php
                //Check if submit button is clicked or not
                if(isset($_POST['submit']))
                {
                    //echo 'Clicked';

                    //1. Get the value from category form
                    $title = mysqli_real_escape_string($conn, $_POST['title']);

                    //For radio input type, check whether the radio is selected or not.
                    if(isset($_POST['featured']))
                    {
                        //Get value from category form
                        $featured = $_POST['featured'];
                    }
                    else{
                        //Set a default value
                        $featured = "No";
                    }
                    if(isset($_POST['active']))
                    {
                        //Get value from category form
                        $active = $_POST['active'];
                    }
                    else{
                        //Set a default value
                        $active = "No";
                    }
                    if(isset($_FILES['image']['name']))
                    {
                        //Upload the image 
                        //To upload the image,we need the image name.
                        $image_name = $_FILES['image']['name'];

                        //Upload the imageonly if the image name is available.
                        if($image_name !="")
                        {

                            //Auto Rename the image
                            //Get the extension of the image (jpg,png,)
                            $ext = end(explode('.', $image_name));

                            //Rename the image
                            $image_name = "Food_Category_".rand(000, 999)."."."$ext";

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
                                header('location:'.SITEURL.'admin/add-category.php');

                                //Stop the Process
                                die();
                            }
                        }
                    }
                    else
                    {
                        //Dont upload image and set the image_value name blank.
                        $image_name="";
                    }
                    //Create SQL Query.
                    $sql = "INSERT INTO tbl_category SET 
                        title='$title',
                        image_name='$image_name',
                        featured='$featured',
                        active='$active'
                    ";

                    //Execute the query
                    $res = mysqli_query($conn, $sql);
                    if($res==true)
                    {
                        //Query executed and category added
                        $_SESSION['add'] = "<div class='success'>Category Added Successfully</div>";

                        header('location:'.SITEURL.'admin/manage-category.php');
                    }
                    else{
                        {
                            //Query executed and category added
                            $_SESSION['add'] = "<div class='error'>Failed to add Category </div>";
    
                            header('location:'.SITEURL.'admin/add-category.php');
                        }
                    }
                }
             
            
            ?>

        </div>
    </div>
<?php include('partials/footer.php'); ?>
