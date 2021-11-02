<?php include"header.php"; ?>
<?php include"sidebar.php"; ?>
<?php

include_once "class/c_loan.php";
$l=new loan();

function check_loan_num($loanNo){
    if(empty($loanNo)){
        return false;
    }elseif(is_numeric($loanNo)){
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
                <div class="col-md-8"><!--col-md-8-->
                    <div class="card text-center"><!--card text-center -->
                        <div class="card-header">
                            Enter Loan Number
                        </div><!-- /card-header -->
                            <div class="card-body"><!--card body -->       
                                
                            <input class="form-control no-controls <?php if(isset($_GET["loanNo"])){if( !check_loan_num($_GET["loanNo"])){echo "is-invalid";}} ?>" type="number" value="<?php if(isset($_GET["loanNo"])){ echo $_GET["loanNo"]; } ?>" placeholder="Loan number" name="loanNo">
                            <br>
                            
                                
                            <div class="sbmt btn btn-primary" data-type="loanDet">Search</div>

                            </div><!-- /.card-body -->
                        
                    </div><!--/card text-center -->

                    <?php

                        if(isset($_GET["type"])){  //if any button click
                            switch($_GET["type"]){ // switch start

                                case "loanDet":

                                    if(isset($_GET["type"]) && $_GET["loanNo"]){
                                        if($l->is_exist_loan_account($_GET["loanNo"])){
                                            if($l->is_the_approved_loanNo($_GET["loanNo"])){
                                                $l->get_loan_account_loanNO($_GET["loanNo"])
                                ?>
                                                <div class="card text-center"><!--card text-center-->
                                                    <div class="card-header">Loan Details</div><!-- /card-header -->
                                                        <div class="myDiv2"><!--background color div -->
                                                            <div class="card-body" style="text-align:left;"><!--card body -->       
                                                                <table style="width:100%">
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
                                                                        <td><?php echo $l->per->cus_age." years";?></td>
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
                                                                        
                                                                        <td><?php echo "LKR. " . number_format($l->per->cus_monthely_income,2 , ".", ",");  ?></td>
                                                                    </tr>                  
                                                                </table>
                                                                <br>
                                                                <br> 
                                                                <?php   
                                                                        include_once "class/c_loan_payments.php";
                                                                        $p=new payments();
                                                                        if($p->is_exist_payment_this_month($l->loan_no)){ //check whether payment exist
                                                                        $p->get_payment_this_month($l->loan_no);
                                
                                                                ?>  <!--Display current payment this month-->
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
                                                                            <td><div class='pay btn btn-primary btn-sm' data-type='pay' data-value='$p->payment_no' amount='$p->amount'>Pay</div></td>
                                                                            </tr>
                                                                            
                                                                        </tbody>
                                                                         ";
                                                                ?>

                                                                        </table>
                                                                    
                                                                        <?php

                                                                    ?>
                                                                        <?php
                                                                        }else{ //not payment avilable
                                                                          //  echo "*** Not payment available this month ***<br>";
                                                                        }



                                                                $pdue=new payments();
                                                                if($pdue->is_exist_due_payments($l->loan_no)){
                                                                    //check whether due payment available and show
                                                                    $all=$pdue->get_due_payments($l->loan_no);
                                                                   

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
                                                                        
                                                                             echo" 
                                                                             <tbody> 
                                                                                 <tr>
                                                                                    <td>$item->payment_no</td>
                                                                                    <td>". "LKR. " . number_format($item->amount,2 , ".", ",") ."</td>
                                                                                    <td>$item->date</td>
                                                                                    <td>$due_date_number</td>
                                                                                    <td style='color:#FC350A';>". "LKR. " . number_format($interest,2 , ".", ",") ."</td>
                                                                                    <td><div class='pay btn btn-primary btn-sm' data-type='pay' data-value='$item->payment_no' panalty='$interest' amount='$due_amount'>Pay</div></td>
                                                                                </tr>
                                                                              </tbody>  
                                                                                   ";

                                                                        }
                                                                        ?>

                                                                    </table>
                                                                    
                                                                <?php
                                                                }else{
                                                                    // echo "*** Not due payment available  ***";
                                                                }

                                                                ?>
                                                                



                                                            </div><!-- /.card-body -->
                                                        </div><!--/background color div -->
                                                </div><!--/card text-center-->
                                                <?php
                                            }else{ // $l->is_the_approved_loanNo($_GET["loanNo"])
                                                ?>
                                                    <div class="alert alert-danger" role="alert">Account Does not exists</div>
                                                <?php
                                            }
                                            ?>
    
                                        <?php
                                        }else{
                                        ?>
                                        <div class="alert alert-danger" role="alert">Account Does not exists</div>
                                        <?php
                                        }
                                        ?>
    
                                    <?php
                                    }else{ //check whether search button click and check_loan_num($loanNo)
                                    ?>
                                    <div class="alert alert-danger" role="alert">Invalid Loan number or Invalid Request.</div>
                                    <?php
                                    }
                                    ?>
    
                                <?php
                                break;

                                case "pay":
                                    include_once "class/c_loan_payments.php";
                                    $p2=new payments();
                                    $p2->payment_done($_GET["loanNo"],$_GET["payNo"],$_GET["panalty"]);

                                    //to insert data payment history table
                                    include_once "class/c_loan.php"; 
                                    $ln=new loan();
                                    $ln->get_loan_account_loanNo($_GET["loanNo"]);
                                    $acc_id=$ln->acc_id;

                                    $p_his=new payments();
                                    $p_his->loan_no=$_GET["loanNo"]; 
                                    $p_his->payment_no=$_GET["payNo"]; 
                                    $p_his->paid_branch=$_SESSION["uu"]['branch_id']; 
                                    $p_his->acc_id= $acc_id; 
                                    $p_his->amount= $_GET["amount"]; 
                                    $p_his->panalty= $_GET["panalty"]; 

                                    $p_his->save_payment_history();

                                    $p3=new payments();
                                    if($p3->is_exist_remaining_payments($_GET["loanNo"])){// if remaining loan payment available

                                        $p3->get_number_of_remaining_payments($_GET["loanNo"]);
                                        $number_of_payment=$p3->number_of_payments;
                                        $monthely_amount=$_GET["amount"];
                                        //calculate remaining payment number_of_payent*monthly amount
                                        $remaining_payment_amount=$number_of_payment* $monthely_amount;

                                        //to get already complete payment balance
                                        include_once "class/c_loan_payments.php";
                                        $p4=new payments();
                                        $p4->get_number_of_complete_payments($_GET["loanNo"]);
                                        $number_of_complete_payment=$p4->number_of_complete_payments;
                                         //calculate remaining payment number_of_payent*monthly amount
                                         $complete_payment_amount=$number_of_complete_payment* $monthely_amount;


                                    
                                        //to get full payment balance
                                         include_once "class/c_loan.php";
                                         $l=new loan();
                                         $l->get_loan_account_loanNo($_GET["loanNo"]);
                                         $full_payment_amount=$l->full_amount;       
                                        ?>

                                        <div class="card text-center"><!--card text-center-->
                                            <div class="card-header">Loan Details</div><!-- /card-header -->
                                            <div class="myDiv2"><!--background color div -->
                                                    <div class="card-body" style="text-align:left;"><!--card body -->

                                                    <h2 style="color:#33cc33; text-align:center; "><b>Payment Successfull !</b></h2>
                                                    <div class="text-center">
                                                        
                                                        <b><?php echo "Remaining payment :"."LKR. " . number_format($remaining_payment_amount,2 , ".", ",")   ?></b>
                                                        <br>
                                                        <b><?php echo "Number of remaining installments : ".$number_of_payment." Installment"  ?></b>
                                                        <br>
                                                        <b><?php echo "Already completed payment :"."LKR. " . number_format($complete_payment_amount,2 , ".", ",");  ?></b>
                                                        <br>
                                                        <b><?php echo "Total payment :"."LKR. " . number_format($full_payment_amount,2 , ".", ",");  ?></b>
                                                       
                                                    </div><!--text-center"-->
                                                    <div class="text-center">
                                                    <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-3);"> 
                                                    </div>
                                                    </div><!-- /.card-body -->
                                            </div><!--/background color div -->
                                        </div><!--/card text-center-->       


                                        <?php
                                        }else{
                                            ?>
                                            <div class="card text-center"><!--card text-center-->
                                                <div class="card-header">Loan Details</div><!-- /card-header -->
                                                <div class="myDiv2"><!--background color div -->
                                                        <div class="card-body" style="text-align:left;"><!--card body -->

                                                        <h2 style="color:#33cc33; text-align:center; "><b>Payment Successfull !</b></h2>
                                                            <div class="text-center">
                                                                <p><b>All your loan installments have been paid off. Thank you!</b></p>
                                                                <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-3);"> <!--back button-->
                                                            </div>
                                                    
                                                        </div><!-- /.card-body -->
                                                </div><!--/background color div -->
                                            </div><!--/card text-center-->    





                                            <?php
                                        }
                                    ?>

                                        
                                    <?php
                                default:
                                    

                                






                                    
                            } // end of the switch
                        } // / end if any button click
                    ?>




                </div><!--col-md-8-->    
            </div><!--/row p-3 justify-content-center-->    
        </div><!--/container-fluid -->
    </section><!--/section-->





    <script>
        $(document).ready(function(){
            $(".sbmt").click(function(){
                // $(this).data("type")

                //If account number is valid
                let url = window.location.href.split('?')[0] + "?type=" + $(this).data("type") + "&loanNo="+ $("input[name=loanNo]").val();
                window.location.href= url;
                
            });
        });

        $(document).ready(function(){
            $(".pay").click(function(){
                // $(this).data("type")

                //If account number is valid
                let url = window.location.href.split('?')[0] + "?type=" + $(this).data("type") + "&loanNo="+ $("input[name=loanNo]").val() + "&payNo="+ $(this).attr('data-value') + "&amount=" + $(this).attr('amount') +"&panalty=" + $(this).attr('panalty');
                window.location.href= url;
                
            });
        });
    </script>


    
<?php include"footer.php"; ?>


    

        




    

        

