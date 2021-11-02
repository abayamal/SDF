<?php include"header.php"; ?>
<?php include"sidebar.php"; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"><!--section-->
        <div class="container-fluid"><!--container-fluid -->
            <div class="card card-default"><!--card card-default -->
                <div class="card-header">
                    <h3 class="card-title">Daily deposits</h3>
                </div><!-- /card-header -->
                    <div class="card-body"><!--card body -->  

                    <?php

                    $branch_id=$_SESSION["uu"]['branch_id'];

                    include_once "class/c_transaction.php";
                    $t=new transaction();
                    if($t->is_exist_daily_transactions($branch_id)){

                        $trans=$t->get_all_daily_transactions($branch_id);
                    ?>

                        <div class="col-md-12">
                            <table id="example1" class="table table-responsive table-bordered table-striped">
                              <thead>
                                <tr>
                                  <th>Transaction ID</th>
                                  <th>Account Number</th>
                                  <th>Branch</th>
                                  <th>Credit</th>
                                  <th>Debit</th>
                                  <th>Balance</th>
                                  <th>Discription</th>
                                  <th>Date and time</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php

                                foreach ($trans as $item) {

                                  echo "  
                                      <tr>
                                        <td>$item->trans_id</td>
                                        <td>$item->acc_id</td>
                                        <td>".$item->branch->branch_name."</td>
                                        <td>". "LKR. " . number_format($item->credit,2 , ".", ",") ."</td>
                                        <td>". "LKR. " . number_format($item->debit,2 , ".", ",") ."</td>
                                        <td>". "LKR. " . number_format($item->balance,2 , ".", ",") ."</td>
                                        <td>$item->note</td>
                                        <td>$item->trans_date</td>
                                    ";
                                }

                                ?>
                              </tbody>
                              <tfoot>
                                <tr>
                                  <th>Transaction ID</th>
                                  <th>Account Number</th>
                                  <th>Branch</th>
                                  <th>Credit</th>
                                  <th>Debit</th>
                                  <th>Balance</th>
                                  <th>Discription</th>
                                  <th>Date and time</th>
                                </tr>
                              </tfoot>
                            </table>
                        </div>

                    <?php
                    }else{
                        ?>
                        <h3 style="color:red; text-align:center"><b>Not available daily transactions!</b></h3>
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


    

        


