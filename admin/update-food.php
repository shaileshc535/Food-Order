<?php include('partials/menu.php'); ?>

<?php 
//check wether id is set or not
    if(isset($_GET['id'])){
        //get all the detail
        $id=$_GET['id'];

        //sql query
        $sql2="SELECT * FROM tbl_food WHERE id=$id";

        $res2=mysqli_query($conn, $sql2);

        //get the value based on query
        $row2=mysqli_fetch_assoc($res2);

        //get the individual value of selected food
        $title=$row2['title'];
        $description=$row2['description'];
        $price=$row2['price'];
        $current_image=$row2['image_name'];
        $current_category=$row2['category_id'];
        $featured=$row2['featured'];
        $active=$row2['active'];

    }else{
        // redirect to manage food
        header('location:'.$SITEURL.'admin/manage_food.php');
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
                        <input type="text" name="title" value="<?php echo $title ; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Discription:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description ; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price ; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                            if($current_image==""){
                                //image not available
                                echo "<div class='error'>Image Not Available</div>";
                            }else{
                                //image available
                                ?>
                                <img src="<?php echo $SITEURL; ?>images/food/<?php echo $current_image; ?>" width="100px">
                                <?php
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Select New Image</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category" >
                        <?php
                        // query to get active categories
                            $sql= "SELECT * FROM tbl_category WHERE active='Yes'";

                            //execute the query
                            $res=mysqli_query($conn, $sql);

                            //count rows
                            $count=mysqli_num_rows($res);

                            //check wether category avilable or not
                            if($count>0){
                                //category available
                                while($row=mysqli_fetch_assoc($res)){
                                    $category_title=$row['title'];
                                    $category_id=$row['id'];
                                    
                                    ?>
                                        <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                    <?php
                                }
                            }else{
                                //category not available
                                echo "<option value='0'>Food Not Available.</option>";
                            }
                        ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id ;?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">

                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <?php
            if(isset($_POST['submit']))
            {   // 1. get all the details from the form 
                $id=$_POST['id'];
                $title=$_POST['title'];
                $description=$_POST['description'];
                $price=$_POST['price'];
                $current_image=$_POST['current_image'];
                $category=$_POST['category'];

                $featured=$_POST['featured'];
                $active=$_POST['active'];

                // 2. upload the image if selected
                // check wether upload button clicked or not
                if(isset($_FILES['image']['name']))
                {   //get the image detail
                    $image_name=$_FILES['image']['name'];

                    //check wether image is available or not
                    if($image_name!=""){
                        //image is available

                        //A. upload the new image 
                        //Auto Rename our image
                        //get thge extension of our image (jpg, png, gif, etc)
                        $ext = end(explode('.', $image_name));

                        //rename the image
                        $image_name = "Food_Name_".rand(0000, 9999).'.'.$ext; 

                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../images/food/".$image_name;

                        //finally upload the image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //check whether the image is uploaded or not
                        // And if the images is not uploaded then we will stop the process & redirect with error message

                        if($upload==false)
                        {
                            //set message
                            $_SESSION['upload']="<div class='error' >Failed to Upload Image. </div>";
                            // redirect to add category page
                            header('location:'.$SITEURL.'admin/manage_food.php');
                            // stop the process
                            die();
                        }
                        
                        // 3. remove the image if new image selected 
                        //remove current image if available
                        if($current_image!=""){
                            //current image is available
                            $remove_path = "../images/food/.$current_image";

                            $remove = unlink($remove_path);
                            
                            //check image is removed or not
                            if($remove==false){
                                //failed to remove image
                                $_SESSION['remove-failed']="<div class='error'>Failed to Remove Current Image</div>";
                                //reidrect to mana food
                                header('location:'.$SITEURL.'admin/manage_food.php');
                                //stop the proccess
                                die();
                            }
                        }else{
                            $image_name=$current_image;
                        }
                    }else{
                        $image_name=$current_image;
                    }
                }
                
                // 4. update the food in database
                $sql3="UPDATE tbl_food SET
                    title='$title',
                    description='$description',
                    price=$price,
                    image_name='$image_name',
                    category_id='$category',
                    featured='$featured',
                    active='$active'
                    WHERE id=$id
                ";
                $res3=mysqli_query($conn, $sql3);
                
                //whether the query is executed or not
                if($res3==true){
                    // query executed & food updated$
                    $_SESSION['update']="<div class='success'>Food Updated Successfully.</div>";
                    header('location:'.$SITEURL.'admin/manage_food.php');

                }else{
                    // redirect to manage food page with message
                    $_SESSION['update']="<div class='error'>Failed to update food.</div>";
                    header('location:'.$SITEURL.'admin/manage_food.php');
                }
            }
        ?>
    </div>
</div>
<?php include('partials/footer.php'); ?>
