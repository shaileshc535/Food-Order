<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Food</h1>
        <br><br>
        <?php
            if(isset($_SESSION['add'])){
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
            if(isset($_SESSION['delete'])){
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }
            if(isset($_SESSION['upload'])){
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
            if(isset($_SESSION['unauthorized'])){
                echo $_SESSION['unauthorized'];
                unset($_SESSION['unauthorized']);
            }
            if(isset($_SESSION['update'])){
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
            if(isset($_SESSION['failed-remove'])){
                echo $_SESSION['failed-remove'];
                unset($_SESSION['failed-remove']);
            }

        ?>
        <br><br>
        <!-- Button to add Food -->
        <a href="<?php echo $SITEURL; ?>admin/add-food.php" class="btn-primary">Add Food</a>
        <br>
        <br>
        <br>
        <table class="tbl-full">
            <tr>
                <th>S.No</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Action</th>
            </tr>
            <?php
                //create sql query to get all the food 
                $sql="SELECT * FROM tbl_food";

                //execute the query
                $res=mysqli_query($conn, $sql);

                //count row to check wether we have food or not
                $count=mysqli_num_rows($res);

                //create serial number
                $sn=1;

                if($count>0){
                    //we have food in data base 
                    //get the foods from database & display
                    while($row=mysqli_fetch_assoc($res)){
                        //get the value from individual column
                        $id=$row['id'];
                        $title=$row['title'];
                        $discription=$row['description'];
                        $price=$row['price'];
                        $image_name=$row['image_name'];
                        $featured=$row['featured'];
                        $active=$row['active'];
                        ?>
                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $title; ?></td>
                            <td>$<?php echo $price; ?></td>
                            <td>
                                <?php 
                                    //check wether image we are have or not
                                    if($image_name==""){
                                        //we do not have image display error messgae
                                        echo "<div class='error'>Image Not Added</div>";
                                    }else{
                                        //we have image display image
                                        ?>
                                        <img src="<?php echo $SITEURL; ?>images/food/<?php echo $image_name; ?>" width="100px">
                                        <?php
                                    }
                                
                                ?>
                            </td>
                            <td><?php echo $featured; ?></td>
                            <td><?php echo $active; ?></td>
              
                            <td>
                                <a href="<?php echo $SITEURL ;?>admin/update-food.php?id=<?php echo $id ;?>" class="btn-secondary">Update Food</a>
                                <a href="<?php echo $SITEURL; ?>admin/delete-food.php?id=<?php echo $id ;?>&image_name=<?php echo $image_name ; ?>" class="btn-danger">Delete Food</a>
                            </td>
                        </tr>
                        <?php
                    }

                }else{
                    //food not adde in database
                    echo "<tr><td colspan='8' class='error'>Food Not Added Yet.</td></tr>";
                }
            ?>     
        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>