<?php include"header2.php"; ?>
<?php include"sidebar2.php"; ?>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"><!--section-->
        <div class="container-fluid"><!--container-fluid -->
            <div class="row p-3 justify-content-center"><!--row p-3 justify-content-center-->
                <div class="col-md-8"><!--col-md-8-->
                    <div class="card text-center"><!--card text-center -->
                        <div class="card-header">
                            <h3 class="card-title">Account Summery</h3>
                        </div><!-- /card-header -->
                        <div class="myDiv2"><!--background color div -->
                            <div class="card-body" style="text-align:left;"><!--card body --> 
                                
                                <?php
                                    if(!isset($_GET["type"])){


                                    include_once "class/c_account.php";
                                    $a = new account();
                                    $allAcc=$a->get_all_account_from_nic($_SESSION["uu"]['cus_id']);
                                ?>
                                <table class="table table-sm">
                                <thead>
                                    <tr>
                                    <th scope="col">Account Number</th>
                                    <th scope="col">Account Nickname</th>
                                    <th scope="col">Account Balance</th>
                                    <th scope="col">Operation</th>
                                    </tr>
                                </thead>
                                <?php
                                    foreach($allAcc as $item)
                                    {
                                        // Get account balance accbal table
                                        $a2=new account();
                                        $a2->get_branch_account_balance($item->acc_id);
                                        $balance=$a2->acc_balance;

                                        echo"  
                                            <tbody>
                                                <tr>
                                                <th scope='row'>$item->acc_id</th>
                                                <td>".$item->cust->cus_full_name."</td>
                                                <td>". "<b>LKR. " . number_format($balance,2 , ".", ",<b>") ."</td>
                                                <td><div class='view btn btn-success btn-sm' data-type='view_summery' data-value='$item->acc_id'>Details</div></td>
                                                </tr>
                                                
                                            </tbody>
                                            ";
                                    }
                                    ?>
                                </table>
                                <?php
                                    }else{ // after click details button
                                            include_once "class/c_account.php";
                                            $a3=new account();
                                            $a3->get_account($_GET["AccNo"]);
                                            include_once "class/c_customer.php";
                                            $c=new customer();
                                            $c->get_customer($a3->cus_id);

                                        ?>

                                        <div class="card-body"><!--card body --> 
                                        
                                            <table class="responsive w-100">
                                                <tr>
                                                    <td><b>Account ID:</b></td>
                                                    <td><?php echo $a3->acc_id; ?></td>
                                                    <td><b>Account Type:</b></td>
                                                    <td><?php echo $a3->acc_type; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Account Status:</b></td>
                                                    <td><b><?php echo "<span style='color:#2ab71e'>$a3->acc_status</span>" ?><b></td>
                                                    <td><b>Opened Date:</b></td>
                                                    <td><?php echo $a3->acc_created_date; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Account Balance:</b></td>
                                                    <td><?php echo "LKR. " . number_format($a3->acc_balance,2 , ".", ","); ?></td>
                                                    <td><b>Customer NIC:</b></td>
                                                    <td><?php echo $c->cus_id; ?>V</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Customer Name:</b></td>
                                                    <td><?php echo $c->cus_full_name  ?></td>
                                                    <td><b>Customer Address:</b></td>
                                                    <td><?php echo $c->cus_address; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Customer Telephone:</b></td>
                                                    <td><?php echo $c->cus_telephone; ?></td>
                                                    <td><b>Customer Email:</b></td>
                                                    <td><?php echo $c->cus_email; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Gender:</b></td>
                                                    <td><?php echo $c->cus_gender; ?></td>
                                                    <td><b>Date of birth:</b></td>
                                                    <td><?php echo $c->cus_dob; ?></td>
                                                </tr>
                                            </table>
                                            <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin-top: 25px; " onclick="history.go(-1);" ><!--back button-->
                                            
                                        </div><!--/card body -->  
                                       


                                    <?php
                                    }

                                ?>
                            </div><!-- /.card-body -->
                        </div><!--/background color div -->

                            <div class="card-footer"><!--card-footer --> 
                            </div><!--/card-footer -->
                            
                    </div><!--/card text-center -->
                </div><!--/col-md-8-->                  
            </div><!--/row p-3 justify-content-center-->
        </div><!--/container-fluid -->
    </section><!--/section-->

    <script>
         $(document).ready(function(){
            $(".view").click(function(){
                // $(this).data("type")

                //If account number is valid
                let url = window.location.href.split('?')[0] + "?type=" + $(this).data("type") + "&AccNo="+ $(this).attr('data-value');
                window.location.href= url;
                
            });
        });
    </script>


<?php include"footer2.php"; ?>


    

        

