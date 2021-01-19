<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br><br>

        <?php
        // 1. get the of selected admin
        $id=$_GET['id'];

        // 2. create sql query to get the details
        $sql="SELECT * FROM tbl_admin WHERE id=$id";

        // 3. execute the query
        $res=mysqli_query($conn, $sql);

        // 4. check the whether is query is executed or not
        if($res==true) {
            $count = mysqli_num_rows($res);

            if($count==1) {
                //get the details
                $row=mysqli_fetch_assoc($res);

                $name = $row['name'];
                $username = $row['username'];
            } 
            else{
                // redirect to manage the admin page
                header('location:' . $SITEURL . 'admin/manage_admin.php');
            }
        }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Name:</td>
                    <td>
                        <input type="text" name="name" value="<?php echo $name; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php
    //check whether the submit button is clicked or not
    if(isset($_POST['submit'])) {
        //get all the value from the form to update
        $id = $_POST['id'];
        $name = $_POST['name'];
        $username = $_POST['username'];

        //create sql query to update admin
        $sql="UPDATE tbl_admin SET
        name='$name',
        username='$username'
        WHERE id='$id'";

        //execute the query
        $res=mysqli_query($conn, $sql);

        //check the query is executed successfuly or not
        if($res==true) {
            //query executed & admin updated 
            $_SESSION['update'] = "<div class='success'>Admin Updated successfully.</div>";
            //redirect to the manage admin page
            header('location:'.$SITEURL.'admin/manage_admin.php');
        } 
        else {
            //faled to update admin
            $_SESSION['update'] = "<div class='error'>Admin Updation is unsuccessfull.</div>";
            //redirect to the manage admin page
            header('location:'.$SITEURL.'admin/manage_admin.php');
        }
    }

?>

<?php include('partials/footer.php'); ?>