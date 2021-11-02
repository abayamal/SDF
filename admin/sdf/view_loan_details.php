<?php
    if(isset($_POST["submit"]))
    {
        header("location:index.php");
    }
?>

<?php include"header.php"; ?>
<?php include"sidebar.php"; ?>
<?php

include "class/c_loan.php";
$lno=new loan();
$lno->last_include_loanAcc();

$l=new loan();
$l->get_loan_account_loanNo($lno->loan_no);

// $amount=$l->amount;
// $month=$l->repayment_period;
// $interest=$l->interest;

$princ =$l->amount; //principal amount
$term = $l->repayment_period; //months
$intr =$l->interest/ 1200; //get percentage

$EMI= ceil($princ * $intr / (1 - (pow(1/(1 + $intr), $term)))); # This for total EMI

$fullpayment=$EMI*$term;
$intrest=$princ*$intr;
$all_interest=$fullpayment-$princ;


?>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">         <!--loan details-->
      <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Loan details</h3>
                    <div class="card-tools">
                    </div><!--/card-tools-->
                </div><!-- /card-header -->
                <!--card body -->
                <div class="card-body" style="text-align:left;">
                    <div class="myDiv"><!--background color div --> 
                    <table style="width:100%">
                        <h6 style="text-align:center"><b>--- Applicant details ---</b></h6>
                                <br>
                                    <tr>
                                        <td><b>Loan no:</b></td>
                                        <td><?php echo $lno->loan_no; ?></td>
                                        <td><b>Nic:</b></td>
                                        <td><?php echo $l->cus_id."V"; ?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td><b>Loan Category:</b></td>
                                        <td><?php echo $l->loanCategory->loan_category_name ?></td>
                                        <td><b>Loan Type:</b></td>
                                        <td><?php echo $l->loanType->loan_type_name; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Amount:</b></td>
                                        <td><?php echo "LKR. " . number_format($l->amount,2 , ".", ",");  ?></td>
                                        <td><b>Purpose:</b></td>
                                        <td><?php echo $l->purpose; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Repayment period:</b></td>
                                        <td><?php echo $l->repayment_period." Month"; ?></td>
                                        <td><b>Date:</b></td>
                                        <td><?php echo $l->date; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Interest Rate:</b></td>
                                        <td><?php echo $l->interest."%"; ?></td>
                                        <td><b>Account Number:</b></td>
                                        <td><?php echo "011-2-001-2-004603".$l->acc_id; ?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td><b>Full Name:</b></td>
                                        <td><?php echo $l->per->cus_full_name; ?></td>
                                        <td><b>Address:</b></td>
                                        <td><?php echo $l->per->cus_address; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Telephone:</b></td>
                                        <td><?php echo $l->per->cus_telephone; ?></td>
                                        <td><b>Email:</b></td>
                                        <td><?php echo $l->per->cus_email; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>DOB:</b></td>
                                        <td><?php echo $l->per->cus_dob; ?></td>
                                        <td><b>Age:</b></td>
                                        <td><?php echo $l->per->cus_age; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Gender:</b></td>
                                        <td><?php echo $l->per->cus_gender; ?></td>
                                        <td><b>Designation:</b></td>
                                        <td><?php echo $l->per->cus_designation; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Designation State:</b></td>
                                        <td><?php echo $l->per->cus_designation_state; ?></td>
                                        <td><b>Monthely Income:</b></td>
                                        <td><?php echo $l->per->cus_monthely_income.".00"; ?></td>
                                    </tr>
                                    
                    </table>

                    </div><!--/.background color div -->
                </div> 

                
                <!-- /.card-body -->
                <!--card-footer --> 
                <div class="card-footer">
                                                                
                </div><!--/card-footer -->
            </div><!--/card card-default -->
      </div><!--/container-fluid -->
    </section>

    <section class="content-header">   <!--installment-->
      <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Installment</h3>
                </div><!-- /card-header -->
                <!--card body -->
                <div class="card-body">        
              
            <table style="width:100%">
                <tr> 
                  <td><div class='myDiv3'><?php echo "<b>TOTAL PAYMENT :</b> &nbsp;&nbsp;&nbsp;&nbsp".number_format($fullpayment, 2, '.', ',');?></div> </td>
                  <td><div class='myDiv3'><?php echo "<b>INTEREST :</b> &nbsp;&nbsp;&nbsp;&nbsp ".number_format($all_interest, 2, '.', ','); ?></div></td>
                  <td><div class='myDiv3'><?php echo "<b>EMI : </b> &nbsp;&nbsp;&nbsp;&nbsp".number_format($EMI,2,'.',','); ?></div></td>
               </tr>
            </table>
            <br>
            <br>   
               

               <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col">Payment No</th>
                    <th scope="col">EMI</th>
                    <th scope="col">Due date</th>
                    <th scope="col">Balance</th>
                    </tr>
                </thead>
                    <tbody>
                    <?php
                        $x=1;
                        $date = new DateTime('now'); //now date
                        $balance=$fullpayment;
                        while($x <= $term) {
                            $date->modify('+1 month'); // add now date to one month
                            $datedue = $date->format('Y-m-d');
                            $balance=$fullpayment-($x*$EMI);
                    echo"
                        <tr>
                        <th scope='row'>$x</th>
                        <td>".number_format($EMI, 2, '.', ',')."</td>
                        <td>$datedue</td>
                        <td>".number_format($balance, 2, '.', ',')."</td>
                        </tr>"
                        ;
                        $x++;
                                            }
                ?>
                        
                    </tbody>
                </table>
                <form action="view_loan_details.php" method="POST">
                    <input class="btn btn-primary btn-sm" type="submit" name="submit" value="Finished">                        
                </form>  
                </div><!-- /.card-body -->
                <!--card-footer --> 
                <div class="card-footer">
                                                                
                </div><!--/card-footer -->
            </div><!--/card card-default -->
      </div><!--/container-fluid -->
    </section>
<?php include"footer.php"; ?>


    

        

