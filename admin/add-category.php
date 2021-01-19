<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>

        <?php
            if(isset($_SESSION['add'])){
                echo $_SESSION['add'];
                unset ($_SESSION['add']);
            }
            if(isset($_SESSION['upload'])){
                echo $_SESSION['upload'];
                unset ($_SESSION['upload']);
            }
        ?>

        <br><br>
        <!-- //add category form start here -->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Enter Category Title">
                    </td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image" >
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
        <!-- //add category form end here -->
        <?php
            // check wether the submit button is clicked or not
            if(isset($_POST['submit'])){
                // echo "clicked";
                // 1. get the value from category form
                $title=$_POST['title'];

                //2. For radio input, we need to check wether the button is selected or not
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
                
                //check wether the image file is selected or not & set the value for image name accoridingly
                // print_r($_FILES['image']);
                // die(); // breck the code here
                if(isset($_FILES['image']['name'])){
                    //upload the image
                    //To upload image we need image name & source path & destination path
                    $image_name = $_FILES['image']['name'];

                    // upload image only if image is selected
                    if($image_name!=""){

                        //Auto Rename our image
                        //get thge extension of our image (jpg, png, gif, etc)
                        $ext=end(explode('.', $image_name));

                        //rename the image
                        $image_name="Food_Category_".rand(0000,9999).'.'.$ext; 

                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../images/category/".$image_name;

                        //finally upload the image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //check whether the image is uploaded or not
                        // And if the images is not uploaded then we will stop the process & redirect with error message

                        if($upload==false)
                        {
                            //set message
                            $_SESSION['upload']="<div class='error' >Failed to Upload Image. </div>";
                            // redirect to add category page
                            header('location:'.$SITEURL.'admin/add-category.php');
                            // stop the process
                            die();
                        }
                    }
                    
                }
                else{
                    //dont upload image & set the image name value blank
                    $image_name="";
                }

                //3. create sql query to insert category in database
                $sql="INSERT INTO tbl_category SET
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                    ";
                //4. execute the query & save the database
                $res=mysqli_query($conn, $sql);

                //5. check wether the query exeuted or not & data added or not
                if($res==true){
                    //query executed & category added
                    $_SESSION['add']="<div class='success'>Category Added Successfully</div>";
                    //Redirect to manage category paage
                    header('location:'.$SITEURL.'admin/manage_category.php');
                }
                else{
                    //failed to add category
                    $_SESSION['add']="<div class='error'>Failed To Add Category</div>";
                    //Redirect to manage category paage
                    header('location:'.$SITEURL.'admin/add-category.php');
                }
            }
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>