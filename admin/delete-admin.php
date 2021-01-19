<?php
// include constant.php
include('../config/constants.php');
    //get the id of Admin to be deleted
    $id = $_GET['id'];
    //Create SQL Query to Delete Admin
    $sql =  "DELETE FROM tbl_admin WHERE id=$id";

    //Redirect to manage admin page with masage (success/failure)
    $res = mysqli_query($conn, $sql);

    // check whether the query executed successfully or not
    if($res==TRUE){
        //create session veriable to display message 
        $_SESSION['delete'] = '<div class="success"> Admin Delete Successfully.</div>';
        //redirect to manage admin page
        header('location:'.$SITEURL.'admin/manage_admin.php');
    }
    else{
        // Failed to delete
        $_SESSION['delete'] = '<div class="error"> Admin not Deleted Try Again Later.</div>';
        //redirect to manage admin page
        header('location:'.$SITEURL.'admin/manage_admin.php');
    }

?>