<?php 
                        //Dispaly all the categories that are active
                        //SQL query
                        $sql = "SELECT * FROM tbl_category WHERE active='Yes'"; 

                        //Execute the query
                        $res = mysqli_query($conn, $sql);

                        $count = mysqli_num_rows($res);
                        if($count>0)
                        {
                            //Categories Available
                            while($row=mysqli_fetch_assoc($res))
                            {
                                //Get the values
                                $id = $row['id'];
                                $title = $row['title'];
                                $image_name = $row['image_name'];
                                ?>
                                    <a href="category-foods.html">
                                        <div class="box-3 float-container">
                                            <?php
                                                if($image_name=="")
                                                {
                                                    //Image not Available
                                                    echo "<div class='error'>image not Found</div>";
                                                }
                                                else
                                                {
                                                    //Image Available
                                                    ?>
                                                         <img src="<?php echo SITEURL;?>images/category/<?php echo $image_name; ?>" alt="<?php $title;?>" class="img-responsive img-curve">
                                                    <?php

                                                }
                                            ?>

                                            
                                            <h3 class="float-text text-white"><?php $title; ?></h3>
                                        </div>
                                    </a>
                                <?php
                            }
                        }
                        else
                        {
                            //Category Available
                            
                        }
                    ?>