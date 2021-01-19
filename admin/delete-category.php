<?php 
    //include constant.php
    include('../config/constants.php');

    //check wether the id & image_name value is set or not
    if(isset($_GET['id']) AND ($_GET['image_name'])){
        //get the value & delete
        $id=$_GET['id'];
        $image_name=$_GET['image_name'];

        //remove the physical image file if available 
        if($image_name!=""){
            // image is available so remove it
            $path="../images/category/".$image_name;
            //remove the image
            $remove=unlink($path);

            //if fail to remove image then add an error message & stop the proccess
            if($remove==false){
                //set the session message
                $_SESSION['remove']="<div class='error'>Failed to Remove Category Image.</div>";

                //redirect to manage category page
                header('location:'.$SITEURL.'admin/manage_category.php');

                //stop the process
                die();
            }

        }
        //delete data from data base
        //create the sql query to delete the category
        $sql="DELETE FROM tbl_category WHERE id=$id";

        //execute the query
        $res=mysqli_query($conn, $sql);

        //check wether data is deleted from database or not
        if($res==true){
            //set success message and redirect
            $_SESSION['delete']="<div class='success'>Category Deleted Successfully.</div>";

            //redirect to manage category
            header('location:'.$SITEURL.'admin/manage_category.php');
        }
        else{
            //set success message and redirect
            $_SESSION['delete']="<div class='error'>Failed to Delete Category.</div>";

            //set fail message & redirect
            header('location:'.$SITEURL.'admin/manage_category.php');
        }
    }
    else{
        //redirect to manage-category page
        header('location:'.$SITEURL.'admin/manage_category.php');
    }
   


?>