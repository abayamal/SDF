<?php include"header.php"; ?>
<?php include"sidebar.php"; ?>
<?php

include "class/c_account.php";
$a=new account();

include_once "class/c_transaction.php";
$w=new transaction();
$w2=new transaction();

function check_acc_num($number){
    if(empty($number)){
        return false;
    }elseif(is_numeric($number)){
        return true;
    }else{
        return false;
    }
}

function check_amount_num($number){
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
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Withdraw</h3>
                </div><!-- /card-header -->
                <!--card body -->
                <div class="card-body">
                <?php
                    if(isset($_POST["submit"])){
                        if(!empty($_POST["acc_id"]) && !empty($_POST["credit"]) && !empty($_POST["re_credit"])){
                             if(check_acc_num($_POST["acc_id"])){
                                 if($a->is_exist_account($_POST["acc_id"])){
                                       if(!$a->is_hold_account($_POST["acc_id"])){
                                            
                                                if(check_amount_num($_POST["credit"])){
                                                    if(check_amount_num($_POST["re_credit"])){
                                                        if($_POST["credit"]==$_POST["re_credit"]){
                                                            if($a->account_balance_sufficient($_POST["acc_id"],$_POST["credit"])){
                                                                
                                                                //withdraw money from saving account
                                                                $w->acc_id=$_POST["acc_id"];
                                                                $w->withdraw_branch=$_SESSION["uu"]["branch_id"];
                                                                $w->special_note=$_POST["note"];
                                                                $w->credit=$_POST["credit"];
                                                                $w->re_credit=$_POST["re_credit"];
                                                                $w->note="customer_withdraw";

                                                                $w->withdraw();

                                                                ?>
                                                                    <div class="alert alert-success form-group col-md-12" role="alert">
                                                                    withdraw Successfull!</div>
                                                                    <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-4);"><!--back button-->
                                                                <?php

                                                            }else{
                                                                ?>
                                                                <div class='alert alert-danger form-group col-md-12' role='alert'>There is not sufficient balance in your account to withdraw money!</div>
                                                                <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                                                <?php
                                                            }

                                                        }else{ // end $_POST["credit"]==$_POST["re_credit"]
                                                            ?>
                                                                <div class='alert alert-danger form-group col-md-12' role='alert'>Amount Does Not Match!</div>
                                                                <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                                            <?php
                                                        }

                                                    }else{ //check_amount_num($_POST["re_credit"])
                                                        ?>
                                                            <div class='alert alert-danger form-group col-md-12' role='alert'>Invalid Amount! please enter numeric amount.</div>
                                                            <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                                        <?php
                                                    }

                                                }else{ // end check_amount_num($_POST["credit"])
                                                    ?>
                                                        <div class='alert alert-danger form-group col-md-12' role='alert'>Invalid Amount! please enter numeric amount.</div>
                                                        <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                                    <?php
                                                }




                                            
                                       }else{ // end !$a->is_hold_account($_POST["acc_id"])
                                           ?>
                                           <div class='alert alert-warning form-group col-md-12' role='alert'>You cannot withdraw money from this account.Your account is hold !</div>
                                           <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                           <?php
                                       }

                                 }else{ // end $a->is_exist_account($_POST["acc_id"])
                                     ?>
                                    <div class='alert alert-danger form-group col-md-12' role='alert'>The account number you entered is incorrect.Account does not exist!</div>
                                    <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                    <?php
                                 }

                             }else{ // end of check_acc_num($_POST["acc_id"])
                                 ?>
                                <div class='alert alert-danger form-group col-md-12' role='alert'>Invalid Account Number! please enter valid account number.</div>
                                <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                            <?php
                             } 
                              
                        }else{  // end !empty($_POST["acc_id"]) && !empty($_POST["credit"]) && !empty($_POST["re_credit"])
                            ?>
                            <div class='alert alert-danger form-group col-md-12' role='alert'>Please fill all text areas !</div>
                            <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                        <?php
                        }
                        
                           
                    }else{ // end of isset($_POST["submit"])

                    ?>
                    <form action="withdraw_form.php" method="post">         
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Account Number</label>
                                <input type="text" class="form-control select2" style="width: 100%" value= "<?php if (isset($_GET['acc_no'])){echo $_GET['acc_no'];} ?>" placeholder="Ex: 011-5-002-4456385" name="acc_id" required>  
                            </div>
                        
                            <div class="form-group col-md-4">
                                <label>Transaction Amount</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: 50000.00" name="credit" required>  
                            </div>

                            <div class="form-group col-md-4">
                                <label>Re Enter Amount</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: 50000.00" name="re_credit" required>  
                            </div>

                            <div class="form-group col-md-12">
                                <label for="exampleFormControlTextarea1">Note</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Ex: Note " name="note" required></textarea>
                            </div>

                            <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                            <input class="btn btn-primary btn-sm" type="submit" value="withdraw" name="submit" style="margin:2px;">


                        </div>
                    </form>


                    <?php    
                    }
                    ?>

                
                </div><!-- /.card-body -->
                <!--card-footer --> 
                <div class="card-footer">
                                                                
                </div><!--/card-footer -->
            </div><!--/card card-default -->
      </div><!--/container-fluid -->
    </section>

 <script>
  $(document).ready(function(){

    $.get("ajax.php?sdf_branch=branch",function(data){
      
      parsedData=JSON.parse(data);


        $.each(parsedData,function(index,branch){
          $("#sdf_branch").append("<option value='"+ branch['id'] + "'>"+ branch['name'] + "</option>");

        });
    });



  });


</script>   

        
<?php include"footer.php"; ?>

