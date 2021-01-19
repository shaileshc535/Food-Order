<?php include('partials/menu.php'); ?>

<!-- main content Section start -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Admin</h1>
        <br>

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        if (isset($_SESSION['user-not-found'])) {
            echo $_SESSION['user-not-found'];
            unset($_SESSION['user-not-found']);
        }
        if (isset($_SESSION['password-not-match'])) {
            echo $_SESSION['password-not-match'];
            unset($_SESSION['password-not-match']);
        }
        if (isset($_SESSION['change-password'])) {
            echo $_SESSION['change-password'];
            unset($_SESSION['change-password']);
        }
        ?>
        <br><br>

        <!-- Button to add admin -->
        <a href="add-admin.php" class="btn-primary">Add Admin</a>
        <br>
        <br>
        <br>
        <table class="tbl-full">
            <tr>
                <th>S.No</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Action</th>
            </tr>

            <?php
            //query to get all admin 
            $sql = "SELECT * FROM tbl_admin";
            //Execute the query
            $res = mysqli_query($conn, $sql);

            //check whether the query is executed or not
            if ($res == TRUE) {
                // count rows to check whether we have data in data base or not
                $count = mysqli_num_rows($res); //function to get all the rows in data base

                $sn = 1; //create a variable & asign the value
                //check the no of rows
                if ($count > 0) {
                    //we have data in database
                    while ($rows = mysqli_fetch_assoc($res)) {
                        //using while loop to get all the data in database
                        $id = $rows['id'];
                        $name = $rows['name'];
                        $username = $rows['username'];

                        //display the values in our table
            ?>
                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $name; ?></td>
                            <td><?php echo $username; ?></td>
                            <td>
                                <a href="<?php echo $SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                <a href="<?php echo $SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                <a href="<?php echo $SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                            </td>
                        </tr>
            <?php

                    }
                } else {
                    //we do not have data in database

                }
            }
            ?>

        </table>

    </div>
</div>
<!-- main content Section end -->

<?php include('partials/footer.php'); ?>

</body>

</html>