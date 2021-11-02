<?php include"header.php"; ?>
<?php include"sidebar.php"; ?>

<?php
include_once "class/c_account.php";
$acc=new account();
include "class/c_loan.php";
$l =new loan();
include_once "class/c_transaction.php";



if($l->is_exist_notapproved_loans($_SESSION["uu"]['branch_id']))
    $res=$l->get_all_notapproved_loans($_SESSION["uu"]['branch_id']); //Get all not approved loans


//installment
if(isset($_GET['loanNo']) && isset($_GET['type'])) //check whether click view button
{
    $l=new loan();
    $l->get_loan_account_loanNo($_GET["loanNo"]);
    
    $princ =$l->amount; //principal amount
    $term = $l->repayment_period; //months
    $intr =$l->interest/ 1200; //get percentage
    
    $EMI= ceil($princ * $intr / (1 - (pow(1/(1 + $intr), $term)))); # This for total EMI
    
    $fullpayment=$EMI*$term;
    $intrest=$princ*$intr;
    $all_interest=$fullpayment-$princ;
}
elseif(isset($_GET["type2"])) //check whether click Approved button
{
    include_once "class/c_loan_payments.php";
    $p=new payments();

    $l=new loan();
    $l->get_loan_account_loanNo($_GET["loanNo"]);
    
    $princ =$l->amount; //principal amount
    $term = $l->repayment_period; //months
    $intr =$l->interest/ 1200; //get percentage
    
    $EMI= ceil($princ * $intr / (1 - (pow(1/(1 + $intr), $term)))); # This for total EMI
    
    $fullpayment=$EMI*$term;
    $intrest=$princ*$intr;
    $all_interest=$fullpayment-$princ;

    $x=1;
    $date = new DateTime('now'); //now date
    $balance=$fullpayment;

    while($x <= $term) {
        $date->modify('+1 month'); // add now date to one month
        $datedue = $date->format('Y-m-d');
        $balance=$fullpayment-($x*$EMI);

        $p->loan_no=$_GET["loanNo"];
        $p->payment_no=$x;
        $p->acc_id=$l->acc_id;
        $p->amount=$EMI;
        $p->balance=$balance;
        $p->date=$datedue;

        $p->save_payment_shedule(); //save duedates and payment in table
        
    
        $x++;
                        }

       //for change not approved status in loan_tbl & update full_amount & full interest               
       $l2=new loan();   
       $l2->loan_no=$_GET["loanNo"];
       $l2->full_amount=$fullpayment;
       $l2->int_amount=$all_interest;
       $l2->branch_id=$_SESSION["uu"]['branch_id'];

       $l2->loan_approved();

       $l3=new loan();
       $l3->get_loan_account_loanNo($_GET["loanNo"]);

       // debit the amount customer account
       $t=new transaction();
       $t->acc_id=$l3->acc_id;
       $t->deposit_branch=$_SESSION["uu"]['branch_id'];
       $t->debit=$l3->amount;
       $t->note="loan_approved";
       $t->deposit();



?>
       
                                  



<?php


    
}elseif(isset($_GET["type3"])){

    include_once "class/c_loan.php";
    $l3=new loan();   
    $l3->loan_no=$_GET["loanNo"];
    $l3->branch_id=$_SESSION["uu"]['branch_id'];

    $l3->loan_reject();
 
}
?>




<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"><!--section 1 -->
      <div class="container-fluid"><!--container-fluid-->
        <div class="row p-3 justify-content-center"><!--row p-3 justify-content-center-->
            <div class="col-md-12"><!--col-md-12-->
                <?php
                    if(!isset($_GET["type"]) && !isset($_GET["type2"]) && $l->is_exist_notapproved_loans($_SESSION["uu"]['branch_id'])) //not click view & approved button and check whether not approved loan exist
                    {
                ?>
                    <div class="card text-center"><!--card text-center-->
                        <div class="card-header">Not-Approved Loans</div>
                            <div class="card-body" style="text-align:left;"><!--card-body-->
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                    <th scope="col">Loan no</th>
                                    <th scope="col">Person NIC</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">operation</th>
                                    </tr>
                                </thead>
                                <?php
                                
                                foreach($res as $item)
                                {
                                    echo"
                                        <tbody>
                                            <tr>
                                                <td>$item->loan_no</td>
                                                <td>$item->cus_id V</td>
                                                <td>$item->amount</td>
                                                <td>$item->date</td>
                                                <td><div class='view btn btn-primary' data-type='viewLoan' data-value='$item->loan_no'>View</div></td>
                                            </tr>
                                        </tbody>
                                    
                                    ";
                                }

                                ?>
                            </table> 
                            <?php
                    }
                    elseif(false==$l->is_exist_notapproved_loans($_SESSION["uu"]['branch_id']) && !isset($_GET["loanNo"]))  // if does not exist loan for approval display alert. "!isset($_GET["loanNo"]" use to when approve button click not showing this alert.
                    {
                        ?>
                        <div class="alert alert-danger" role="alert">NOT EXIST LOANS FOR APPROVAL...</div>
                        <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"> <!--back button-->
                <?php
                    }
                ?>

                <?php
            if(isset($_GET["type2"])){//after click approve button this alert show
        ?>

        <div class="alert alert-success form-group col-md-12" role="alert">Loan approved successfully! </div><!--after click approved button this alert show-->
                                    
        <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-2);"> <!--back button-->

        <?php
    }elseif(isset($_GET["type3"])){
    ?>
     <div class="alert alert-success form-group col-md-12" role="alert">Reject successfull! </div><!--after click approved button this alert show-->
                                    
     <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-2);"> <!--back button-->

    <?php
    }
    ?>
                
                

                            </div><!--card-body-->
                    </div><!--/card text-center-->
                

                <?php    
                    if(isset($_GET["type"])) //if click view button show account details
                    {
                        $l->get_loan_account_loanNo($_GET["loanNo"]);
                ?>
                    <div class="card text-center"><!--card text-center-->
                        <div class="card-header">Loan Details</div>
                        <div class="card-body" style="text-align:left;"><!--card-body-->
                        <div class="myDiv"><!--background color div --> 
                        <table style="width:100%">
                            <h6 style="text-align:center"><b>--- Applicant details ---</b></h6>
                                    <br>
                                        <tr>
                                            <td><b>Loan no:</b></td>
                                            <td><?php echo $l->loan_no; ?></td>
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
                                            <td><?php echo $l->acc_id; ?></td>
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
                                            <td><?php echo "LKR. " . number_format($l->per->cus_monthely_income,2 , ".", ","); ?></td>
                                        </tr>
                                        
                        </table> 
                                        <br>
                                        <h6 style="text-align:left"><b><u> Spouse details </u></b></h6>
                                        <br>
                                        
                        <table style="width:100%">
                                        <tr>
                                            <td><b>Full Name:</b></td>
                                            <td><?php echo $l->spouse->name; ?></td>
                                            <td><b>Nic:</b></td>
                                            <td><?php echo $l->spouse->spouse_id."V"; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Occupation:</b></td>
                                            <td><?php echo $l->spouse->occupation; ?></td>
                                            <td><b>Address:</b></td>
                                            <td><?php echo $l->spouse->address; ?></td>
                                        </tr>
                        </table>
                                    <br>
                                    <h6 style="text-align:left"><b><u> Asset details </u></b></h6>
                                        <br>
                                        
                        <table style="width:100%">
                                        <tr>
                                            <td><b>Immovable properties:</b></td>
                                            <td><?php echo $l->applicantAsset->immovable_properties;?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Movable properties:</b></td>
                                            <td><?php echo $l->applicantAsset->movable_properties;?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Any other assets:</b></td>
                                            <td><?php echo $l->applicantAsset->any_other_assets;?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Guarantees on behalf of 3rd parties:</b></td>
                                            <td><?php echo $l->applicantAsset->guarantees_on_behalf;?></td>
                                        </tr>
                        </table> 
                        </div><!--background color div --> 
                                    <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                        <div class="myDiv2"><!--background color div --> 
                                    <h6 style="text-align:center"><b>--- Guarantor Details ---</b></h6>
                                        <br>
                                        <table style="width:100%">
                                        <tr>
                                            <td><b>Full Name:</b></td>
                                            <td><?php echo $l->guarantor->grtr_full_name; ?></td>
                                            <td><b>Occupation:</b></td>
                                            <td><?php echo $l->guarantor->grtr_designation; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Occupation State:</b></td>
                                            <td><?php echo $l->guarantor->grtr_designation_state; ?></td>
                                            <td><b>Gender:</b></td>
                                            <td><?php echo $l->guarantor->grtr_gender; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Date of Birth:</b></td>
                                            <td><?php echo $l->guarantor->grtr_dob; ?></td>
                                            <td><b>Nic:</b></td>
                                            <td><?php echo $l->guarantor->grtr_id."V"; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Telephone:</b></td>
                                            <td><?php echo $l->guarantor->grtr_telephone; ?></td>
                                            <td><b>Email:</b></td>
                                            <td><?php echo $l->guarantor->grtr_email; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Saving Account Number:</b></td>
                                            <td><?php  ?></td>
                                            <td><b>Address:</b></td>
                                            <td><?php echo $l->guarantor->grtr_address; ?></td>
                                        </tr>
                                    </table> 
                                    <br>
                                        <h6 style="text-align:left"><b><u> Spouse details </u></b></h6>
                                        <br>
                                        
                        <table style="width:100%">
                                        <tr>
                                            <td><b>Full Name:</b></td>
                                            <td><?php echo $l->g_spouse->name; ?></td>
                                            <td><b>Nic:</b></td>
                                            <td><?php echo $l->g_spouse->spouse_id."V"; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Occupation:</b></td>
                                            <td><?php echo $l->g_spouse->occupation; ?></td>
                                            <td><b>Address:</b></td>
                                            <td><?php echo $l->g_spouse->address; ?></td>
                                        </tr>
                        </table> 
                                    <br>
                                    <h6 style="text-align:left"><b><u> Asset details </u></b></h6>
                                        <br>
                                        
                        <table style="width:100%">
                                        <tr>
                                            <td><b>Immovable properties:</b></td>
                                            <td><?php echo $l->guarantAsset->immovable_properties;?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Movable properties:</b></td>
                                            <td><?php echo $l->guarantAsset->movable_properties;?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Any other assets:</b></td>
                                            <td><?php echo $l->guarantAsset->any_other_assets;?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Guarantees on behalf of 3rd parties:</b></td>
                                            <td><?php echo $l->guarantAsset->guarantees_on_behalf;?></td>
                                        </tr>
                        </table>
                        

                        <div><!--background color div -->     
                        </div><!--/card-body-->
                    </div><!--/card text-center-->

            </div><!--/col-md-12-->    
        </div><!--/row p-3 justify-content-center-->       
      </div><!--/container-fluid -->
    </section><!--/section 1 -->

    <!--installment-->
    <section class="content-header"><!--section 2-->   
        <div class="container-fluid"><!--container-fluid-->
            <div class="card card-default"><!--card card-default-->
                <div class="card-header">
                    <h3 class="card-title">Installment</h3>
                </div><!-- /card-header -->
                <div class="card-body"><!--card body -->        
                    <table style="width:100%"><!--table 1-->
                        <tr> 
                        <td><div class='myDiv3'><?php echo "<b>TOTAL PAYMENT :</b> &nbsp;&nbsp;&nbsp;&nbsp".number_format($fullpayment, 2, '.', ',');?></div> </td>
                        <td><div class='myDiv3'><?php echo "<b>INTEREST :</b> &nbsp;&nbsp;&nbsp;&nbsp ".number_format($all_interest, 2, '.', ','); ?></div></td>
                        <td><div class='myDiv3'><?php echo "<b>EMI : </b> &nbsp;&nbsp;&nbsp;&nbsp".number_format($EMI,2,'.',','); ?></div></td>
                    </tr>
                    </table><!--/table 1-->
                    <br>
                    <br>   
                    <table class="table table-sm table-striped"><!--table 2-->
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
                    </table><!--/table 2-->
                    <?php
                    

                    echo"
                    <div class='reject btn btn-danger' data-type='rejectLoan' data-value='$l->loan_no'>Reject</div>"; //after click reject button send GET request data-type & loanNO

                    echo"
                    <div class='approved btn btn-primary' data-type='approvedLoan' data-value='$l->loan_no'>Approved</div>"; //after click approved button send GET request data-type & loanNO


                    
                    ?>
                </div><!-- /.card-body -->
                <!--card-footer --> 
                <div class="card-footer">
                                                                
                </div><!--/card-footer -->
            </div><!--/card card-default -->
        </div><!--/container-fluid -->
                <?php
                    } //end of else bracket
                ?>     

    </section><!--/section 2-->
    <!--/installment-->


<script>
    $(document).ready(function(){
        $(".view").click(function(){
            let url = window.location.href.split('?')[0] + "?type=" + $(this).data("type") + "&loanNo="+ $(this).attr('data-value');
                window.location.href= url;
        });
    });

    $(document).ready(function(){
        $(".approved").click(function(){
            let url = window.location.href.split('?')[0] + "?type2=" + $(this).data("type") + "&loanNo="+ $(this).attr('data-value');
                window.location.href= url;
        });
    });

    $(document).ready(function(){
        $(".reject").click(function(){
            let url = window.location.href.split('?')[0] + "?type3=" + $(this).data("type") + "&loanNo="+ $(this).attr('data-value');
                window.location.href= url;
        });
    });
</script>


<?php include"footer.php"; ?>



    

        

