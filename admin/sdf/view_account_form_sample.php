<?php include"header.php"; ?>
<?php include"sidebar.php"; ?>
<?php
ini_set('mysql.connect_timeout',300);
ini_set('default_socket_timeout',300);

?>



<?php
include "class/c_account.php";
$a = new account();
include "class/c_customer.php";
$c = new customer();
include "class/c_transaction.php";
$t =new transaction();



function check_acc_num($number){
    if(empty($number)){
        return false;
    }elseif(is_numeric($number)){
        return true;
    }else{
        return false;
    }
}
?>

      

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
                <div class="row p-3 justify-content-center">
                    <div class="col-md-10">
                        <div class="card text-center">
                            <div class="card-header">
                            Enter Account Number
                            </div>
                            <div class="card-body">
                            
                                <input class="form-control no-controls <?php 
                                if(isset($_GET["acc_id"])){if( !check_acc_num($_GET["acc_id"])){echo "is-invalid";}} 
                                ?>" type="number" value="<?php if(isset($_GET["acc_id"])){ echo $_GET["acc_id"]; } ?>" placeholder="Account number" name="acc_id">

                                <br>
                                
                                <div class="sbmt btn btn-primary" data-type="accDet">Account Details</div>
                                <div class="sbmt btn btn-info" data-type="accBal">Account Balance</div>
                                <div class="sbmt btn btn-secondary" data-type="accHis">Transaction History</div>
                                <div class="sbmt btn btn-secondary" data-type="date_picker">Transaction History Between Two Days</div>
                                                                   
                            </div>
                        </div>
                        <?php                            

                            if(isset($_GET["type"])){

                                if(!empty($_GET["type"]) && check_acc_num($_GET["acc_id"])){
                                    switch($_GET["type"]){
                                        case "accDet":
                                            if($a->is_exist_account($_GET["acc_id"]))//fetch account details
                                            {
                                                $c->get_customer($a->cus_id); //fetch customer details
                                                ?>

                                                <div class="card text-center">
                                                    <div class="card-header">Account Details</div><!--Account Details-->
                                                        <div class="myDiv2"><!--background color div -->
                                                            <div class="card-body" style="text-align:left;"><!--card-body-->
                                                                <table class="responsive w-100">
                                                                    <tr>
                                                                        <td><b>Account ID:</b></td>
                                                                        <td><?php echo  $a->acc_id; ?></td>
                                                                        <td><b>Account Type:</b></td>
                                                                        <td><?php echo $a->acc_type; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><b>Account Status:</b></td>
                                                                        <td><b><?php echo "<span style='color:#2ab71e'>$a->acc_status</span>" ?><b></td>
                                                                        <td><b>Opened Date:</b></td>
                                                                        <td><?php echo $a->acc_created_date; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><b>Account Balance:</b></td>
                                                                        <td><?php echo "LKR. " . number_format($a->acc_balance,2 , ".", ","); ?></td>
                                                                        <td><b>Customer NIC:</b></td>
                                                                        <td><?php echo $c->cus_id; ?>V</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><b>Customer Name:</b></td>
                                                                        <td><?php echo $c->cus_full_name  ?></td>
                                                                        <td><b>Customer Address:</b></td>
                                                                        <td><?php echo $c->cus_address; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><b>Customer Telephone:</b></td>
                                                                        <td><?php echo $c->cus_telephone; ?></td>
                                                                        <td><b>Customer Email:</b></td>
                                                                        <td><?php echo $c->cus_email; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><b>Gender:</b></td>
                                                                        <td><?php echo $c->cus_gender; ?></td>
                                                                        <td><b>Date of birth:</b></td>
                                                                        <td><?php echo $c->cus_dob; ?></td>
                                                                    </tr>
                                                                </table>
                                                            </div><!--/card-body-->
                                                        </div><!--/background color div -->
                                                    </div><!--/Account Details-->
                                                <?php
                                            }else
                                            {
                                                ?>

                                                    <div class="alert alert-danger" role="alert">Account does not exist. please enter valid account number ! 
                                                    </div>
                                                
                                                <?php
                                            }                                            
                                        break;
                                        case "accBal":                                              
                                            ?>
                                            <?php
                                                if($a->is_exist_account($_GET["acc_id"]))
                                                {
                                            ?>
                                                <div class="card text-center">
                                                    <div class="card-header">Account Balance</div><!--Account Balance-->
                                                    <div class="myDiv2"><!--background color div -->
                                                    
                                                    <div class="card-body" style="text-align:center;"><!--card-body-->
                                                    <?php echo "<b>LKR. " . number_format($a->acc_balance,2 , ".", ",<b>"); ?>
                                                    </div><!--/card-body-->
                                                    </div><!--/background color div -->
                                                </div> 
                                                <?php
                                                } 
                                                    else{
                                                ?>    
                                                    <div class="alert alert-danger" role="alert">Account does not exist. please enter valid account number ! 
                                                    </div>
                                                    
                                                <?php        
                                                        }
                                                ?>    
                                            <?php                                       
                                        break; 
                                        case "accHis":                                              
                                            ?>
                                            <?php
                                            
                                                //$trans=$t->get_all_transactions($_GET["acc_id"]);
                                            ?>

                                                <div class="card text-center"><!--card text-center-->
                                                    <div class="card-header">Transaction History</div>
                                                    <div class="myDiv2"><!--background color div -->
                                                    <div class="card-body"><!--card-body-->
                                                        <form action="#" method="post">
                                                            <div class="row"><!--row-->
                                                            <?php
                                                            if($a->is_exist_account($_GET["acc_id"])){

                                                                $trans=$t->get_all_transactions($_GET["acc_id"]);

                                                            ?>
                                                                <div class="col-md-12">
                                                                <table id="example1" class="table table-responsive table-bordered table-striped">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Trans ID</th>
                                                                        <th>Date</th>
                                                                        <th>Account Number</th>
                                                                        <th>Debit</th>
                                                                        <th>Credit</th>
                                                                        <th>Balance</th>
                                                                        
                                                                    </tr>
                                                                    </thead>
                                                                <?php    
                                                                foreach($trans as $item)
                                                                {
                                                                    echo"
                                                                    <tr>
                                                                        <td>$item->trans_id</td>
                                                                        <td>$item->trans_date</td>
                                                                        <td>$item->acc_id</td>
                                                                        <td>$item->debit</td>
                                                                        <td>$item->credit</td>
                                                                        <td>$item->balance</td>
                                                                    </tr>
                                                                    
                                                                    ";
                                                                }
                                                                
                                                                    
                                                                ?>    
                                                                    <tfoot>
                                                                    <tr>
                                                                        <th>Trans ID</th>
                                                                        <th>Date</th>
                                                                        <th>Account Number</th>
                                                                        <th>Debit</th>
                                                                        <th>Credit</th>
                                                                        <th>Balance</th>
                                                                    </tr>
                                                                    </tfoot>
                                                                    
                                                                    </table>
                                                                </div>
                                                            <?php
                                                            }else{
                                                                ?>
                                                            
                                                            </div><!--row-->

                                                        </form>
                                                        <div class="alert alert-danger" role="alert">Account does not exist. please enter valid account number ! 
                                                        </div>
                                                            <?php
                                                            } // end of the else
                                                            ?>
                                                        <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"> <!--back button-->
                                                        <div class="myDiv2"><!--/background color div --> 
                                                    </div><!--/card-body-->
                                                </div><!--/card text-center--> 
                                                
                                                
                                            <?php                                       
                                        break;
                                        
                                        case "date_picker": 
                                            $acc_id=$_GET["acc_id"];                                            
                                            ?>
                                            
                                                <div class="card text-center">
                                                    <div class="card-header">Account history between two days.</div><!--Account Balance-->
                                                    <div class="myDiv2"><!--background color div -->
                                                    
                                                    <div class="card-body" style="text-align:center;"><!--card-body-->
                                                    <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <h5><u>Pleace select you want to date range.</u></h5>
                                                        </div>
                                                        
                                                        <div class="form-group col-md-1">
                                                            <label>From:</label>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <input class='form-control no-controls' type='date'   name='from' >
                                                        </div>
                                                        <div class="form-group col-md-1">
                                                            <label>To:</label>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <input class='form-control no-controls' type='date'   name='to' >
                                                        </div>
                                                        <div class='form-group col-md-2 search_trans_his btn btn-success btn-sm' data-type='search_history_btwn_two_days' data-value="">Search</div>
                                                        
                                                    </div><!--/card-body-->
                                                    </div><!--/background color div -->
                                                </div> 
                                               
                                            <?php                                       
                                        break; 

                                        case "search_history_btwn_two_days": 
                                           $acc_id=$_GET["acc_id"];
                                           $from_date=$_GET["from"];                                     
                                           $to_date=$_GET["to"];  
                                           
                                           include_once "class/c_transaction.php";
                                           $t=new transaction();

                                           if($t->is_exist_transaction_between_two_days($from_date,$to_date,$acc_id))
                                           {
                                            $alltrans=$t->get_transaction_between_two_days($from_date,$to_date,$acc_id); //get all trnsaction between two days


                                            ?>
                                            
                                                <div class="card text-center">
                                                    <div class="card-header">Account history between two days.</div><!--Account Balance-->
                                                    <div class="myDiv2"><!--background color div -->
                                                    <div class="card-body"><!--card-body-->

                                                    <div class="col-md-12">
                                                        <table id="example1" class="table table-responsive table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                            <th>Trans ID</th>
                                                            <th>Date</th>
                                                            <th>Account Number</th>
                                                            <th>Debit</th>
                                                            <th>Credit</th>
                                                            <th>Balance</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php

                                                            foreach ($alltrans as $item) {

                                                            echo "  
                                                                <tr>
                                                                    <td>$item->trans_id</td>
                                                                    <td>$item->trans_date</td>
                                                                    <td>$item->acc_id</td>
                                                                    <td>$item->debit</td>
                                                                    <td>$item->credit</td>
                                                                    <td>". "LKR. " . number_format($item->balance,2 , ".", ",") ."</td>
                                                                  
                                                                    
                                                                ";
                                                            }

                                                            ?>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                            <th>Trans ID</th>
                                                            <th>Date</th>
                                                            <th>Account Number</th>
                                                            <th>Debit</th>
                                                            <th>Credit</th>
                                                            <th>Balance</th>
                                                            </tr>
                                                        
                                                        </table>
                                                    </div>
                                                    <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"> <!--back button-->
                                                    
                                                     
                                                    </div><!--/card-body-->
                                                    </div><!--/background color div -->
                                                </div> 
                                               
                                            <?php
                                           }else{ // if not exist transaction between two days.
                                               ?>
                                                  <div class="card text-center">
                                                    <div class="card-header">Account history between two days.</div><!--Account Balance-->
                                                    <div class="myDiv2"><!--background color div -->
                                                    <div class="card-body" style="text-align:center;"><!--card-body-->
                                                    <h1 style="color:red"><b>Not exist transaction between two days !</b></h1>
                                                    <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"> <!--back button-->

                                                     
                                                    </div><!--/card-body-->
                                                    </div><!--/background color div -->
                                                </div> 

                                               <?php
                                           }                                       
                                        break; 

                                        default:
                                            ?>

                                            <div class="alert alert-danger" role="alert">Invalid Request !</div>
                                                
                                            <?php  
                                    }
                                }else{
                                    ?>

                                    <div class="alert alert-danger" role="alert">Invalid account number or invalid request.please enter numeric account number !</div>
                                    
                                    <?php
                                }
                            }

                           
                        ?>
                    </div>    
                </div>
      </div><!--/container-fluid -->
    </section>

    <script>
        $(document).ready(function(){
            $(".sbmt").click(function(){
                // $(this).data("type")

                //If account number is valid
                let url = window.location.href.split('?')[0] + "?type=" + $(this).data("type") + "&acc_id="+ $("input[name=acc_id]").val();
                window.location.href= url;
                
            });

            $(".search_trans_his").click(function(){
                // $(this).data("type")

                //If account number is valid
                let url = window.location.href.split('?')[0] + "?type=" + $(this).data("type") + "&acc_id="+ $(this).data("value") + $("input[name=acc_id]").val() + "&from="+ $("input[name=from]").val() + "&to="+ $("input[name=to]").val();
                window.location.href= url;
                
            });
        });
    </script>


<?php include"footer.php"; ?>
            
                

                
            

    

        

