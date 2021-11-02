<?php include"header.php"; ?>
<?php include"sidebar.php"; ?>
<?php

include_once "class/c_loan.php";
$l=new loan();

    function check_nic_num($number){
        if(empty($number)){
            return false;
        }elseif(!is_numeric($number)){
            return false;
        }elseif(strlen($number)==9){
            return true;
        }else{
            return false;
        }
    }

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"><!--section-->
        <div class="container-fluid"><!--container-fluid -->
            <div class="row p-3 justify-content-center"><!--row p-3 justify-content-center-->
                <div class="col-md-10"><!--col-md-8-->
                    
                    
                <?php    
                  if(!isset($_GET["type"])){  
                    
                    
                    
                ?>    
                    <div class="card text-center"><!--card text-center -->
                        <div class="card-header">
                            <h3 class="card-title">Loan Details</h3>
                        </div><!-- /card-header -->
                            <div class="card-body"><!--card body -->       
                                
                            <input class="form-control no-controls <?php if(isset($_GET["loanNo"])){if( !check_loan_num($_GET["loanNo"])){echo "is-invalid";}} ?>" type="number" value="<?php if(isset($_GET["loanNo"])){ echo $_GET["loanNo"]; } ?>" placeholder="NIC Number" name="nic">
                            <br>

                            <div class="sbmt btn btn-primary" data-type="loanDet">Search</div>


                            </div><!-- /.card-body -->
                    </div><!--/card text-center -->


                <?php
                  }
                  else{
                      
                    switch($_GET["type"]){

                        case "loanDet":
                            
                            if(check_nic_num($_GET["nic"])){
                                if($l->is_exist_atleast_one_loan_account($_GET["nic"])){
                                    if($l->is_many_loan_account($_GET["nic"])){

                                        $branch_id=$_SESSION["uu"]['branch_id'];
                                        $lo=$l->get_all_approved_loan_account($_GET["nic"],$branch_id);
                                    ?>

                                        <div class="card text-center"><!--card text-center-->
                                            <div class="card-header">Loan Details</div>
                                            <div class="card-body" style="text-align:left;"><!--card-body-->
                                                <table class="table table-sm"><!--table table-sm-->
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
                                                        foreach($lo as $item)
                                                        {
                                                            echo"  
                                                                <tbody>
                                                                    <tr>
                                                                    <td>$item->loan_no</th>
                                                                    <td>$item->cus_id</td>
                                                                    <td>$item->amount</td>
                                                                    <td>$item->date</td>
                                                                    <td><div class='view btn btn-primary' data-type='viewLoan' data-value='$item->loan_no'>View</div></td>
                                                                    </tr>
                                                                </tbody>
                                                                ";
                                                        }
                                                        ?>
                                                </table><!--/table table-sm--> 
                                            </div><!--/card-body-->
                                        </div><!--/card text-center-->              

                                    <?php
                                    }else{ // end $l->is_many_loan_account($_GET["nic"])

                                           if($l->is_the_loan_approved($_GET["nic"])){ //check whether loan is approved
                                                $l->get_loan_account($_GET["nic"]);
                                    ?>
                                        <div class="card text-center"><!--card text-center-->
                                            <div class="card-header">Loan Details</div>
                                                <div class="myDiv2"><!--background color div --> 
                                                <div class="card-body" style="text-align:left;"><!--card-body-->
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
                                                                <td><?php echo $l->loanCategory->loan_category_name; ?></td>
                                                                <td><b>Loan Type:</b></td>
                                                                <td><?php ; ?></td>
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
                                                                <td><?php echo $l->per->cus_monthely_income; ?></td>
                                                            </tr>
                                                            
                                                        </table> 
                                                            <br>
                                                            <h6 style="text-align:left"><b><u>Spouse details </u></b></h6>
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
                                                        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
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
                                                                <td><?php echo $l->guarantor->grtr_designation; ?></td>
                                                                <td><b>Gender:</b></td>
                                                                <td><?php echo $l->guarantor->grtr_gender; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Date of Birth:</b></td>
                                                                <td><?php echo $l->guarantor->grtr_dob; ?></td>
                                                                <td><b>Nic:</b></td>
                                                                <td><?php echo $l->guarantor->grtr_id; ?></td>
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
                                                </div><!--/card-body-->
                                                </div><!--/background color div -->           
                                        </div><!--/card text-center--> 

                                        <!--installment-->
                                        <?php

                                            $l=new loan();
                                            $l->get_loan_account($_GET["nic"]);

                                            $princ =$l->amount; //principal amount
                                            $term = $l->repayment_period; //months
                                            $intr =$l->interest/ 1200; //get percentage

                                            $EMI= ceil($princ * $intr / (1 - (pow(1/(1 + $intr), $term)))); # This for total EMI

                                            $fullpayment=$EMI*$term;
                                            $intrest=$princ*$intr;
                                            $all_interest=$fullpayment-$princ;

                                        ?>
                                        <div class="card text-center"><!--card text-center-->
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
                                                        <th scope="col">Status</th>
                                                        </tr>
                                                    </thead>
                                                        <tbody>
                                                        <?php
                                                           
                                                            include_once "class/c_loan_payments.php";
                                                            $p=new payments();
                                                            $payment=$p->get_all_payments_from_LoanNo($l->loan_no);
                                                            
                                                            foreach($payment as $item){
                                                        echo"
                                                            <tr>
                                                            <th scope='row'>$item->payment_no</th>
                                                            <td>".number_format($item->amount, 2, '.', ',')."</td>
                                                            <td>$item->date</td>
                                                            <td>".number_format($item->balance, 2, '.', ',')."</td>
                                                            <th scope='row'>$item->status</th>
                                                            </tr>"
                                                            ;
                                                            }
                                                           
                                                    ?>
                                                        </tbody>
                                                </table><!--/table 2-->
                                                <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                                
                                            </div><!-- /.card-body -->
                                        </div><!--card text-center-->                                                                               
                                    <!--/installment-->                                            
                                    <?php
                                           }else{ // end $l->is_the_loan_approved($_GET["nic"])
                                    ?>
                                            <div class="alert alert-danger" role="alert">There is no loan account associated with this nic number!</div>
                                            <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                    <?php
                                                }
                                    ?>
                                    <?php    
                                    }


                                }else{ // end $l->is_one_loan_account($_GET["nic"]))
                                ?>
                                    <div class="alert alert-danger" role="alert">There is no loan account associated with this nic number!</div>
                                    <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->

                                <?php
                                }
                                

                            }else{// is_exist_atleast_one_loan_account($_GET["nic"])
                            ?>    
                                <div class="alert alert-danger" role="alert">Invalid NIC Number</div>
                                <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                            <?php
                            }


                                
                        break;  //end of loanDet case
                        
                        case "viewLoan":
                            $l->get_loan_account_loanNo($_GET["loanNo"]);
                        ?>
                                    <div class="card text-center"><!--card text-center-->
                                            <div class="card-header">Loan Details</div>
                                                <div class="myDiv2"><!--background color div --> 
                                                <div class="card-body" style="text-align:left;"><!--card-body-->
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
                                                                <td><?php echo $l->loanCategory->loan_category_name; ?></td>
                                                                <td><b>Loan Type:</b></td>
                                                                <td><?php ; ?></td>
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
                                                            <br>
                                                            <h6 style="text-align:left"><b><u>Spouse details </u></b></h6>
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
                                                        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
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
                                                                <td><?php echo $l->guarantor->grtr_designation; ?></td>
                                                                <td><b>Gender:</b></td>
                                                                <td><?php echo $l->guarantor->grtr_gender; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Date of Birth:</b></td>
                                                                <td><?php echo $l->guarantor->grtr_dob; ?></td>
                                                                <td><b>Nic:</b></td>
                                                                <td><?php echo $l->guarantor->grtr_id; ?></td>
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
                                                </div><!--/card-body-->
                                                </div><!--/background color div -->           
                                        </div><!--/card text-center--> 

                                        <!--installment-->
                                        <?php

                                            $l=new loan();
                                            $l->get_loan_account_loanNO($_GET["loanNo"]);

                                            $princ =$l->amount; //principal amount
                                            $term = $l->repayment_period; //months
                                            $intr =$l->interest/ 1200; //get percentage

                                            $EMI= ceil($princ * $intr / (1 - (pow(1/(1 + $intr), $term)))); # This for total EMI

                                            $fullpayment=$EMI*$term;
                                            $intrest=$princ*$intr;
                                            $all_interest=$fullpayment-$princ;

                                        ?>
                                        <div class="card text-center"><!--card card-default-->
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
                                                            
                                                                include_once "class/c_loan_payments.php";
                                                                $p=new payments();
                                                                $payment=$p->get_all_payments_from_LoanNo($l->loan_no);
                                                                
                                                                foreach($payment as $item){
                                                            echo"
                                                                <tr>
                                                                <th scope='row'>$item->payment_no</th>
                                                                <td>".number_format($item->amount, 2, '.', ',')."</td>
                                                                <td>$item->date</td>
                                                                <td>".number_format($item->balance, 2, '.', ',')."</td>
                                                                </tr>"
                                                                ;
                                                                }
                                                            
                                                            ?>
                                                        </tbody>
                                                </table><!--/table 2-->
                                                <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->

                                                
                                            </div><!-- /.card-body -->
                                        </div><!--card text-center-->                                                                        
                                    <!--/installment-->                             
                                


                        <?php
                        break;  //end of viewloan case  

                        default:
                             ?>
                            <div class="alert alert-danger" role="alert">Invalid Request</div>
                            <?php  



                  }//end switch

                }//end main else
                ?>






                </div><!--/col-md-8-->
            </div><!--/row p-3 justify-content-center-->
        </div><!--/container-fluid -->
    </section><!--/section-->

    <script>
        $(document).ready(function(){
            $(".sbmt").click(function(){
                // $(this).data("type")

                //If account number is valid
                let url = window.location.href.split('?')[0] + "?type=" + $(this).data("type") + "&nic="+ $("input[name=nic]").val();
                window.location.href= url;
                
            });
        });

        $(document).ready(function(){
            $(".view").click(function(){
                // $(this).data("type")

                //If account number is valid
                let url = window.location.href.split('?')[0] + "?type=" + $(this).data("type") + "&loanNo="+ $(this).attr('data-value');
                window.location.href= url;
                
            });
        });
    </script>

<?php include"footer.php"; ?>


    

        

