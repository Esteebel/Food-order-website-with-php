<?php include('partials/menu.php'); ?>  

   <!-- Main Content section starts-->
   <div class="main-content">
        <div class="wrapper">
          <h1>DASHBOARD</h1>
            <br><br>

            <?php
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];    // login Session Message
                    unset($_SESSION['login']);  // Delete login Session Message
                }
            ?>
            <div class="col-4 text-center">

                <?php
                    //SQL query
                    $sql = "SELECT * FROM tbl_category";
                    //Execute SQL query
                    $res = mysqli_query($conn, $sql);
                    //Count Rows
                    $count = mysqli_num_rows($res);

                ?>

                <h1><?php echo $count; ?></h1>
                <br>
                Categories
            </div>
            <div class="col-4 text-center">

                <?php
                    //SQL query
                    $sql2 = "SELECT * FROM tbl_food";
                    //Execute SQL query
                    $res2 = mysqli_query($conn, $sql2);
                    //Count Rows
                    $count2 = mysqli_num_rows($res2);

                ?>

                <h1><?php echo $count2; ?></h1>
                <br>
                Foods
            </div>
            <div class="col-4 text-center">
                <?php
                    //SQL query
                    $sql3 = "SELECT * FROM tbl_order";
                    //Execute SQL query
                    $res3 = mysqli_query($conn, $sql3);
                    //Count Rows
                    $count3 = mysqli_num_rows($res3);

                ?>
                <h1><?php echo $count3; ?></h1>
                <br>
                Total Orders
            </div>
            <div class="col-4 text-center">
                <?php 
                    //Create SQL Query to get Total Revenue
                    //Aggregate Function in SQL
                    $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";

                    //Execute the Query
                    $res4 = mysqli_query($conn, $sql4);

                    //Get the value
                    $row4 = mysqli_fetch_assoc($res4);

                    //Get the total Revenue
                    $total_revenue = $row4['Total'];
                ?>
                <h1> $ <?php echo $total_revenue; ?></h1>
                <br>
                Revenue Generated
            </div>
            <div class="clear-fix"></div>
        </div>
        
   </div>
   <!-- Main Content section ends-->

<?php include('partials/footer.php'); ?>  
 

