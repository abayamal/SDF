<?php include"header2.php"; ?>
<?php include"sidebar2.php"; ?>
<?php

include "class/c_transaction.php";
include "class/c_account.php";
include "class/c_customer.php";

$a=new account();


$t1=new transaction();
$t2=new transaction();

function check_acc_num($number){
    if(empty($number)){
        return false;
    }elseif(!is_numeric($number)){
        return false;
    }else{
        return true;
    }
}

function check_amount_num($number){
    if(empty($number)){
        return false;
    }elseif(!is_numeric($number)){
        return false;
    }else{
        return true;
    }
}

$userID=$_SESSION["uu"]['cus_id'];



?>

      

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Fund Transfer</h3>

                </div><!-- /card-header -->
                <!--card body -->
                <div class="card-body">
                    <form action="fund_transfer_form_cus.php" method="post">         
                        <div class="row">
                        <?php
                        if(isset($_POST["submit"])){
                            if(check_acc_num($_POST["from_acc_id"]) && check_acc_num($_POST["to_acc_id"])){
                                if($a->is_exist_account($_POST["from_acc_id"])){
                                    if($a->check_account_before_transfer($_POST["from_acc_id"],$userID)){
                                        if($a->is_exist_account($_POST["to_acc_id"])){
                                            if($_POST["from_acc_id"] != $_POST["to_acc_id"]){
                                                if(check_amount_num($_POST["amount"]) && check_amount_num($_POST["re_amount"])){
                                                    if($_POST["amount"] == $_POST["re_amount"]){
                                                        if(!$a->is_hold_account($_POST["from_acc_id"])){
                                                            if($a->account_balance_sufficient($_POST["from_acc_id"],$_POST["amount"])){
                                                                $sa=new account();
                                                                $ra=new account();
                                                                $senderAcc=$sa->get_account($_POST["from_acc_id"]);
                                                                $ReceiverAcc=$ra->get_account($_POST["to_acc_id"]);

                                                                $sp=new customer();
                                                                $rp=new customer();

                                                                $sender=$sp->get_customer($senderAcc->cus_id);
                                                                $Receiver=$rp->get_customer($ReceiverAcc->cus_id);

                                                                // $t1->acc_id=$_POST["from_acc_id"];
                                                                // $t1->credit=$_POST["amount"];
                                                                // $t1->withdraw_branch=$_SESSION["uu"]["branch_id"];
                                                                // $t1->special_note=$_POST["note"];
                                                                // $t1->withdraw();

                                                                // $t2->acc_id=$_POST["to_acc_id"];
                                                                // $t2->debit=$_POST["amount"];
                                                                // $t2->deposit_branch=$_SESSION["uu"]["branch_id"];
                                                                // $t2->special_note=$_POST["note"];
                                                                // $t2->deposit();

                                                            

                                                                ?>
                                                                <table class="table table-bordered table-striped text-left">
                                                                    <tr>
                                                                        <th>Sender Details</th>
                                                                        <th>Receiver Details</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Account Number:<span id='sender_acc'><?php echo  $senderAcc->acc_id ?></span></td>
                                                                        <td>Account Number:<span id='reciever_acc'><?php echo $ReceiverAcc->acc_id?></span></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>NIC:<?php echo $sender->cus_id."V" ?></td>
                                                                        <td>NIC:<?php echo $Receiver->cus_id."V"?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Full Name:<?php echo $sender->cus_full_name ?></td>
                                                                        <td>Full Name:<?php echo $Receiver->cus_full_name?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Transfer Amount:</td>
                                                                        <td>LKR. <span id='transfer_amount'><?php echo $_POST["amount"] ?></span></td>
                                                                       
                                                                    </tr>
                                                                    

                                                                </table>
                                                                <button class="btn btn-block btn-primary" id="confirm_transfer">Confirm Transfer</button>
                                                              
                                                               

                                                                
                                                                <?php
                                                                

                                                            }else{ // end $a->account_balance_sufficient($_POST["from_acc_id"],$_POST["amount"])
                                                            ?> <div class='alert alert-danger form-group col-md-12' role='alert'>Account balance is not sufficient for transfer money !</div>
                                                            <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                                            <?php

                                                            }


                                                        }else{ // end $a->is_hold_account($_POST["from_acc_id"])
                                                        ?> <div class='alert alert-warning form-group col-md-12' role='alert'>You cannot transfer money from this account.Your account is hold !</div>
                                                        <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                                        <?php
                                                        }

                                                    }else{ // end $_POST["amount"] == $_POST["re_amount"]
                                                    ?> <div class='alert alert-danger form-group col-md-12' role='alert'>Amounts are not match.Please check and try again!</div>
                                                    <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                                    <?php

                                                    }
                                                    


                                                }else{ // end check_amount_num($_POST["amount"]) && check_amount_num($_POST["re_amount"]
                                                    ?> <div class='alert alert-danger form-group col-md-12' role='alert'>The amount numbers you entered are invalid.Please enter numeric amount numbers!</div>
                                                    <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                                    <?php
                                                }
                                                
                                            }else{ // end $_POST["from_acc_id"] != $_POST["from_acc_id"]
                                            ?>
                                            <div class='alert alert-danger form-group col-md-12' role='alert'>The two account numbers you entered are the same.Please check and try again!</div>
                                            <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                            <?php
                                            }

                                        }else{ // end $a->is_exist_account($_POST["to_acc_id"])
                                        ?>
                                        <div class='alert alert-danger form-group col-md-12' role='alert'>Sender account number is invalid.Please check and try again!</div>
                                        <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                        <?php

                                        } 
                                        
                                    }else{ // end $a->check_account_before_transfer($_POST["from_acc_id"],$_SESSION["uu"]['cus_id']
                                        ?>
                                            <div class='alert alert-danger form-group col-md-12' role='alert'>The account numbers you entered are invalid.Please enter valid account numbers!</div>
                                            <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                        <?php
                                    }   

                                }else{ // end $a->is_exist_account($_POST["from_acc_id"])
                                    ?>
                                    <div class='alert alert-danger form-group col-md-12' role='alert'>Receiver account number is invalid.Please check and try again!</div>
                                    <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                    <?php
                                }

                            }else{ // end check_acc_num($_POST["from_acc_id"]) && check_acc_num($_POST["to_acc_id"])
                                ?>
                                <div class='alert alert-danger form-group col-md-12' role='alert'>The account numbers you entered are invalid.Please enter numeric account numbers!</div>
                                <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                <?php
                            }

                        }else{ // end isset($_POST["submit"])


                        ?>

                            <div class="form-group col-md-6">
                                <label> From Account Number</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: 011-5-002-4456385" name="from_acc_id" required>  
                            </div>

                            <div class="form-group col-md-6">
                                <label> To Account Number</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: 011-5-002-4456385" name="to_acc_id" required>  
                            </div>

                        
                            <div class="form-group col-md-6">
                                <label>Transaction Amount</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: 50000.00" name="amount" required>  
                            </div>

                            <div class="form-group col-md-6">
                                <label>Re Enter Amount</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: 50000.00" name="re_amount" required>  
                            </div>

                            <div class="form-group col-md-12">
                                <label for="exampleFormControlTextarea1">Narration</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Ex: Note " name="note" required></textarea>
                            </div>
                            

                            <input class="btn btn-primary btn-sm" type="submit" value="Next" name="submit" style="margin:2px;">

                        <?php    
                        }
                        ?>
                        </div>
                    </form>
                </div><!-- /.card-body -->
                <!--card-footer --> 
                <div class="card-footer">
                                                                
                </div><!--/card-footer -->
            </div><!--/card card-default -->
      </div><!--/container-fluid -->
    </section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>

        $(document).ready(function(){
            $(".transfer").click(function(){
                // $(this).data("type")

                //If account number is valid
                let url = window.location.href.split('?')[0] + "?type=" + $(this).data("type");
                window.location.href= url;
                
            });

            $('#confirm_transfer').click(function(e){ //when button clicked
                e.preventDefault(); //don't reset page, don't do anything

                // js object that stores data to be sent
                const data ={
                    sender: $('#sender_acc').html(),
                    reciever: $('#reciever_acc').html(),
                    amount: $('#transfer_amount').html(),
                  
                }
                
                //post data with jquery
                //(url, data,).done(what should happen after posting)
                $.post("fund_transfer2.php",data).done(function(response){
                    response = JSON.parse(response); //convert respose to JSON object
                    if(response.status){
                        //what happens if succesful
                        // alert("Transfer Successful");
                        // alert(response.data.name);
                        Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Transaction successfully',
                        showConfirmButton: false,
                        timer: 1500
                        } ).then(function() {
                        window.location = "fund_transfer_form_cus.php";});
                    }else{
                        ///what happens if failed
                        // alert("Transfer Failed");
                        Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Transaction not successfully',
                        showConfirmButton: false,
                        timer: 1500
                        }).then(function() {
                        window.location = "fund_transfer_form_cus.php";});
                    }

                      
                });
            });


        });  

    </script>


        
<?php include"footer2.php"; ?>

