<?php include"header.php"; ?>
<?php include"sidebar.php"; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"><!--section-->
        <div class="container-fluid"><!--container-fluid -->
            <div class="card card-default"><!--card card-default -->
                <div class="card-header">
                    <h3 class="card-title">Daily loan payments</h3>
                </div><!-- /card-header -->
                    <div class="card-body"><!--card body -->  

                    <?php

                    $branch_id=$_SESSION["uu"]['branch_id'];

                    include_once "class/c_loan_payments.php";
                    $p=new payments();
                    if($p->is_exist_daily_payments($branch_id)){

                        $loanpay=$p->get_all_daily_payments($branch_id);
                    ?>

                        <div class="col-md-12">
                            <table id="example1" class="table table-responsive table-bordered table-striped">
                              <thead>
                                <tr>
                                  <th>Loan number</th>
                                  <th>Payment number</th>
                                  <th>Branch</th>
                                  <th>Account number</th>
                                  <th>Amount</th>
                                  <th>Panalty</th>
                                  <th>Date and time</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php

                                foreach ($loanpay as $item) {

                                  echo "  
                                      <tr>
                                        <td>$item->loan_no</td>
                                        <td>$item->payment_no</td>
                                        <td>".$item->branch->branch_name."</td>
                                        <td>$item->acc_id</td>
                                        <td>". "LKR. " . number_format($item->amount,2 , ".", ",") ."</td>
                                        <td>". "LKR. " . number_format($item->panalty,2 , ".", ",") ."</td>
                                        <td>$item->date</td>
                                    ";
                                }

                                ?>
                              </tbody>
                              <tfoot>
                                <tr>
                                  <th>Loan number</th>
                                  <th>Payment number</th>
                                  <th>Branch</th>
                                  <th>Account number</th>
                                  <th>Amount</th>
                                  <th>Panalty</th>
                                  <th>Date and time</th>
                                </tr>
                              </tfoot>
                            </table>
                        </div>

                    <?php
                    }else{
                        ?>
                        <h3 style="color:red; text-align:center"><b>Not loan payments available!</b></h3>
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


    

        


