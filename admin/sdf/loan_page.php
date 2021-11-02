<?php include"header.php"; ?>
<?php include"sidebar.php"; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Loan Management</h3>
                </div><!-- /card-header -->
                <!--card body -->
                <div class="card-body"> 

                    <div class="frame">

                    <a href="create_loan_form.php">
                    <i class="fas fa-house-user"></i>
                        <span>Create Loan</span>
                    </a>
                    <a href="view_loan_form.php">
                    <i class="far fa-sticky-note"></i>
                        <span>view loan</span>
                    </a>

                    <?php
                    if($_SESSION["uu"]['stf_designation']=="Admin" || $_SESSION["uu"]['stf_designation']=="Manager" || $_SESSION["uu"]['stf_designation']=="Assistant Manager"){
                    ?>
                    <a href="loan_approval.php">
                    <i class="fas fa-check-double"></i>
                        <span>Loan approval</span><!-- Dispaly only manager,admin,assistant manager-->
                    </a>
                    <?php
                    }
                    ?>
                    <a href="loan_payment_form.php">
                    <i class="fab fa-cc-amazon-pay"></i>
                        <span>Loan Payment</span>
                    </a>
                    </div>

                </div>
                <!-- /.card-body -->
                <!--card-footer --> 
                <div class="card-footer">
                                                                
                </div><!--/card-footer -->
            </div><!--/card card-default -->
      </div><!--/container-fluid -->
    </section>
<?php include"footer.php"; ?>


    

        

