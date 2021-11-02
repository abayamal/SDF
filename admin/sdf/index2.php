
<?php include"header2.php"; ?>
<?php include"sidebar2.php"; ?>

      

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
          
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">

          <div class="card-group">
            <div class="card" style="width: 18rem;">
              <img src="image/account summery.jpg" width="1" height="230" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title"><b>Account Summery</b></h5>
                <br>
                
                <?php
                     
                  include_once "class/c_account.php";
                  $a = new account();
                  $allAcc=$a->get_all_account_from_nic($_SESSION["uu"]['cus_id']);
                ?>
                  <table cellpadding="12">
                  
                      <tr>
                      <th><u>Account Number</u></th>
                      <th><u>Account Balance<u></th>
                      </tr>
                  
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
                                  <th>$item->acc_id</th>
                                  
                                  <td>". "<b>LKR. " . number_format($balance,2 , ".", ",<b>") ."</td>
                                  
                                  </tr>
                                  
                              </tbody>
                              ";
                      }
                      ?>
                  </table>
                
              </div>

              <div class="card-body">
                <a href="account_summary_cus.php" class="card-link">More Details</a>
              </div>
            </div>  

            <div class="card" style="width: 18rem;"><!--Display loan details in card-->
              <img src="image/loan_details.jpg" width="1" height="230" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title"><b>Loan Details</b></h5><br>
                <?php
                include_once "class/c_loan.php";
                $l=new loan();
                if($l->is_exist_atleast_one_loan_account($_SESSION["uu"]['cus_id'])){
                  $allLoan=$l->get_all_approved_loan_account($_SESSION["uu"]['cus_id'],$_SESSION["uu"]['branch_id']);

                  ?>
                  <table cellpadding="12">
                  
                      <tr>
                      <th><u>Loan Number</u></th>
                      <th><u>Amount<u></th>
                      </tr>
                  
                  <?php
                      foreach($allLoan as $item)
                      {

                          echo"  
                              <tbody>
                                  <tr>
                                  <th>$item->loan_no</th>
                                  <td>". "<b>LKR. " . number_format($item->amount,2 , ".", ",<b>") ."</td>
                                  </tr>
                              </tbody>
                              ";
                      }
                      ?>
                  </table>
                <?php
                }else{// not available loan
                  echo "<br><span style='color:red;text-align:center;'><b>No Loan Available !</b></span>";
                }


                ?>

              </div>

              <div class="card-body">
                <a href="loan_payment_cus.php" class="card-link">Loan Payment</a> 
                
              </div>
            </div>  

            <div class="card" style="width: 18rem;">
              <img src="image/cus_user4.jpg" width="1" height="230" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title"><b>Login details<b></h5><br>
               
                <?php
                //  to get last login time from session_tbl
                include_once "class/c_customer.php";
                $c=new customer();
              
               if($c->last_login_details($_SESSION["uu"]['cus_id'])){ // if last login details
                $last_login=$c->last_login;

                ?>

                <table cellpadding="12">
                  <tr>
                    <td><b>User name:<b></td>
                    <td><b><?php echo $_SESSION["uu"]['cus_first_name']." ".$_SESSION["uu"]['cus_last_name']  ?><b></td>
                  </tr>
                  <tr>
                    <td><b>Last login:<b></td>
                    <td><b><?php echo $last_login  ?><b></td>
                  </tr>
                </table>
                <?php
               }else{ //if last login details not avialable
                 ?>
                <table cellpadding="12">
                  <tr>
                    <td><b>User name:<b></td>
                    <td><b><?php echo $_SESSION["uu"]['cus_first_name']." ".$_SESSION["uu"]['cus_last_name']  ?><b></td>
                  </tr>
                  <tr>
                    <td><b>Last login:<b></td>
                    <td style="color:red"><b>Not available<b></td>
                  </tr>
                </table>

              <?php
               }

                 //  to get last logout time from session_tbl
                 $c2=new customer();
                if($c2->last_logout_details($_SESSION["uu"]['cus_id'])){// if last logout details available
                 $last_logout=$c2->last_logout;
                 ?>

                <table cellpadding="12">
                  <tr>
                    <td><b>Last logout:<b></td>
                    <td><b><?php echo $last_logout  ?><b></td>
                  </tr>
                </table>


                <?php
                }else{ //if last logout details not avilable
                  ?>
                <table cellpadding="12">
                  <tr>
                    <td>Last logout:</td>
                    <td style="color:red">Not available</td>
                  </tr>
                </table>
              <?php
                }
               ?>

              </div>

              <div class="card-body">
                <!-- <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a> -->
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

        
<?php include"footer2.php"; ?>