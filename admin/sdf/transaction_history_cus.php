<?php include"header2.php"; ?>
<?php include"sidebar2.php"; ?>
<?php

include_once "class/c_transaction.php";
$t1=new transaction();


?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"><!--section-->
        <div class="container-fluid"><!--container-fluid -->
            <div class="row p-3 justify-content-center"><!--row p-3 justify-content-center-->
                <div class="col-md-12"><!--col-md-8-->
                <?php
                if(!isset($_GET["type"])){

                    $cus_id=$_SESSION["uu"]['cus_id'];
                    include_once "class/c_account.php";
                    $a=new account();
                    $allAcc=$a->get_all_account_from_nic($cus_id); //get all account match to user nic


                ?>
                    <div class="card text-center"><!--card text-center -->
                        <div class="card-header">
                        <h3 class="card-title">Transaction History</h3>
                        </div><!-- /card-header -->
                        <div class="myDiv2"><!--background color div -->
                            <div class="card-body" style="text-align:left;"><!--card body -->
                                <div class="row p-2 justify-content-center"><!--row-->
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                            <th scope="col">Account Number</th>
                                            <th scope="col">Account Nickname</th>
                                            <th scope="col">Account Balance</th>
                                            <th scope="col">From</th>
                                            <th scope="col">To</th>
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
                                                        <td><input class='form-control no-controls' type='date'   name='from' ></td>
                                                        <td><input class='form-control no-controls' type='date'   name='to'  ></td>     
                                                        <td><div class='view btn btn-success btn-sm' data-type='transactions' data-value='$item->acc_id'>Transactions</div></td>
                                                        </tr>

                                                    </tbody>
                                                    ";
                                            }
                                            ?>
                                    </table>
                                </div><!--row-->    
                            </div><!--/card body --> 
                        </div><!--/background color div -->
                            <div class="card-footer"><!--card-footer --> 
                            </div><!--/card-footer -->       
                    </div><!--/card text-center --> 
                    

                <?php
                }elseif($t1->is_exist_transaction_between_two_days($_GET["from"],$_GET["to"],$_GET["accNo"])==false){//// after click transaction button if transaction are not exist
                ?>

                    <div class="card text-center"><!--card text-center -->
                        <div class="card-header">
                        <h3 class="card-title">Transaction History</h3>
                        </div><!-- /card-header -->
                        <div class="myDiv2"><!--background color div -->
                        <div class="card-body" style="text-align:center;"><!--card-body-->
                            <h1 style="color:red"><b>Not exist transaction between two days !</b></h1>
                            <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"> <!--back button-->
                        </div><!--/card-body-->
                        </div><!--/background color div -->       
                    </div><!--/card text-center --> 
                    


                <?php
                }else{ // after click transaction button

                    $cus_id=$_SESSION["uu"]['cus_id'];
                    include_once "class/c_transaction.php";
                    $t=new transaction();

                    $from=$_GET["from"];
                    $to=$_GET["to"];
                    $accNo=$_GET["accNo"];
                    $allAcc=$t->get_transaction_between_two_days($from,$to,$accNo); //get all trnsaction between two days


                    ?>
                    <div class="card text-center"><!--card text-center -->
                            <div class="card-header">
                            <h3 class="card-title">Transaction History</h3>
                            </div><!-- /card-header -->
                            <div class="card-body" style="text-align:left;"><!--card body -->
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                        <th scope="col">Trans ID</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Account Number</th>
                                        <th scope="col">Debit</th>
                                        <th scope="col">Credit</th>
                                        <th scope="col">Balance</th>
                                        </tr>
                                    </thead>
                                    <?php
                                        foreach($allAcc as $item)
                                        {
                                            // Get account balance accbal table
                                            include_once "class/c_account.php";
                                            $a2=new account();
                                            $a2->get_branch_account_balance($item->acc_id);
                                            $balance=$a2->acc_balance;

                                            echo"  
                                                <tbody>
                                                    <tr>
                                                        <td>$item->trans_id</td>
                                                        <td>$item->trans_date</td>
                                                        <td>$item->acc_id</td>
                                                        <td>$item->debit</td>
                                                        <td>$item->credit</td>
                                                        <td>". "LKR. " . number_format($item->balance,2 , ".", ",") ."</td>
                                                    </tr>
                                                    
                                                </tbody>
                                                ";
                                        }
                                        ?>
                                </table>
                                <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"> <!--back button-->
                            
                            </div><!--/card body -->
                    </div><!--/card text-center -->
                    
                    <?php
                }
                ?>
                </div><!--/col-md-8-->  
            </div><!--/row p-3 justify-content-center-->
        </div><!--/container-fluid -->
    </section><!--/section-->

    <script>
        $(document).ready(function(){
            $(".view").click(function(){
                // $(this).data("type")

                //If account number is valid
                let url = window.location.href.split('?')[0] + "?type=" + $(this).data("type") + "&from="+ $("input[name=from]").val() + "&to="+ $("input[name=to]").val() +"&accNo=" + $(this).attr('data-value');
                window.location.href= url;
                
            });
        });

        
    </script>


<?php include"footer2.php"; ?>


    

        

