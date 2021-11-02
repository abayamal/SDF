<?php include"header2.php"; ?>
<?php include"sidebar2.php"; ?>

<?php

function check_amount($amount){
    if(is_numeric($amount)){
        return true;
    }else{
        return false;
    }
}

function check_month($month){
    if(is_numeric($month)){
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

                    <div class="card card-default"><!--card card-default -->
                        <div class="card-header">
                            <h3 class="card-title">Loan Calculator</h3>
                        </div><!-- /card-header -->
                        <div class="myDiv2"><!--background color div -->
                            <div class="card-body"><!--card body -->
                            <?php
                            if(!isset($_POST["submit"])){
                            ?>
                                <form action="loan_calculator_cus.php" method="POST">       
                                    <div class="row"><!-- row-->   


                                        <div class="col-md-6">
                                            <label for="loan_category">Loan Category</label>
                                        </div>
                                        <div class="col-md-6">    
                                            <select id="loan_category" name="loan_category" class="form-control" required="required">
                                            <option value="">--Select Loan Category--</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="loan_type">Loan type</label>
                                        </div>
                                        <div class="col-md-6">
                                            <select id="loan_type" name="loan_type" class="form-control" required="required">
                                            <option value="">--Select Loan Type--</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Loan Amount :</label>
                                        </div> 
                                        <div class="form-group col-md-6">   
                                            <input type="text" class="form-control select2" style="width: 100%" placeholder="Amount" name="loan_amount" required>  
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Month :</label>
                                        </div>
                                        <div class="form-group col-md-6">    
                                            <input type="text" class="form-control select2" style="width: 100%" placeholder="Number of month" name="month" required>  
                                        </div>
                                        <div class="form-group col-md-6">
                                        <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"> 
                                        <input class="btn btn-success btn-sm" type="submit" name="submit" value="Calculate" style="margin:1px;">
                                        </div>
                                    </div><!-- /row-->  
                                </form>

                                <?php
                            }else{

                                    if(check_amount($_POST["loan_amount"])){//check whether amount is numeric
                                        if(check_month($_POST["month"])){//check whether month is numeric

                                            //to get intrest of loan type
                                            include_once "class/c_loan_type.php";
                                            $lt=new loan_type();
                                            $lt->get_loan_type($_POST["loan_type"]);
                                            $interest=$lt->interest;

                                            // to display installment
                                            $princ = $_POST["loan_amount"]; //principal amount
                                            $term  =  $_POST["month"]; //months
                                            $intr  =  $interest/ 1200; //get percentage

                                            $EMI= ceil($princ * $intr / (1 - (pow(1/(1 + $intr), $term)))); # This for total EMI

                                            $fullpayment=$EMI*$term;
                                            $intrest=$princ*$intr;
                                            $all_interest=$fullpayment-$princ;
                                        ?>


                                        <table style="width:100%">
                                            <tr> 
                                            <td><div class='myDiv4'><?php echo "<b>TOTAL PAYMENT :</b> &nbsp;&nbsp"."LKR. ".number_format($fullpayment, 2, '.', ',');?></div> </td>
                                            <td><div class='myDiv4'><?php echo "<b>INTEREST :</b> &nbsp;&nbsp; "."LKR. ".number_format($all_interest, 2, '.', ','); ?></div></td>
                                            <td><div class='myDiv4'><?php echo "<b>EMI : </b> &nbsp;&nbsp"."LKR. ".number_format($EMI,2,'.',','); ?></div></td>
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
                                        <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);">    

                                           
                                            
                                            
                                        <?php
                                        }else{
                                            ?>

                                            <div class='alert alert-danger form-group col-md-12' role='alert'>please Enter Valid Month !</div>
                                            <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"> 
    
    
                                            <?php

                                        }


                                    }else{// amount is not numeris display this alert
                                        ?>

                                        <div class='alert alert-danger form-group col-md-12' role='alert'>please Enter valid Amount</div>
                                        <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"> <!--back button-->


                                        <?php
                                    }

                                
                            }
                            ?>



                            </div><!-- /.card-body -->
                        </div><!--/background color div -->
                        <div class="card-footer"><!--card-footer --> 
                        </div><!--/card-footer -->
                    </div><!--/card card-default -->
                </div><!--/col-md-8-->
            </div><!--/row p-3 justify-content-center-->
        </div><!--/container-fluid -->
    </section><!--/section-->

<script>

$(document).ready(function(){

    $.get("ajax.php?ltype=loanCat",function(data){
        
        parsedData=JSON.parse(data);

        $.each(parsedData, function(index,loanCat){
            $("#loan_category").append("<option value='"+loanCat['id']+"'>"+loanCat['name']+"</option>");
        });
    });

    $("#loan_category").change(function(event){
                // alert($(this).val());
                $("#loan_type").html("<option value='0'>--Select loan Type--</option>");
            

                $.get("ajax.php?ltype=loanType&loan_category_id="+ $(this).val(), function(data){

                    parsedData = JSON.parse(data);

                    $.each(parsedData, function(index, loanType){                    
                        $("#loan_type").append("<option value='" + loanType['id'] + "'>" + loanType['name'] + "</option>");
                    });
                
                });         
            });
        

    
});




</script>









</div>
<?php include"footer2.php"; ?>


    

        

