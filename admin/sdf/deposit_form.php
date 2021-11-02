<?php include"header.php"; ?>
<?php include"sidebar.php"; ?>
<?php

include "class/c_transaction.php";
include "class/c_account.php";

$d=new transaction();
$d2=new transaction();
$a=new account();

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
                    <h3 class="card-title">Deposit</h3>
                </div><!-- /card-header -->
                <!--card body -->
                <div class="card-body">
                    <form action="deposit_form.php" method="post">         
                        <div class="row">
                        <?php
                        if(isset($_POST["submit"])){
                            if(!empty($_POST["acc_id"]) && !empty($_POST["debit"]) && !empty($_POST["re_debit"])){
                                if(!check_acc_num($_POST["acc_id"]))
                                {
                                    ?><div class='alert alert-danger form-group col-md-12' role='alert'>Invalid Account Number! please enter valid account number.</div>
                                     <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                    
                                    <?php
                                }elseif(!check_amount_num($_POST["debit"]) || !check_amount_num($_POST["re_debit"])){
                                    ?><div class='alert alert-danger form-group col-md-12' role='alert'>Invalid Amount! please enter numeric amount</div>
                                   <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                    
                                    <?php
                                }elseif(!$a->is_active_account($_POST["acc_id"]) && !$a->is_hold_account($_POST["acc_id"]) ){ //check whether account is active or not
                                    ?><div class='alert alert-danger form-group col-md-12' role='alert'>Doesn't have account! Please enter valid account number.</div>
                                     <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                    
                                    <?php
                                }elseif($_POST["debit"] != $_POST["re_debit"]){
                                    ?><div class='alert alert-danger form-group col-md-12' role='alert'>Amount Does not match !</div>
                                    <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                    
                                    <?php
                                }else
                                {

                                    // debit the amount saving account
                                    $d->acc_id=$_POST["acc_id"];
                                    $d->deposit_branch=$_SESSION["uu"]["branch_id"];
                                    $d->special_note=$_POST["note"];
                                    $d->debit=$_POST["debit"];
                                    $d->note="customer_deposit";
                                    $d->deposit();


                                    ?><div class="alert alert-success form-group col-md-12" role="alert">
                                    Deposit successfull!
                                  </div>
                                  <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-4);"><!--back button-->
                                  
                                  
                                  <?php
                                  
                                }
                            }else
                            {
                                ?><div class='alert alert-danger form-group col-md-12' role='alert'>Please fill the all texboxes</div>
                                <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-4);"><!--back button-->
                                <?php
                                 
                            }
                        
                        }else{  // end of main else


                        ?>
                        
                            <div class="form-group col-md-4">
                                <label>Account Number</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: 011-5-002-4456385" name="acc_id" value="<?php if (isset($_GET['acc_no'])){echo $_GET['acc_no'];} ?>" required>  
                            </div>

                            <div class="form-group col-md-4">
                                <label>Transaction Amount</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: 50000.00" name="debit" required>  
                            </div>

                            <div class="form-group col-md-4">
                                <label>Re Enter Amount</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: 50000.00" name="re_debit" required>  
                            </div>

                            <div class="form-group col-md-12">
                                <label for="exampleFormControlTextarea1">Narration</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Ex: Note " name="note"></textarea>
                            </div>

                            <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                            
                            <input class="btn btn-primary btn-sm" type="submit" value="Deposit" name="submit" style="margin:2px;">

                    </div> <!--row--> 
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

