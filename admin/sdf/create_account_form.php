<?php 
include "header.php";
include "sidebar.php"; 

 include "class/c_account.php";
 include "class/c_customer.php";
 include "class/c_account_type.php";
 include "class/c_transaction.php";
 $ac = new account();
 $c = new customer();
 $at = new account_type();
 $t=new transaction();
 $t2=new transaction();
 
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
    <section class="content-header">
      <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Create Account</h3>
                </div><!-- /card-header -->
                <!--card body -->
                <div class="card-body">
                    <form action="create_account_form.php" method="POST">  
                        <div class="row">
                        <?php
                        if(isset($_POST["submit"])){

                            if(check_nic_num($_POST["nic"])){
                                $at->get_account_type($_POST["account_type"]);
                                if($_POST["deposit"]>=$at->open_amount){ //check whether deposit amount is sufficient open this type of account.
                                    if($c->is_exist_customer($_POST["nic"])){ // check whether person information already exist in database


                                        //create account number
                                        $branch_id=$_SESSION["uu"]['branch_id'];
                                        $branch_code=str_pad($branch_id, 3, '0', STR_PAD_LEFT);
                                        $bank_code="007";

                                        $acnt=new account;

                                        if($acnt->last_include_Acc()){//check whether last include account number available?

                                            $last_include_full_acc_num=$acnt->acc_id;
                                            $only_acc_num = substr($last_include_full_acc_num, -7); //without branch and bank code
                                            $new_only_acc_num=$only_acc_num+1;
                                            $new_only_acc_num=str_pad($new_only_acc_num, 7, '0', STR_PAD_LEFT);
                                            $new_full_acc_num=$bank_code.$branch_code.$new_only_acc_num;
                                            $new_full_acc_num_int=(int)$new_full_acc_num;



                                            //$ac->acc_id=$new_full_acc_num;
                                         

                                        }else{

                                            $new_only_acc_num=str_pad("1", 7, '0', STR_PAD_LEFT);
                                            $new_full_acc_num=$bank_code.$branch_code.$new_only_acc_num;
                                            $new_full_acc_num_int=(int)$new_full_acc_num;

                                            //$ac->acc_id=$new_full_acc_num;


                                        }

                                        $ac->acc_type      = $_POST["account_type"];
                                        $ac->cus_id        = $_POST["nic"];
                                        $ac->branch_id     = $_SESSION["uu"]['branch_id'];
                                        
                                        // $c->get_customer($_POST["nic"]);

                                        $c->cus_id         = $_POST["nic"];
                                        $c->cus_first_name = $_POST["f_name"];
                                        $c->cus_last_name  = $_POST["l_name"];
                                        $c->cus_full_name  = $_POST["full_name"];
                                        $c->cus_address    = $_POST["address"];
                                        $c->cus_telephone  = $_POST["telephone"];
                                        $c->cus_email      = $_POST["email"];
                                        $c->cus_gender     = $_POST["gender"];
                                        $c->cus_dob        = $_POST["dob"];
                                        $c->branch_id      = $_SESSION["uu"]['branch_id']; // Currently login branch user

                                        $ac->registerAcc($new_full_acc_num_int); 
                                        $c->update_customer();

                                        // debit the amount deposit table and transaction table
                                        $accLast=new account();
                                        $accLast->last_include_Acc();
                                        $t->acc_id=$accLast->acc_id;
                                        $t->deposit_branch=$_SESSION["uu"]['branch_id'];
                                        $t->debit=$_POST["deposit"];
                                        $t->note="open_account";
                                        $t->deposit();

                                        ?>
                                        <div class="alert alert-success form-group col-md-12" role="alert">
                                        Success!
                                        </div>
                                        <?php
                                        // show last create account details
                                        $c2=new customer();
                                        $c2->get_customer($c->cus_id);
                                        $acc = new account();
                                        $acc->last_include_Acc();
                                        $ac->get_account($acc->acc_id);
                                        ?>
                                        <div class="col-md-12">
                                            <table class="responsive w-100">
                                            <tr>
                                                <td><b>Account ID:</b></td>
                                                <td><?php echo $ac->acc_id; ?></td>
                                                <td><b>Account Type:</b></td>
                                                <td><?php echo $ac->acc_type; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Account Status:</b></td>
                                                <td><b><?php echo "<span style='color:#2ab71e'>$ac->acc_status</span>" ?><b></td>
                                                <td><b>Opened Date:</b></td>
                                                <td><?php echo $ac->acc_created_date; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Account Balance:</b></td>
                                                <td><?php echo "LKR. " . number_format($ac->acc_balance,2 , ".", ","); ?></td>
                                                <td><b>Customer NIC:</b></td>
                                                <td><?php echo $c2->cus_id; ?>V</td>
                                            </tr>
                                            <tr>
                                                <td><b>Customer Name:</b></td>
                                                <td><?php echo $c2->cus_full_name  ?></td>
                                                <td><b>Customer Address:</b></td>
                                                <td><?php echo $c2->cus_address; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Customer Telephone:</b></td>
                                                <td><?php echo $c2->cus_telephone; ?></td>
                                                <td><b>Customer Email:</b></td>
                                                <td><?php echo $c2->cus_email; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Gender:</b></td>
                                                <td><?php echo $c2->cus_gender; ?></td>
                                                <td><b>Date of birth:</b></td>
                                                <td><?php echo $c2->cus_dob; ?></td>
                                            </tr>
                                        </table>    </div>
                                        <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-2);"><!--back button-->


                                        
                                            

                                        <?php
                                    }else{ // end is_exist_customer($_POST["nic"])


                                        //create account number
                                        $branch_id=$_SESSION["uu"]['branch_id'];
                                        $branch_code=str_pad($branch_id, 3, '0', STR_PAD_LEFT);
                                        $bank_code="007";

                                        $acnt=new account;

                                        if($acnt->last_include_Acc()){//check whether last include account number available?

                                            $last_include_full_acc_num=$acnt->acc_id;
                                            $only_acc_num = substr($last_include_full_acc_num, -7); //without branch and bank code
                                            $new_only_acc_num=$only_acc_num+1;
                                            $new_only_acc_num=str_pad($new_only_acc_num, 7, '0', STR_PAD_LEFT);
                                            $new_full_acc_num=$bank_code.$branch_code.$new_only_acc_num;
                                            $new_full_acc_num_int=(int)$new_full_acc_num;

                                            //$ac->acc_id=$new_full_acc_num;

                                        }else{

                                            $new_only_acc_num=str_pad("1", 7, '0', STR_PAD_LEFT);
                                            $new_full_acc_num=$bank_code.$branch_code.$new_only_acc_num;
                                            $new_full_acc_num_int=(int)$new_full_acc_num;

                                            //$ac->acc_id=$new_full_acc_num;


                                        }






                                        
                                        $ac->acc_type      = $_POST["account_type"];
                                        $ac->cus_id        = $_POST["nic"];
                                        $ac->branch_id     = $_SESSION["uu"]['branch_id'];
        

                                        $c->cus_id         = $_POST["nic"];
                                        $c->cus_first_name = $_POST["f_name"];
                                        $c->cus_last_name  = $_POST["l_name"];
                                        $c->cus_full_name  = $_POST["full_name"];
                                        $c->cus_address    = $_POST["address"];
                                        $c->cus_telephone  = $_POST["telephone"];
                                        $c->cus_email      = $_POST["email"];
                                        $c->cus_gender     = $_POST["gender"];
                                        $c->cus_dob        = $_POST["dob"];
                                        $c->branch_id      = $_SESSION["uu"]['branch_id']; // Currently login branch user

                                        $ac->registerAcc( $new_full_acc_num_int); 
                                        $c->registerCustomer();

                                        // debit the amount deposit table and transaction table
                                        $accLast=new account();
                                        $accLast->last_include_Acc();
                                        $t->acc_id=$accLast->acc_id;
                                        $t->deposit_branch=$_SESSION["uu"]['branch_id'];
                                        $t->debit=$_POST["deposit"];
                                        $t->note="open_account";
                                        $t->deposit();


                                        ?>
                                        <div class="alert alert-success form-group col-md-12" role="alert">
                                        Success!
                                        </div>
                                        <?php
                                        // show last create account details
                                        $c3=new customer();
                                        $c3->get_customer($c->cus_id);
                                        $acc = new account();
                                        $acc->last_include_Acc();
                                        $ac->get_account($acc->acc_id);
                                        ?>
                                    
                                        <div class="col-md-12">
                                        <table class="responsive w-100">
                                            <tr>
                                                <td><b>Account ID:</b></td>
                                                <td><?php echo $ac->acc_id; ?></td>
                                                <td><b>Account Type:</b></td>
                                                <td><?php echo $ac->acc_type; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Account Status:</b></td>
                                                <td><b><?php echo "<span style='color:#2ab71e'>$ac->acc_status</span>" ?><b></td>
                                                <td><b>Opened Date:</b></td>
                                                <td><?php echo $ac->acc_created_date; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Account Balance:</b></td>
                                                <td><?php echo "LKR. " . number_format($ac->acc_balance,2 , ".", ","); ?></td>
                                                <td><b>Customer NIC:</b></td>
                                                <td><?php echo $c3->cus_id; ?>V</td>
                                            </tr>
                                            <tr>
                                                <td><b>Customer Name:</b></td>
                                                <td><?php echo $c3->cus_full_name  ?></td>
                                                <td><b>Customer Address:</b></td>
                                                <td><?php echo $c3->cus_address; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Customer Telephone:</b></td>
                                                <td><?php echo $c3->cus_telephone; ?></td>
                                                <td><b>Customer Email:</b></td>
                                                <td><?php echo $c3->cus_email; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Gender:</b></td>
                                                <td><?php echo $c3->cus_gender; ?></td>
                                                <td><b>Date of birth:</b></td>
                                                <td><?php echo $c3->cus_dob; ?></td>
                                            </tr>
                                        </table>
                                        <div>
                                        
                                        <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-2);"><!--back button-->


                                        <?php

                                    }

                                }else{ // end $_POST["deposit"]>=$at->open_amount
                                    ?>
                                    <div class='alert alert-info form-group col-md-12' role='alert'>You should deposit at least Rs.<?php echo $at->open_amount ?>.00 for open this type of account.Please try again.</div>
                                    <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                    <?php
                                }

                                
                                
                            }else{ // check_nic_num($_POST["nic"])
                                ?>
                                    <div class='alert alert-danger form-group col-md-12' role='alert'>please Enter valid NIC Number</div>
                                <?php
                            }
  

                        }else{ //end of $_POST["nic"]
                        ?>

                            <div class="col-md-6">
                                <label for="account_category">Account Category</label>
                                <select id="account_category" name="account_category" class="form-control" required>
                                <option value="0">--Select Account Category--</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="account_type">Account type</label>
                                <select id="account_type" name="account_type" class="form-control" required>
                                <option value="0">--Select Account Type--</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>First name</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: Sathira" name="f_name" required>  
                            </div>

                            <div class="form-group col-md-6">
                                <label>Last name</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: Abayamal" name="l_name" required>  
                            </div>

                            <div class="form-group col-md-12">
                                <label>Full name with initials</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: D.M.Sathira abayamal" name="full_name" required>  
                            </div>

                            <div class="form-group col-md-6">
                                <label>Telephone</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: 071-3702242" name="telephone" required>  
                            </div>

                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: sathira@gmail.com" name="email" required>  
                            </div>

                            <div class="form-group col-md-12">
                                <label for="exampleFormControlTextarea1">Address</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Ex: Address " name="address" required></textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="#">Gender</label>
                                <select id="#" class="form-control" name="gender" required>
                                    <option selected>Choose...</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="#">NIC number</label>
                                <input type="text" class="form-control" id="#" placeholder="951710407V" name="nic" required>
                            </div>


                            <div class="form-group col-md-6">
                                <label for="#">Deposit amount</label>
                                <input type="text" class="form-control" id="#" placeholder="Ex: 50000.00" name="deposit" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="#">Date of Birth</label>
                                <input type="date" class="form-control" id="#" placeholder="1995.06.19" name="dob" required>
                            </div>

                            <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->

                            <input id="submit" class="btn btn-primary btn-sm" type="submit" name="submit" value="Create" style="margin:2px;">


                        <?php
                        }
                        ?>


                        </div>
                    </form> 

                </div><!-- /.card-body -->
                
                
            </div><!--/card card-default -->
      </div><!--/container-fluid -->
    </section>

    

        


<script>

    $(document).ready(function(){

        
        $('#submit').click(function(e){
            if($('#account_category').val() == 0){
                e.preventDefault();
                alert('Select Account category.');
            }else if($('#account_type').val() == 0){
                e.preventDefault();
                alert('Select Account Account type.');
            }
        })


        $.get("ajax.php?type=accCat",function(data){ 

            parsedData=JSON.parse(data);
            
            $.each(parsedData, function(index,accCat){
                $("#account_category").append("<option value='"+accCat['id']+"'>"+accCat['name']+"</option>");
            });
        });

        $("#account_category").change(function(event){
                // alert($(this).val());
                $("#account_type").html("<option value='0'>--Select Acc Type--</option>");
            

                $.get("ajax.php?type=accType&acc_category_id="+ $(this).val(), function(data){

                    parsedData = JSON.parse(data);

                    $.each(parsedData, function(index, accType){                    
                        $("#account_type").append("<option value='" + accType['id'] + "'>" + accType['name'] + "</option>");
                    });
                
                });         
            });
        

    });


</script>

<?php include"footer.php"; ?>
