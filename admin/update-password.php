<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wraper">
        <h1>Change Password</h1>
        <br><br>

        <?php
        if(isset($_GET['id'])) {
            $id=$_GET['id'];
        }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Current Password</td>
                    <td>
                        <input type="password" name="current_password" placeholder="current password">
                    </td>
                </tr>
                <tr>
                    <td>New Password</td>
                    <td>
                        <input type="password" name="new_password" placeholder="new password">
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="confirm password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
    //check wethere
    if(isset($_POST['submit'])) {
        // 1. get the data from 
        $id=$_POST['id'];
        $current_password=md5($_POST['current_password']);
        $new_password=md5($_POST['new_password']);
        $confirm_password=md5($_POST['confirm_password']);

        // 2. check wether the user with current id & pass exists or not
        $sql="SELECT * FROM tbl_admin WHERE id='$id' AND PASSWORD='$current_password'";

        // 3. check wether the new password & new password match or not
        $res=mysqli_query($conn, $sql);

        if($res==true) {
            $count=mysqli_num_rows($res);
            if($count==1) {
                //user exist & password can be changed
                // check whether the new password & confirm password match or not
                if($new_password==$confirm_password) {
                    //update the password
                    $sql2="UPDATE tbl_admin SET
                    password='$new_password'
                    WHERE id=$id";

                    $res2=mysqli_query($conn, $sql);

                    if($res==true) {
                        $_SESSION['change-password']="<div class='success'>Password successfully changed.</div>";
                        //redirect the user
                        header('location:'.$SITEURL.'admin/manage_admin.php');
                    } else {
                        $_SESSION['change-password']="<div class='error'>Password did Not changed.</div>";
                        //redirect the user
                        header('location:'.$SITEURL.'admin/manage_admin.php');
                    }
                } else {
                    $_SESSION['password-not-match']="<div class='error'>Password did Not Match.</div>";
                    //redirect the user
                    header('location:'.$SITEURL.'admin/manage_admin.php');
                }
            } else {
                //user not exist
                $_SESSION['user-not-found']="<div class='error'>User Not Found.</div>";
                header('location:'.$SITEURL.'admin/manage_admin.php');
            }
        }

        // 4. change password ifall above is true


    }
?>
<?php include('partials/footer.php'); ?>