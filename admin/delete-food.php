<?php
include('../config/constants.php');

    if(isset($_GET['id']) AND isset($_GET['image_name'])){
        // Process to delete

        // 1. get id & image name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // 2. remove the image if avilable
        if($image_name!= ""){
            // it has image need to remove it

            //get the image path
            $path = "../images/food/".$image_name;

            //remove files from the folder
            $remove = unlink($path);

            //wether check the image is removed or not
            if($remove==false){
                //failed to remove image
                $_SESSION['upload']="<div class='error'>Failed to Remove Image File.</div>";

                // redirect to manage food
                header('location:'.$SITEURL.'admin/manage_food.php');
                // stop the process
                die();
            }
            
            // 3. delete food from database 
            $sql="DELETE FROM tbl_food WHERE id=$id";
            
             //execute the query
            $res=mysqli_query($conn, $sql);
            
             //check wether data is deleted from database or not
            if($res==true){
                //food deleted
                $_SESSION['delete']="<div class='success'>Food Deleted Successfully.</div>";
                header('location:'.$SITEURL.'admin/manage_food.php');
            }
            else{
                //failed to delete food
                $_SESSION['delete']="<div class='error'>Failed to Delete Food.</div>";
            }    header('location:'.$SITEURL.'admin/manage_food.php');
        }       
    }
    else{
        //Redirect to manage_food page
        $_SESSION['unauthorized']="<div class='error'>Unauthorized Access.</div>";
        header('location:'.$SITEURL.'admin/manage_food.php');
    }
?>