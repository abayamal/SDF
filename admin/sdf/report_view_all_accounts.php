<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>
<?php
 $branch_id=$_SESSION["uu"]['branch_id'];
include "class/c_account.php";
$a = new account();

?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">View all Accounts</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body"><!--card-body-->
            <?php

            $a = new account();
            if($a->is_exist_account_untill_now($branch_id)){
              $allacc=$a->get_all_account($branch_id);


            ?>


              <form action="#" method="post">
                <div class="row">
                  <div class="col-md-12">
                  <table id="example1" class="table table-responsive table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Account no</th>
                        <th>Account type</th>
                        <th>Balance</th>
                        <th>Interest</th>
                        <th>Opened date</th>
                        <th>NIC</th>
                        <th>full_name</th>
                        <th>Address</th>
                        <th>Telephone</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>DOB</th>
                       
                      </tr>
                      </thead>
                 <?php    
                  
                    foreach($allacc as $item){

                 echo"  
                          <tr>
                            <td>$item->acc_id</td>
                            <td>$item->acc_type</td>
                            <td>". "LKR. " . number_format($item->acc_balance,2 , ".", ",") ."</td>
                            <td>".$item->acctype->interest."%"."</td>
                            <td>$item->acc_created_date</td>
                            <td>".$item->cust->cus_id."V"."</td>
                            <td>".$item->cust->cus_full_name."</td>
                            <td>".$item->cust->cus_address."</td>
                            <td>".$item->cust->cus_telephone."</td>
                            <td>".$item->cust->cus_email."</td>
                            <td>".$item->cust->cus_gender."</td>
                            <td>".$item->cust->cus_dob."</td>
                            
                              
                        ";

                    }
                      
                  ?>    
                      <tfoot>
                      <tr>
                          <th>Account no</th>
                          <th>Account type</th>
                          <th>Balance</th>
                          <th>Interest</th>
                          <th>Opened date</th>
                          <th>NIC</th>
                          <th>full_name</th>
                          <th>Address</th>
                          <th>Telephone</th>
                          <th>Email</th>
                          <th>Gender</th>  
                          <th>DOB</th>   
                      </tr>
                      </tfoot>
                      
                    </table>

                  
                  
                
                
                </div>
              </form>
            <?php
            }else{
            ?>
               <h3 style="color:red; text-align:center"><b>Not available savings accounts!</b></h3>
               <div class="card-body" style="text-align:center;"><!--card-body-->
                     <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
               </div>
            <?php
            } 
            ?> 

            </div><!-- /.card-body -->
            
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!--<section class="content">
      <div class="container-fluid">
        <div class="row">-->

        
<?php include"footer.php"; ?>