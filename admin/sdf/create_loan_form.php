<?php
ob_start(); 
include_once "header.php"; 
include_once "sidebar.php"; 

?>  
<?php
include_once "class/c_loan.php";
include_once "class/c_customer.php";
include_once "class/c_account.php";
include_once "class/c_spouse.php";
include_once "class/c_asset.php";


function check_nic_num($number){ //check whether NIC number are valid
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
                    <h3 class="card-title">Loan application</h3>
                </div><!-- /card-header -->
                <!--card body -->
                <div class="card-body">
                    <form action="" method="POST">  
                        <div class="row">

                        <?php

                            if(isset($_POST["nic"])){

                                if(check_nic_num($_POST["nic"])){  //check valid nic number?
                                    if(check_nic_num($_POST["spouse_nic"])){ //check valid spouse nic number?
                                    $a=new account();
                                        if($a->is_exist_account_by_nic($_POST["nic"])){ //check whether customer has account
                                            $l=new loan();  
                                            $l->loan_category_id=$_POST["loan_category"];
                                            $l->cus_id=$_POST["nic"];
                                            $l->spouse_id=$_POST["spouse_nic"];
                                            $l->grtr_id=$_POST["guarantor_nic"];
                                            $l->branch_id=$_SESSION["uu"]['branch_id'];
                                            $l->loan_type_id=$_POST["loan_type"];
                                            $l->amount=$_POST["amount"];
                                            $l->repayment_period=$_POST["repayment_period"];
                                            $l->acc_id=$_POST["acc_id"];
                                            $l->purpose=$_POST["purpose"];
                                            $l->save_loan();

                                            $cust=new customer();

                                            $cust->cus_id=$_POST["nic"];
                                            $cust->cus_first_name=$_POST["f_name"];
                                            $cust->cus_last_name=$_POST["l_name"];
                                            $cust->cus_full_name=$_POST["full_name"];
                                            $cust->cus_age=$_POST["age"];
                                            $cust->cus_designation=$_POST["occupation"];
                                            $cust->cus_designation_state=$_POST["occupation_state"];
                                            $cust->cus_monthely_income=$_POST["income"];
                                            $cust->cus_address=$_POST["address"];
                                            $cust->cus_telephone=$_POST["telephone"];
                                            $cust->cus_email=$_POST["email"];
                                            $cust->cus_gender=$_POST["gender"];
                                            $cust->cus_dob=$_POST["dob"];
                                    
                                            $cust->update_customer(); //update customer row

                                            /////Spouse
                                            $spouse=new spouse();
                                            if($spouse->is_exist_spouse($_POST["spouse_nic"]))//check spouse is exist
                                            {
                                                $spouse->spouse_id=$_POST["spouse_nic"];
                                                $spouse->name=$_POST["spouse_full_name"];
                                                $spouse->address=$_POST["spouse_address"];
                                                $spouse->occupation=$_POST["spouse_occupation"];
                                                $spouse->update_spouse();

                                            }else{ // spouse is not in table
                                                    $spouse->spouse_id=$_POST["spouse_nic"];
                                                    $spouse->name=$_POST["spouse_full_name"];
                                                    $spouse->address=$_POST["spouse_address"];
                                                    $spouse->occupation=$_POST["spouse_occupation"];

                                                    $spouse->registerSpouse();
                                            }

                                            ///////Asset
                                            $asset=new asset();
                                            if($asset->is_exist_asset($_POST["nic"])){//check asset is exist
                                            
                                                //if asset is exist update row
                                                $asset->cus_id                     =$_POST["nic"];
                                                $asset->immovable_properties       =$_POST["immovable_properties"];
                                                $asset->movable_properties         =$_POST["movable_properties"];
                                                $asset->any_other_assets           =$_POST["any_other_assets"];
                                                $asset->guarantees_on_behalf       =$_POST["guarantees_on_behalf"];
                                                $asset->security_offered           =$_POST["security_offered"];
                                        
                                                $asset->update_asset();
                                                header("location:guarantor_form.php");

                                            }else{ // if asset is not exist in table save the asset

                                                $asset->cus_id                     =$_POST["nic"];
                                                $asset->immovable_properties       =$_POST["immovable_properties"];
                                                $asset->movable_properties         =$_POST["movable_properties"];
                                                $asset->any_other_assets           =$_POST["any_other_assets"];
                                                $asset->guarantees_on_behalf       =$_POST["guarantees_on_behalf"];
                                                $asset->security_offered           =$_POST["security_offered"];
                                        
                                                $asset->save_asset();
                                                header("location:guarantor_form.php");
                                            }

                                        }else{
                                            ?>
                                            <div class='alert alert-danger form-group col-md-12' role='alert'>Customer Doesn't Have Account</div>
                                            <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                            
                                            
                                            <?php
                                        }
                
                                    }else{//!check valid spouse nic number?

                                        ?>
                                        <div class='alert alert-danger form-group col-md-12' role='alert'>Please Enter Valid Spouse NIC Number</div>
                                        <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                        <?php

                                    }
                                }else{ //!check valid nic number?
                                    ?>
                                    <div class='alert alert-danger form-group col-md-12' role='alert'>Please Enter Valid Applicant NIC Number</div>
                                    <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                    <?php
                                }





                            }else{
    

                            ?>
                            <div class="col-md-6">
                                <label for="loan_category">Loan Category</label>
                                <select id="loan_category" name="loan_category" class="form-control" required>
                                <option value="0">--Select Loan Category--</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="loan_type">Loan type</label>
                                <select id="loan_type" name="loan_type" class="form-control" required>
                                <option value="0">--Select Loan Type--</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>First name</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: Sathira" name="f_name" required>  
                            </div>

                            <div class="form-group col-md-4">
                                <label>Last name</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: Abayamal" name="l_name" required>  
                            </div>

                            <div class="form-group col-md-4">
                                <label>Full name with initials</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: D.M.Sathira abayamal" name="full_name" required>  
                            </div>

                            

                            <div class="form-group col-md-4">
                                <label for="#">Occupation/Business</label>
                                <input type="text" class="form-control" id="#" placeholder="Bank officer" name="occupation" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="#">Occupation state whether</label>
                                <select id="#" class="form-control" name="occupation_state" required>
                                    <option selected>Choose...</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="notconfirmed">Not-Confirmed</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="#">NIC number</label>
                                <input type="text" class="form-control" id="#" placeholder="951710407V" name="nic" required>
                            </div>
                           
                        

                            <div class="form-group col-md-12">
                                <label for="exampleFormControlTextarea1">Address</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Ex: Address " name="address" required></textarea>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="#">Gender</label>
                                <select id="#" class="form-control" name="gender" required>
                                    <option selected>Choose...</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="#">Date of Birth</label>
                                <input type="date" class="form-control" id="#" placeholder="1995.06.19" name="dob" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="#">Age</label>
                                <input type="datetime-local" class="form-control" id="#" placeholder="25" name="age" required> 
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
                            <br>
                            <hr class="style1">
                            <br>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Name of spouse</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: wishwa madubashana" name="spouse_full_name" required>  
                            </div>

                            <div class="form-group col-md-3">
                                <label>Telephone of spouse</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: 077-9568898" name="spouse_telephone" required>  
                            </div>

                            <div class="form-group col-md-3">
                                <label>NIC of spouse</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: 951745835V" name="spouse_nic" required>  
                            </div>

                            <div class="form-group col-md-3">
                                <label>Occupation/business of spouse</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: Teacher" name="spouse_occupation" required>  
                            </div>

                            <div class="form-group col-md-12">
                                <label for="exampleFormControlTextarea1">Address of spouse</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Ex: Address " name="spouse_address" required></textarea>
                            </div>

                            <div class="form-group col-md-12">
                            <br>
                            <hr class="style1">
                            <br>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Amount of Loan Required(RS.)</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: 100000.00" name="amount" required>  
                            </div>

                            <div class="form-group col-md-4">
                                <label>Repayment period(Months)</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: 12 month" name="repayment_period" required>  
                            </div>

                            <div class="form-group col-md-4">
                                <label>Saving A/C Number</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: 2" name="acc_id" required>  
                            </div>

                            <div class="form-group col-md-12">
                                <label for="exampleFormControlTextarea1">Purpose</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Ex: Address" name="purpose" required></textarea>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Total monthely income</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: 100000.00" name="income" required>  
                            </div>
                            <div class="form-group col-md-4">
                                <label>Guarantor Nic</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="951710525" name="guarantor_nic" required>  
                            </div>

                            <div class="form-group col-md-8">      
                            </div>

                            <div class="form-group col-md-12">
                            <br>
                            <hr class="style1">
                            <br>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="exampleFormControlTextarea1" >Immovable Properties(including land,house,building)</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Name | Location | Extent | Approx.value | Mortgages" name="immovable_properties" required></textarea>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="exampleFormControlTextarea1">Movable Properties(including Vehicles)</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Description | Reg No | Approx.value" name="movable_properties" required></textarea>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="exampleFormControlTextarea1">Any Other Assets(including insurance policies & Fixed Deposits)</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Description | Reg No | Approx.value" name="any_other_assets" required></textarea>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="exampleFormControlTextarea1">Guarantees on behalf of 3rd parties</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Note" name="guarantees_on_behalf" required></textarea>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="exampleFormControlTextarea1">Security offered(State full details of properties given as security & name & Address of Gurentors)</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Note" name="security_offered" required></textarea>
                            </div>

                            

                            
                            <input id="submit" class="btn btn-primary btn-sm" type="submit" name="submit" value="Next">     
                            
                            
                            <?php    
                            }       // Main else
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

    <script>

$(document).ready(function(){


    $('#submit').click(function(e){
            if($('#loan_category').val() == 0){
                e.preventDefault();
                alert('Select loan category.');
            }else if($('#loan_type').val() == 0){
                e.preventDefault();
                alert('Select loan type.');
            }
        })




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

 

        




<?php include"footer.php"; ?>
