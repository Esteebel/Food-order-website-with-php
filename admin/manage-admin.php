<?php include('partials/menu.php'); ?>  

   <!-- Main Content section starts-->
   <div class="main-content">
        <div class="wrapper">
          <h1>Manage Admin</h1>

          <br>

          <?php 
            if(isset($_SESSION['add'])){
              echo $_SESSION['add'];    //Adding Session Message
              unset($_SESSION['add']);  //Deleting Session Message
            }
            if(isset($_SESSION['delete']))
            {
                echo $_SESSION['delete'];    //Add Delete Session Message
                unset($_SESSION['delete']);  //Deleting Session Message
            }
            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];    // Update Session Message
                unset($_SESSION['update']);  // Delete Update Session Message
            }
            if(isset($_SESSION['user-not-found']))
            {
                echo $_SESSION['user-not-found'];    // user-not-found Session Message
                unset($_SESSION['user-not-found']);  // Delete user-not-found Session Message
            }
            if(isset($_SESSION['pswd-not-match']))
            {
                echo $_SESSION['pswd-not-match'];    // pswd-not-match Session Message
                unset($_SESSION['pswd-not-match']);  // Delete pswd-not-match Session Message
            }
            if(isset($_SESSION['change-pswd']))
            {
                echo $_SESSION['change-pswd'];    // change-pswd Session Message
                unset($_SESSION['change-pswd']);  // Delete change-pswd Session Message
            }
      
          ?>
          <br> <br>
          <!-- button to add admin -->
          <a href="add-admin.php"><button class="btn-primary">Add Admin</button></a>

          <br><br>

          <table class="tbl-full">
              <tr>
                <th>S.N.</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
              </tr>

                <?php 
                  //Query to get All Admin 
                  $sql = "SELECT * FROM tbl_admin";
                  //Execute the Query
                  $res = mysqli_query($conn, $sql);
                  $sn=1;
                  //Check whether the query is executed or not
                  if($res==TRUE)
                  {
                    //count whether the Database is empty or not
                    $count = mysqli_num_rows($res);  // function to get all the rows in database

                    //check the number of rows in the table
                    if($count>0)
                    {
                      //there is data in the DB
                        while($rows=mysqli_fetch_assoc($res))
                        {
                          //using while loop to get all the dta from the DB
                          //And while loop will run as long as we have data in the DB

                          //get individual data 
                          $id=$rows['id'];
                          $full_name=$rows['full_name'];
                          $user_name=$rows['user_name'];
 
                          //Displaying the value in one table
                          ?>
                          <tr>
                            <td><?php echo $sn++?></td>
                            <td><?php echo $full_name ; ?></td>
                            <td><?php echo $user_name; ?></td>
                            <td>
                            <a href="<?php echo SITEURL ;?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                              <a href="<?php echo SITEURL ;?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                              <a href="<?php echo SITEURL ;?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">delete Admin</a>
                            </td>
                          </tr>

                          <?php
                        }
                    }
                    else
                    {
                      // there is not data in the DB
                    }
                  }
                ?>
          </table>
        </div>
    </div>
   <!-- Main Content section ends-->


   <?php include('partials/footer.php'); ?>  