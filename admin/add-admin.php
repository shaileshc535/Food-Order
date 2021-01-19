<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br><br>
        
        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        ?>
        <br><br>

        <form action="#" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name</td>
                    <td><input type="text" name="name" placeholder="Enter your full name"></td>

                </tr>
                <tr>
                    <td>Username</td>
                    <td><input type="text" name="username" placeholder="Enter your username"></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password" placeholder="Enter your password"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
    </div>
</div>


<?php include('partials/footer.php'); ?>

<?php
// Process the value from form & save it at database
// Check weather the submit button is clicked or not
if (isset($_POST['submit'])) {

    // get the data from the form 
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    // sql query to save the data in database
    $sql = "INSERT INTO `tbl_admin` (`name`, `username`, `password`) VALUES ('$name', '$username', '$password')";

    // exicuting quary & saving data into database
    $res = mysqli_query($conn, $sql);
    if ($res == TRUE) {
        // create session veriable to display message
        $_SESSION['add'] = '<div class="success">Admin Added Succesfully.</div>';
        // redirect page to manage admin
        header("location:" . $SITEURL . 'admin/manage_admin.php');
    } 
    else {

        // create session veriable to display message
        $_SESSION['add'] = '<div class="error">Admin not Added Succesfully.</div>';
        // redirect page to manage admin
        header("location" . $SITEURL . 'admin/add_admin.php');
    }
}


?>