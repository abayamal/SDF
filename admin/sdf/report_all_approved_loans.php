<?php include"header.php"; ?>
<?php include"sidebar.php"; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"><!--section-->
        <div class="container-fluid"><!--container-fluid -->
            <div class="card card-default"><!--card card-default -->
                <div class="card-header">
                    <h3 class="card-title">All approved loans</h3>
                </div><!-- /card-header -->
                    <div class="card-body"><!--card body -->  
                    <?php

                    $branch_id=$_SESSION["uu"]['branch_id'];

                    include_once "class/c_loan.php";
                    $l2=new loan();
                    if($l2->is_exist_approved_loan_untill_now($branch_id)){

                        include_once "class/c_loan.php";
                        $l=new loan();
                        $loan=$l->get_all_approved_loan_untill_now($branch_id);
                    ?>

                        <div class="col-md-12">
                            <table id="example1" class="table table-responsive table-bordered table-striped">
                            <thead>
                                <tr>
                                <th>Loan number</th>
                                <th>Loan type</th>
                                <th>Interest</th>
                                <th>Account number</th>
                                <th>Nic</th>
                                <th>Name</th>
                                <th>Amount</th>
                              
                                

                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($loan as $item) {

                                echo "  
                                    <tr>
                                        <td>$item->loan_no</td>
                                        <td>".$item->loanType->loan_type_name."</td>
                                        <td>$item->interest %</td>
                                        <td>$item->acc_id</td>
                                        <td>$item->cus_id v</td>
                                        <td>".$item->cus->cus_full_name."</td>
                                        <td>". "LKR. " . number_format($item->amount,2 , ".", ",") ."</td>
                                      
                                    ";
                                }

                                ?>
                            </tbody>
                             <tfoot>
                                <tr>
                                    <th>Loan number</th>
                                    <th>Loan type</th>
                                    <th>Interest</th>
                                    <th>Account number</th>
                                    <th>Nic</th>
                                    <th>Name</th>
                                    <th>Amount</th> 
                                </tr>
                            </tfoot> 
                            </table>
                        </div>


                    <?php
                    }else{
                        ?>
                        <h3 style="color:red; text-align:center"><b>Not approved loan today!</b></h3>
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
</div>
<?php include"footer.php"; ?>


    

        

