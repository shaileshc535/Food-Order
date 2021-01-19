<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>

        <?php
            if(isset($_SESSION['upload'])){
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
            if(isset($_SESSION['add'])){
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
        ?>

        <br><br>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the food">
                    </td>
                </tr>
                <tr>
                    <td>Discription:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Food Discription"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" placeholder="Price">
                    </td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">
                            <?php
                            //create php code to display categories from database
                            //1. create sql query to get all active categories 
                            $sql="SELECT * FROM tbl_category WHERE active='Yes'";

                            //executing the query
                            $res=mysqli_query($conn, $sql);

                            //count rows to check wether we have categories or not
                            $count=mysqli_num_rows($res);

                            //if count is >0 we have categories else we do nat have category
                            if($count>0){
                                //we have category
                                while($row=mysqli_fetch_assoc($res)){
                                    //get the details of categories
                                    $id=$row['id'];
                                    $title=$row['title'];
                                    ?>

                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                    <?php
                                }
                            }
                            else{
                                //we do not have category
                            ?>
                            <option value="0">No Categories Found</option>
                            <?php
                            }
                            ?>
                        </select>
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
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
            //check wether the button is clicked or not
            if(isset($_POST['submit'])){
                //add the food in database

                //1. get the data from form
                $title=$_POST['title'];
                $description=$_POST['description'];
                $price=$_POST['price'];
                $category=$_POST['category'];

                //wether radio button for featured & active checked or not
                if(isset($_POST['featured'])){
                    //get the value from form
                    $featured=$_POST['featured'];
                }else{
                    //set the default value
                    $featured="No";
                }

                if(isset($_POST['active'])){
                    //get the value from form
                    $active=$_POST['active'];
                }else{
                    //set the default value
                    $active="No";
                }
                
                //2. upload the image if selected

                //check wether the select image is clicked or not & upload the image only if selected
                if(isset($_FILES['image']['name'])){
                    //get the details of the selected image 
                    $image_name = $_FILES['image']['name'];

                    //check image is selected or not & upload if image selected
                    if($image_name!=""){
                        //image is selected

                        //A. rename the image
                        //get the extension of selected image like jpg png gif etc
                        $ext=end(explode('.', $image_name));

                        //create new name for image
                        $image_name="Food_Category_".rand(0000,9999).'.'.$ext; 


                        //B. upload the image

                        //get the source path & destination path
                        $source_path = $_FILES['image']['tmp_name'];
                            
                        //destination path to upload the images
                        $destination_path = "../images/food/".$image_name;

                        //upload the food image                             
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //check wether image is uploded or not 
                        if($upload==false){
                            //failed to upload image
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";

                            //redirect to add_food page
                            header('location'.$SITEURL.'admin/add-food.php');

                            //stop the proccess
                            die();
                        }
                    }
                }
                else{
                    $image_name=""; //setting default value as blank
                }

                //3.insert into database

                //create the sql query to save our add food

                $sql2 ="INSERT INTO `tbl_food` (`title`, `description`, `price`, `image_name`, `category_id`, `featured`, `active`) VALUES ('$title', '$description', '$price', '$image_name', '$category', '$featured', '$active')";

                //execute the query
                $res2=mysqli_query($conn, $sql2);

                //4. redirect to manage food page with message

                //check wether data is inseted or not
                if($res2==true){
                    //data inserted successfully
                    $_SESSION['add']="<div class='success'>Food Added Successfully.</div>";
                    header('location:'.$SITEURL.'admin/manage_food.php');
                }
                else{
                    //failed to insert data
                    $_SESSION['add']="<div class='error'>Failed to Add Food.</div>";
                    header('location:'.$SITEURL.'admin/manage_food.php');
                }
            } 
            
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>