
<?php include"header.php"; ?>
<?php include"sidebar.php"; ?>
      

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
           
          <div class="card-group">
            <div class="card">
              <img src="image/deposits.jpg" width="1" height="320" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title"><b>Daily transaction summery</b></h5><br>
               <?php
               $branch_id=$_SESSION["uu"]['branch_id'];
               include_once "class/c_transaction.php";
               // to get summery of all deposits 
               $t=new transaction();
               if($t->is_exist_daily_deposits($branch_id)){
                  $res=$t->get_all_daily_deposits($branch_id);

                  $deposit_sum=0;
                  foreach ($res as $item) {
                    $amount=$item->debit;     //to get all deposit summery
                    $deposit_sum+=$amount;
                  }
                ?>
                <table cellpadding="12">
                  <tr>
                    <td><b>Daily deposits summery</b></td>
                    <?php
                      echo " <td><b>". "LKR. " . number_format($deposit_sum,2 , ".", ",") ."</b></td>";
                    ?>
                  </tr>
                </table>
                  
                <?php
               }else{ // end of $t->is_exist_daily_deposits($branch_id)
                ?>

                <table cellpadding="12">
                  <tr>
                    <td><b>Daily deposits summery</b></td>
                    <td style="color:red"><b>Not available</b></td>
                  </tr>
                </table>

               <?php
               }

               //to get summery of all withdrawals 
               $t2=new transaction();
               if($t2->is_exist_daily_withdrawals($branch_id)){
                 $res2=$t2->get_all_daily_withdrawals($branch_id);

                 $withdraw_sum=0;
                 foreach ($res2 as $item) {
                   $amount_withdraw=$item->credit;     //to get all deposit summery
                   $withdraw_sum+=$amount_withdraw;
                 }
                 ?>

                <table cellpadding="12">
                  <tr>
                    <td><b>Daily withdraw summery</b></td>
                    <?php
                      echo " <td><b>". "LKR. " . number_format($withdraw_sum,2 , ".", ",") ."</b></td>";
                    ?>
                  </tr>
                </table>

                 <?php
               }else{
                ?>

                <table cellpadding="12">
                  <tr>
                    <td><b>Daily withdraw summery</b></td>
                    <td style="color:red"><b>Not available</b></td>
                  
                  </tr>
                </table>


                <?php
               }
               ?>
              


              </div>
            </div>
            <div class="card">
              <img src="image/loan6.png" width="1" height="320" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title"><b>Loan payments</b></h5><br>
                <?php
                $branch_id=$_SESSION["uu"]['branch_id'];
                include_once "class/c_loan_payments.php";
                $p=new payments();

                //to get all daily loan payment summery summery
                if($p->is_exist_daily_payments($branch_id)){
                  $res=$p->get_all_daily_payments($branch_id);

                  $payment_sum=0;
                  foreach ($res as $item) {
                    $amount=$item->amount;     //to get all daily loan payment summery summery
                    $payment_sum+=$amount;
                  }
                  ?>
                <table cellpadding="12">
                  <tr>
                    <td><b>Daily loan payment summery</b></td>
                    <?php
                      echo " <td><b>". "LKR. " . number_format($payment_sum,2 , ".", ",") ."</b></td>";
                    ?>
                  </tr>
                </table>

                  <?php
                }else{
                  ?>
                <table cellpadding="12">
                  <tr>
                    <td><b>Daily loan payment summery</b></td>
                    <td style="color:red"><b>Not available</b></td>
                  
                  </tr>
                </table>

                  <?php
                }
                //to get all daily loan panalty summery
                $p2=new payments();
                if($p2->is_exist_daily_payments($branch_id)){
                  $res=$p2->get_all_daily_payments($branch_id);

                  $panalty_sum=0;
                  foreach ($res as $item) {
                    $panalty=$item->panalty;     //to get all daily loan panalty summery 
                    $panalty_sum+=$panalty;
                  }
                  ?>
                <table cellpadding="12">
                  <tr>
                    <td><b>Daily loan panalty summery</b></td>
                    <?php
                      echo " <td><b>". "LKR. " . number_format($panalty_sum,2 , ".", ",") ."</b></td>";
                    ?>
                  </tr>
                </table>

                  <?php
                }else{
                  ?>
                <table cellpadding="12">
                  <tr>
                    <td><b>Daily loan panalty summery</b></td>
                    <td style="color:red"><b>Not available</b></td>
                  
                  </tr>
                </table>

                  <?php
                }



                ?>
              </div>
            </div>
            <div class="card">
              <img src="image/stf_user.jpg" width="1" height="320" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title"><b>Login details</b></h5><br>
                <?php
                //  to get last login time from session_tbl
                include_once "class/c_staff.php";
                $s=new staff();

               if($s->last_login_details($_SESSION["uu"]['stf_id'])){
                $last_login=$s->last_login;


                ?>

                <table cellpadding="12">
                  <tr>
                    <td><b>User name:</b></td>
                    <td><b><?php echo $_SESSION["uu"]['stf_first_name']." ".$_SESSION["uu"]['stf_last_name']  ?></td>
                  </tr>
                  <tr>
                    <td><b>Last login:</b></td>
                    <td><b><?php echo $last_login  ?></b></td>
                  </tr>

                </table>
                <?php
               }else{
                 ?>
                <table cellpadding="12">
                  <tr>
                    <td><b>User name:</b></td>
                    <td><b><?php echo $_SESSION["uu"]['stf_first_name']." ".$_SESSION["uu"]['stf_last_name']  ?></b></td>
                  </tr>
                  <tr>
                    <td><b>Last login:</b></td>
                    <td style="color:red"><b>Not available</b></td>
                  </tr>
                </table>

              <?php
               }
                //  to get last logout time from session_tbl
                $s2=new staff();
                if($s->last_logout_details($_SESSION["uu"]['stf_id'])){
                  $last_logout=$s->last_logout;
                  ?>
                <table cellpadding="12">
                  <tr>
                    <td><b>Last logout:</b></td>
                    <td><b><?php echo $last_logout  ?></b></td>
                  </tr>
                </table>

                  <?php
                }else{
                  ?>
                <table cellpadding="12">
                  <tr>
                    <td><b>Last logout:</b></td>
                    <td style="color:red"><b>Not available</b></td>
                  </tr>
                </table>


                <?php
                }
               ?>
              </div>
            </div>
          </div>



          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!--<section class="content">
      <div class="container-fluid">
        <div class="row">-->

        
<?php include"footer.php"; ?>