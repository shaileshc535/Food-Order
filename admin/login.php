<?php include('../config/constants.php'); ?>
<html>
    <head>
        <title>Login - Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>
        <div class="login">
            <h1 class="text-center">Login</h1>
            <br><br>
            <?php
                if(isset($_SESSION['login'])){
                    echo $_SESSION['login'];
                    unset ($_SESSION['login']);
                }
                if(isset($_SESSION['no-login-message'])){
                    echo $_SESSION['no-login-message'];
                    unset ($_SESSION['no-login-message']);
                }
            ?>
            <br><br>

            <!-- Login form starts here -->
            <form action="" method="POST" class="text-center">
                Username: <br>
                <input type="text" name="username" placeholder="Enter username"> <br><br>
                Password: <br>
                <input type="password" name="password" placeholder="Enter Password"> <br><br>

                <input type="submit" name="submit" value="Login" class="btn-primary"> <br><br>
            </form>

            <!-- Login form ends here -->

            <p class="text-center">Created By - <a href="www.shailesh.com">Shailesh</a></p>
        </div>
    </body>
</html>

<?php
    // check wether the submit button is clicked or not
    if(isset($_POST['submit'])){
    //Process for login 
        // 1. get the data from login form
        $username=$_POST['username'];
        $password=md5($_POST['password']);

        // 2. sql to check wether username & password exists or not
        $sql="SELECT * FROM tbl_admin WHERE username='$username' and PASSWORD='$password'";

        // 3. Execute the query 
        $res=mysqli_query($conn, $sql);

        //4. Count rows to check wether the user exist or not
        $count=mysqli_num_rows($res);

        if($count==1){
            // user available & login success
            $_SESSION['login']="<div class='success text-center'>Login Successfull</div>";
            $_SESSION['user']=$username; // to check wether user is loged in or not & logout will unset it
            // Redirect the home page 
            header('location:'.$SITEURL.'/admin/');
        }
        else{
            // user not available & login fail
            $_SESSION['login']="<div class='error text-center'>Username or Password did not matched</div>";
             // Redirect the home page 
            header('location:'.$SITEURL.'/admin/add-admin.php');
        }
    }

?>