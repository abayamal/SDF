<?php 
ob_start(); 
include "header.php"; 
include "sidebar.php"; 
?>     
<?php

include "class/c_guarantor.php";
include "class/c_asset.php";
include "class/c_loan.php";


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
                    <h3 class="card-title">Guarantor's Statement</h3>

                </div><!-- /card-header -->
                <!--card body -->
                <div class="card-body">
                    <form action="" method="POST">  
                        <div class="row">

                        <?php

                            if(isset($_POST["guarantor_nic"])){
                                if(check_nic_num($_POST["guarantor_nic"])){ //check valid nic number?

                                    //check whether guarantor nic equal to previous page entered guarantor nic
                                        $lastloan=new loan();
                                        $lastloan->last_include_loanAcc();
                                        $lastLoanNo=$lastloan->loan_no;
                                        $loan=new loan();
                                        $loan->get_loan_account_loanNo($lastLoanNo);
                                      
                                    if($loan->grtr_id==$_POST["guarantor_nic"]){
                                        if(check_nic_num($_POST["spouse_nic"])){ //check spouse nic number valid
                                            $spouse=new spouse();
                                            if($spouse->is_exist_spouse($_POST["spouse_nic"])){// check spouse is exist in table(spouse alredy in the table it should be update)

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
                                                /////////////Assets
                                                $asset=new asset();
                                                if($asset->is_exist_asset($_POST["guarantor_nic"])){//check asset is exist
                                                
                                                    //if asset is exist, update row
                                                    $asset->cus_id                     =$_POST["guarantor_nic"];
                                                    $asset->immovable_properties       =$_POST["immovable_properties"];
                                                    $asset->movable_properties         =$_POST["movable_properties"];
                                                    $asset->any_other_assets           =$_POST["any_other_assets"];
                                                    $asset->guarantees_on_behalf       =$_POST["guarantees_on_behalf"];
                                                   
                                            
                                                    $asset->update_asset();
                                                    
                                                }else{ // if asset is not exist in table save the asset

                                                    $asset->cus_id                     =$_POST["guarantor_nic"];
                                                    $asset->immovable_properties       =$_POST["immovable_properties"];
                                                    $asset->movable_properties         =$_POST["movable_properties"];
                                                    $asset->any_other_assets           =$_POST["any_other_assets"];
                                                    $asset->guarantees_on_behalf       =$_POST["guarantees_on_behalf"];
                                                    
                                            
                                                    $asset->save_asset();
                                                   
                                                }
                                                ///////Guarantor
                                                $guarantor=new guarantor();
                                                if($guarantor->is_exist_guarantor($_POST["guarantor_nic"])){//check whether guaranter is exist table  

                                                    $guarantor->grtr_id=$_POST["guarantor_nic"];
                                                    $guarantor->grtr_first_name=$_POST["f_name"];
                                                    $guarantor->grtr_last_name=$_POST["l_name"];
                                                    $guarantor->grtr_full_name=$_POST["full_name"];
                                                    $guarantor->grtr_designation=$_POST["Occupation"];
                                                    $guarantor->grtr_designation_state=$_POST["Occupation_state"];
                                                    $guarantor->grtr_monthely_income=$_POST["income"];
                                                    $guarantor->grtr_address=$_POST["address"];
                                                    $guarantor->grtr_telephone=$_POST["telephone"];
                                                    $guarantor->grtr_email=$_POST["email"];
                                                    $guarantor->grtr_gender=$_POST["gender"];
                                                    $guarantor->grtr_dob=$_POST["dob"];

                                                    $guarantor->update_guarantor(); 

                                                }else{ // Guarantor does not exist table
                                                    
                                                    $guarantor->grtr_id=$_POST["guarantor_nic"];
                                                    $guarantor->grtr_first_name=$_POST["f_name"];
                                                    $guarantor->grtr_last_name=$_POST["l_name"];
                                                    $guarantor->grtr_full_name=$_POST["full_name"];
                                                    $guarantor->grtr_designation=$_POST["Occupation"];
                                                    $guarantor->grtr_designation_state=$_POST["Occupation_state"];
                                                    $guarantor->grtr_monthely_income=$_POST["income"];
                                                    $guarantor->grtr_address=$_POST["address"];
                                                    $guarantor->grtr_telephone=$_POST["telephone"];
                                                    $guarantor->grtr_email=$_POST["email"];
                                                    $guarantor->grtr_gender=$_POST["gender"];
                                                    $guarantor->grtr_dob=$_POST["dob"];

                                                    $guarantor->save_guarantor();

                                                }
                                                //update gurantor's spouse nic in loan table
                                                $loan2=new loan();
                                                $loan2->g_spouse_id=$_POST["spouse_nic"];
                                                $loan2->update_g_spouse_id_loan_tbl();

                                                header("location:view_loan_details.php");


                                        }else{

                                            ?>
                                            <div class='alert alert-danger form-group col-md-12' role='alert'>Please Enter Valid Spouse Nic Number.</div>
                                            <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                            <?php
                                        }
                                    }else{
                                        ?>
                                        <div class='alert alert-danger form-group col-md-12' role='alert'>Please Enter Correct Guarantor Nic Number Previous page Entered.</div>
                                        <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                        <?php
                                    }    
                                }else{//!check valid nic number?
                                    ?>
                                    <div class='alert alert-danger form-group col-md-12' role='alert'>Please Enter valid Guarantor NIC Number</div>
                                    <?php
                                }
                                

                            }else{
                            ?>
                            <div class="form-group col-md-4">
                                <label>Guarantor's First name</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: Sathira" name="f_name" required>  
                            </div>

                            <div class="form-group col-md-4">
                                <label>Guarantor's Last name</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: Abayamal" name="l_name" required>  
                            </div>

                            <div class="form-group col-md-4">
                                <label>Guarantor's Full name with initials</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: D.M.Sathira abayamal" name="full_name" required>  
                            </div>    
                            
                            <div class="form-group col-md-4">
                                <label for="#">Occupation/Business</label>
                                <input type="text" class="form-control" id="#" placeholder="Bank officer" name="Occupation" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="#">Occupation state whether</label>
                                <select id="#" class="form-control" name="Occupation_state" required>
                                    <option selected>Choose...</option>
                                    <option value="confirm">Confirmd</option>
                                    <option value="notconfirm">Not-Confirmed</option>
                                </select>
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
                                <label for="#">NIC number</label>
                                <input type="text" class="form-control" id="#" placeholder="951710407V" name="guarantor_nic" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Telephone</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: 071-3702242" name="telephone" required>  
                            </div>
                            <div class="form-group col-md-4">
                                <label>Email</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: sathira@gmail.com" name="email" required>  
                            </div>
                            <div class="form-group col-md-4">
                                <label>Saving A/c Number(not-compalsary)</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: 071-3702242" name="acc_id">  
                            </div>
                            <div class="form-group col-md-4">
                            </div>

                            <div class="form-group col-md-12">
                                <label for="exampleFormControlTextarea1">Address</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Ex: Address " name="address" required></textarea>
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
                                <label>Occupation/business of spouse</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: Teacher" name="spouse_occupation" required>  
                            </div>

                            <div class="form-group col-md-3">
                                <label>NIC of spouse</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: 951745835V" name="spouse_nic" required>  
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
                                <label>Total Money Income</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: Teacher" name="income" required>  
                            </div>

                            <div class="form-group col-md-12">
                            <br>
                            <hr class="style1">
                            
                            </div>
                            <h6>Details of assets</h6>

                            <div class="form-group col-md-12">
                                <label for="exampleFormControlTextarea1">Immovable Properties(including land,house,building)</label>
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

                        



                            <input class="btn btn-primary btn-sm" type="submit" name="submit" value="Submit">

                        <?php    
                            }       // Main else
                        ?>    



                        </div><!--end row-->
                    </form>  

                </div><!-- /.card-body -->
                <!--card-footer --> 
                <div class="card-footer">
                                                                
                </div><!--/card-footer -->
            </div><!--/card card-default -->
      </div><!--/container-fluid -->
    </section>

    

<?php include"footer.php"; ?>
