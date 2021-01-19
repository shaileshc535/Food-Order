<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Order</h1>
        <br>
        <br>
        
        <?php
            if(isset($_SESSION['update'])){
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
        ?><br><br>
        <!-- Button to add Order -->
        <a href="<?php echo $SITEURL; ?>order.php" class="btn-primary">Add Order</a>
        <br>
        <br>
        <br>
        <table class="tbl-full">
            <tr>
                <th>S.No</th>
                <th>Food</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Customer Contact</th>
                <th>Customer Email</th>
                <th>Customer Address</th>
                <th>Action</th>
            </tr>
            <?php
                // Get all orders from database
                $sql="SELECT * FROM tbl_order ORDER BY id DESC";

                $res=mysqli_query($conn, $sql);

                $count=mysqli_num_rows($res);
                $sn = 1;

                if($count>0){
                    //order available
                    while($row=mysqli_fetch_assoc($res)){
                        // Get all the order details
                        $id=$row['id'];
                        $food=$row['food'];
                        $price=$row['price'];
                        $qty=$row['qty'];
                        $total=$row['total'];
                        $order_date=$row['order_date'];
                        $status=$row['status'];
                        $costomer_name=$row['costomer_name'];
                        $costomer_contact=$row['costomer_contact'];
                        $costomer_email=$row['costomer_email'];
                        $costomer_address=$row['costomer_address'];

                        ?>
                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $food; ?></td>
                            <td><?php echo $price; ?></td>
                            <td><?php echo $qty; ?></td>
                            <td><?php echo $total; ?></td>
                            <td><?php echo $order_date; ?></td>

                            <td>
                                <?php if($status=="Ordered")
                                {
                                    echo "<label>$status</label>";
                                }
                                elseif($status=="On Delivery")
                                {
                                    echo "<label style='color: orange';>$status</label>";
                                }
                                elseif($status=="On Delivered")
                                {
                                    echo "<label style='color: green';>$status</label>";
                                }
                                elseif($status=="On Cancelled")
                                {
                                    echo "<label style='color: red';>$status</label>";
                                }
                                ?>
                            </td>

                            <td><?php echo $costomer_name; ?></td>
                            <td><?php echo $costomer_contact; ?></td>
                            <td><?php echo $costomer_email; ?></td>
                            <td><?php echo $costomer_address; ?></td>
                            <td>
                                <a href="<?php echo $SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary">Update Order</a>
                            </td>
                        </tr>

                        <?php

                    }

                }else{
                    // order not available
                    echo "<tr><td colspan='12' class='error'>Orders Not Available</td></tr>";
                }
            
            ?>           
        </table>
    </div>
</div>
<?php include('partials/footer.php'); ?>