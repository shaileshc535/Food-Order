<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrraper">
        <h1>Update Order</h1>
        <br><br>
        <?php
            if(isset($_GET['id'])){
                //Get the order details
                $id=$_GET['id'];

                //get all other details based on thisid
                $sql="SELECT * FROM tbl_order WHERE id=$id";

                $res=mysqli_query($conn, $sql);

                $count=mysqli_num_rows($res);

                if($count>0){
                    $row=mysqli_fetch_assoc($res);

                    $food=$row['food'];
                    $price=$row['price'];
                    $qty=$row['qty'];
                    $total=$row['total'];
                    $status=$row['status'];
                    $costomer_name=$row['costomer_name'];
                    $costomer_contact=$row['costomer_contact'];
                    $costomer_email=$row['costomer_email'];
                    $costomer_address=$row['costomer_address'];

                }else{
                    echo "<div class=0'error'>Order Not Found.</div>";
                    header('location:'.$SITEURL.'admin/manage_order.php');
                }

            }else{
                // redirect to manage order page
                header('location:'.$SITEURL.'admin/manage_order.php');
            }

        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Food Name</td>
                    <td><b> <?php echo $food; ?> </b></td>
                </tr>

                <tr>
                    <td>Price</td>
                    <td><b> <?php echo $price; ?> </b></td>
                </tr>

                <tr>
                    <td>Quantity</td>
                    <td>
                        <input type="number" name="qty" value="<?php echo $qty; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Total</td>
                    <td>
                        <input type="number" name="total" value="<?php echo $total; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Status</td>
                    <td>
                        <select name="status">
                            <option <?php if($status=="Ordered"){echo "selected";} ?> value="Ordered">Ordered</option>
                            <option <?php if($status=="On Delivery"){echo "selected";} ?> value="On Delivery">On Delivery</option>
                            <option <?php if($status=="Delivered"){echo "selected";} ?> value="Delivered">Delivered</option>
                            <option <?php if($status=="Cancelled"){echo "selected";} ?> value="Cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Customer Name</td>
                    <td>
                        <input type="text" name="costomer_name" value="<?php echo $costomer_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Contact</td>
                    <td>
                        <input type="text" name="costomer_contact" value="<?php echo $costomer_contact; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Email</td>
                    <td>
                        <input type="text" name="costomer_email" value="<?php echo $costomer_email; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Address</td>
                    <td>
                        <input type="text" name="costomer_address" value="<?php echo $costomer_address; ?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
            <?php
                //update button is clicked or not
                if(isset($_POST['submit'])){
                    // get all the values from form 

                    $id=$_POST['id'];
                    $price=$_POST['price'];
                    $qty=$_POST['qty']; 

                    $total=$price * $qty;

                    $status=$_POST['status'];

                    $costomer_name=$_POST['costomer_name'];
                    $costomer_contact=$_POST['costomer_contact'];
                    $costomer_email=$_POST['costomer_email'];
                    $costomer_address=$_POST['costomer_address'];

                    $sql2="UPDATE tbl_order SET
                        qty=$qty,
                        total=$total,
                        status='$status',
                        costomer_name='$costomer_name',
                        costomer_contact='costomer_contact',
                        costomer_email='costomer_email',
                        costomer_address='costomer_address'
                        WHERE id=$id
                    ";
                    $res2=mysqli_query($conn, $sql2);

                    if($res2==true){
                        //updated
                        $_SESSION['update'] = "<div class='success'>Order Updated Successfully.</div>";
                        header('location:'.$SITEURL.'admin/manage_order.php');
                    }else{
                        // failed to update
                        $_SESSION['update'] = "<div class='error'>Failed to Update Order.</div>";
                        header('location:'.$SITEURL.'admin/manage_order.php');
                    }
                }
            ?>
    </div>

</div>


<?php include('partials/footer.php'); ?>