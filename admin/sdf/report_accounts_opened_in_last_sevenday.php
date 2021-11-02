<?php include"header.php"; ?>
<?php include"sidebar.php"; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"><!--section-->
        <div class="container-fluid"><!--container-fluid -->
            <div class="card card-default"><!--card card-default -->
                <div class="card-header">
                    <h3 class="card-title">Accounts opened in last 7 days</h3>
                </div><!-- /card-header -->
                    <div class="card-body"><!--card body -->  

                    <?php

                        $branch_id=$_SESSION["uu"]['branch_id'];

                        include_once "class/c_account.php";
                        $a=new account();
                        
                        if($a->is_exist_accounts_opened_in_the_last_sevendays($branch_id)){
                            $acc=$a->get_all_accounts_opened_in_last_sevenday($branch_id);
                        ?>

                            <div class="col-md-12">
                                <table id="example1" class="table table-responsive table-bordered table-striped">
                                <thead>
                                    <tr>
                                    <th>Account Number</th>
                                    <th>Account type</th>
                                    <th>Amount</th>
                                    <th>Full name</th>
                                    <th>Address</th>
                                    <th>Gender</th>
                                    <th>Nic</th>
                                    <th>Opend time</th>
                                    

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    foreach ($acc as $item) {

                                    echo "  
                                        <tr>
                                            <td>$item->acc_id</td>
                                            <td>".$item->accType->acc_type_name."</td>
                                            <td>". "LKR. " . number_format($item->acc_balance,2 , ".", ",") ."</td>
                                            <td>".$item->cus->cus_full_name."</td>
                                            <td>".$item->cus->cus_address."</td>
                                            <td>".$item->cus->cus_gender."</td>
                                            <td>$item->cus_id</td>
                                            <td>$item->acc_created_date</td>
                                        ";
                                    }

                                    ?>
                                </tbody>
                                 <tfoot>
                                    <tr>
                                    <th>Account Number</th>
                                    <th>Account type</th>
                                    <th>Amount</th>
                                    <th>Full name</th>
                                    <th>Address</th>
                                    <th>Gender</th>
                                    <th>Nic</th>
                                    <th>Opend time</th> 
                                    </tr>
                                </tfoot> 
                                </table>
                            </div>






                        <?php
                        }else{
                            ?>
                            <h3 style="color:red; text-align:center"><b>Not opened saving accounts in last 7 days!</b></h3>
                            <div class="card-body" style="text-align:center;"><!--card-body-->
                                <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                            </div>
                            <?php
                        }
                        ?>

                    </div><!-- /.card-body -->
                <div class="card-footer"><!--card-footer --> 
                </div><!--/card-footer -->
            </div><!--/card card-default -->
        </div><!--/container-fluid -->
    </section><!--/section-->
<?php include"footer.php"; ?>
</div>


    

        

