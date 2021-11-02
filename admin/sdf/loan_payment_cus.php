<?php include"header2.php"; ?>
<?php include"sidebar2.php"; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"><!--section-->
        <div class="container-fluid"><!--container-fluid -->
            <div class="row p-3 justify-content-center"><!--row p-3 justify-content-center-->
                <div class="col-md-8"><!--col-md-8-->
                    <div class="card text-center"><!--card text-center -->
                        <div class="card-header">
                            <h3 class="card-title">Loan Accounts</h3>
                        </div><!-- /card-header -->
                        <div class="myDiv2"><!--background color div -->
                            <div class="card-body" style="text-align:left;"><!--card body --> 
                                
                                <?php
                                    if(!isset($_GET["type"])){

                                    include_once "class/c_loan.php";
                                    $a = new loan();
                                    if($a->is_exist_atleast_one_loan_account($_SESSION["uu"]['cus_id'])){

                                    $allLoan=$a->get_all_approved_loan_account($_SESSION["uu"]['cus_id'],$_SESSION["uu"]['branch_id']);
                                ?>
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
                                                foreach($allLoan as $item)
                                                {
                                                    echo"  
                                                        <tbody>
                                                            <tr>
                                                            <td>$item->loan_no</th>
                                                            <td>$item->cus_id V</td>
                                                            <td>". "LKR. " . number_format($item->amount,2 , ".", ",") ."</td>
                                                            <td>$item->date</td>
                                                            <td><div class='selectLoan btn btn-success btn-sm' data-type='selectLoan' data-value='$item->loan_no' nic='$item->cus_id'>Select</div></td>
                                                            </tr>
                                                        </tbody>
                                                        ";
                                                }
                                                ?>
                                </table><!--/table table-sm--> 
                                <?php
                                    }else{ // ! is_exist_atleast_one_loan_account($_SESSION["uu"]['cus_id'])
                                        echo "<span style='color:red;text-align:center;'><b>No Loan Available !<b></span>";
                                    }



                                    }else{ // after click details button
                                          
                                        switch($_GET["type"]){

                                            case "selectLoan":
                                                $loanNo=$_GET["loanNo"];
                                                $nic=$_GET["nic"];

                                                //Get all account to relevent loan NIC number
                                                include_once "class/c_account.php";
                                                $ac=new account();
                                                $allAcc=$ac->get_all_account_from_nic($nic);
                                ?>
                                                <table class="table table-sm">
                                                <h4 style="color:#009933;"><b>Please select saving account to pay monthely installment.</b></h4>
                                                <br>
                                                <thead>
                                                    <tr>
                                                    <th scope="col">Account Number</th>
                                                    <th scope="col">Account Nickname</th>
                                                    <th scope="col">Account Balance</th>
                                                    <th scope="col">Operation</th>
                                                    </tr>
                                                </thead>
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
                                                                <th scope='row'>$item->acc_id</th>
                                                                <td>".$item->cust->cus_full_name."</td>
                                                                <td>". "<b>LKR. " . number_format($balance,2 , ".", ",<b>") ."</td>
                                                                <td><div class='selectAcc btn btn-success btn-sm' data-type='select_account' data-value='$item->acc_id' loan-number='$loanNo'>Select</div></td>
                                                                </tr>
                                                                
                                                            </tbody>
                                                            ";
                                                    }
                                                    ?>
                                                </table>
                                            <?php
                                            break;
                                            
                                            case "select_account":
                                                //to display payments
                                                $AccNo=$_GET["AccNo"];
                                                $LoanNo=$_GET["LoanNo"];
                                              

                                                include_once "class/c_loan_payments.php";
                                                $p=new payments();
                                                if($p->is_exist_payment_this_month($LoanNo)){ //check whether payment exist
                                                $p->get_payment_this_month($LoanNo);

                                                $total_pay_amount=$p->amount; //payment amount without panalty
                                                
                                            ?>
                                            <!--Display current payment this month-->
                                            <h3><b><u>Payment current month</u></b></h3>
                                                <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Payment Number</th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Date</th>
                                                        <th scope="col">Operation</th>
                                                        
                                                    </tr>
                                                </thead>
                                            <?php
                                                    echo"  
                                                    <tbody>
                                                        <tr>
                                                        <th scope='row'>$p->payment_no</th>
                                                        <td>". "LKR. " . number_format($p->amount,2 , ".", ",") ."</td>
                                                        <td>$p->date</td>
                                                        <td><div class='pay btn btn-primary btn-sm' data-type='pay' data-value='$p->payment_no' loan-number='$p->loan_no' account-number='$AccNo' total-pay-amount='$total_pay_amount' amount='$p->amount'>Pay</div></td>
                                                        </tr>
                                                                            
                                                    </tbody>
                                                     ";
                                            ?>

                                                    </table>
                                            <?php
                                                }else{
                                                   echo "**Not Available payment this month** ";
                                                }
                                            
                                                $pdue=new payments();
                                                if($pdue->is_exist_due_payments($LoanNo)){
                                                    //check whether due payment available and show
                                                    $all=$pdue->get_due_payments($LoanNo);
                                                    ?>
                                                    <!--Display due payments-->
                                                    <br>
                                                    <br>
                                                    <h3><b><u>Due payments</u></b></h3>
                                                    <table class="table table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Payment Number</th>
                                                                <th scope="col">Amount</th>
                                                                <th scope="col">Date</th>
                                                                <th scope="col">Number of date</th>
                                                                <th scope="col">Panalty</th>
                                                                <th scope="col">Operation</th>
                                                                
                                                            </tr>
                                                        </thead>
                                                        <?php
                                                        foreach($all as $item){
                                                            //to get number of due dates.
                                                            $now = time(); 
                                                            $need_date = strtotime("$item->date");
                                                            $datediff = $now - $need_date;

                                                            $due_date_number=round($datediff / (60 * 60 * 24));

                                                            //calculate interest to duedates
                                                            $due_amount=$item->amount;
                                                            //5% interest to 30days
                                                            $full_month_int=$due_amount*5/100;
                                                            //5% interest to per day
                                                            $per_day_int=$full_month_int/30;
                                                            //Interest to current date
                                                            $interest=$per_day_int*$due_date_number;
                                                            
                                                            $amount=$item->amount;
                                                            $total_pay_amount=$amount+$interest;// this is total payment with amount and panalty.(amount+panalty)



                                                             echo" 
                                                             <tbody> 
                                                                 <tr>
                                                                    <td>$item->payment_no</td>
                                                                    <td>". "LKR. " . number_format($item->amount,2 , ".", ",") ."</td>
                                                                    <td>$item->date</td>
                                                                    <td>$due_date_number</td>
                                                                    <td style='color:#FC350A';>". "LKR. " . number_format($interest,2 , ".", ",") ."</td>
                                                                    <td><div class='pay btn btn-primary btn-sm' data-type='pay' data-value='$item->payment_no' panalty='$interest' loan-number='$item->loan_no' account-number='$AccNo' total-pay-amount='$total_pay_amount' amount='$amount'>Pay</div></td>
                                                                </tr>
                                                              </tbody>  
                                                                   ";

                                                        }
                                                        ?>

                                                    </table>
                                                    
                                                <?php
                                                }else{
                                                     echo "<br>*** Not due payment available  ***";
                                                }

                                            
                                            break;    

                                            case "pay":

                                                //first of all check your account balance suffecient to pay monthly installment
                                                $total_pay_amount=$_GET["total-pay-amount"];
                                                $amount=$_GET["amount"];
                                                $panalty=$_GET["panalty"];
                                                $acc_number=$_GET["AccNo"];

                                                include_once "class/c_account.php";
                                                $acc=new account();
                                                $acc-> get_account($acc_number);
                                                $acc_balance=$acc->acc_balance;
                                                if($total_pay_amount<$acc_balance){//check whether your account has suffecient amount to pay the monthely installment

                                                    include_once "class/c_loan_payments.php";
                                                        $p2=new payments();
                                                        $p2->payment_done_from_customer($_GET["LoanNo"],$_GET["payNo"],$_GET["panalty"],$_GET["amount"],$_GET["AccNo"]);

                                                        //to get loan repayment balance,to get already complete payment balance,to get full payment balance
                                                        include_once "class/c_loan_payments.php";
                                                        $p3=new payments();
                                                        if($p3->is_exist_remaining_payments($_GET["LoanNo"])){// if remaining loan payment available

                                                             //to get loan repayment balance
                                                            $p3->get_number_of_remaining_payments($_GET["LoanNo"]);
                                                            $number_of_payment=$p3->number_of_payments;
                                                            $monthely_amount=$_GET["amount"];
                                                            //calculate remaining payment number_of_payent*monthly amount
                                                            $remaining_payment_amount=$number_of_payment* $monthely_amount;


                                                            //to get already complete payment balance
                                                            include_once "class/c_loan_payments.php";
                                                            $p4=new payments();
                                                            $p4->get_number_of_complete_payments($_GET["LoanNo"]);
                                                            $number_of_complete_payment=$p4->number_of_complete_payments;
                                                             //calculate remaining payment number_of_payent*monthly amount
                                                             $complete_payment_amount=$number_of_complete_payment* $monthely_amount;


                                                             //to get full payment balance
                                                             include_once "class/c_loan.php";
                                                             $l=new loan();
                                                             $l->get_loan_account_loanNo($_GET["LoanNo"]);
                                                             $full_payment_amount=$l->full_amount;
                                            


                                                        ?>
                                                            <h2 style="color:#33cc33; text-align:center; "><b>Payment Successfull.. !</b></h2>
                                                            <div class="text-center">
                                                            <b><?php echo "Remaining payment :"."LKR. " . number_format($remaining_payment_amount,2 , ".", ",")   ?></b>
                                                            <br>
                                                            <b><?php echo "Number of remaining installments : ".$number_of_payment." Installment"  ?></b>
                                                            <br>
                                                            <b><?php echo "Already completed payment :"."LKR. " . number_format($complete_payment_amount,2 , ".", ",");  ?></b>
                                                            <br>
                                                            <b><?php echo "Total payment :"."LKR. " . number_format($full_payment_amount,2 , ".", ",");  ?></b>
                                                            <br>
                                                            <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-3);"> 
                                                            </div>
                                                        <?php    
                                                        }else{//if remaining loan payment not available.all payment complete successfully.
                                                            ?>
                                                            <h2 style="color:#33cc33; text-align:center; "><b>Payment Successfull !</b></h2>
                                                            <div class="text-center">
                                                                <p><b>All your loan installments have been paid off. Thank you!</b></p>
                                                                <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-3);"> <!--back button-->
                                                            </div>
                                                        <?php
                                                        }    
                                                        ?>
                                                <?php
                                                }else{
                                                    ?>
                                                     <div class='alert alert-danger form-group col-md-12' role='alert'>Your account balance is not suffecient to pay installment.</div>
                                                     <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-2);"><!--back button-->
                                                    <?php
                                                }
                                                

                                                
                                            break;







                                            }
                                        ?>

                                        
                                       


                                    <?php
                                    }

                                ?>
                            </div><!-- /.card-body -->
                        </div><!--/background color div -->

                        <div class="card-footer"><!--card-footer --> 
                        </div><!--/card-footer -->
                        
                    </div><!--/card text-center -->
                </div><!--/col-md-8-->                  
            </div><!--/row p-3 justify-content-center-->
        </div><!--/container-fluid -->
    </section><!--/section-->

    <script>
         $(document).ready(function(){
            $(".selectLoan").click(function(){
                // $(this).data("type")

                //If account number is valid
                let url = window.location.href.split('?')[0] + "?type=" + $(this).data("type") + "&loanNo="+ $(this).attr('data-value') +  "&nic="+ $(this).attr('nic');
                window.location.href= url;
                
            });

            $(".selectAcc").click(function(){
                // $(this).data("type")

                //If account number is valid
                let url = window.location.href.split('?')[0] + "?type=" + $(this).data("type") + "&AccNo="+ $(this).attr('data-value') + "&LoanNo="+ $(this).attr('loan-number');
                window.location.href= url;
                
            });

            $(".pay").click(function(){
                // $(this).data("type")

                //If account number is valid
                let url = window.location.href.split('?')[0] + "?type=" + $(this).data("type") + "&LoanNo="+ $(this).attr('loan-number') + "&AccNo="+ $(this).attr('account-number') + "&payNo="+ $(this).attr('data-value') + "&panalty=" + $(this).attr('panalty') + "&total-pay-amount=" + $(this).attr('total-pay-amount') + "&amount=" + $(this).attr('amount');
                window.location.href= url;
                
            });
        });
    </script>


<?php include"footer2.php"; ?>


    

        

