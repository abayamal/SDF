<?php include"header.php"; ?>
<?php include"sidebar.php"; ?>
<?php

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

include "class/c_staff.php";

  $s=new staff();


 
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Add staff</h3>
                </div><!-- /card-header -->
                <!--card body -->
                <div class="card-body">        
                    <form action="add_staff_form.php" method="post">
                        <div class="row">
                        <?php
                        if(isset($_POST["NIC"])){
                            if(!empty($_POST["designation"]) && !empty($_POST["branch_id"]) && !empty($_POST["first_name"]) && !empty($_POST["last_name"]) && !empty($_POST["Full_name"]) && !empty($_POST["Address"]) && !empty($_POST["Contact_number"]) && !empty($_POST["Email"]) && !empty($_POST["Gender"]) && !empty($_POST["Date_Of_Birth"]) && !empty($_POST["User_name"]) && !empty($_POST["Password"]) && !empty($_POST["confirm_password"]) ){

                                if(check_nic_num($_POST["NIC"])){
                                    if(!$s->is_exist_staff($_POST["NIC"])){
                                        if($_POST["Password"]==$_POST["confirm_password"]){
                                            
                                                    $s->stf_id                   = $_POST["NIC"];
                                                    $s->stf_designation          = $_POST["designation"];
                                                    $s->branch_id                = $_POST["branch_id"];
                                                    $s->stf_experienced                = $_POST["experienced"];
                                                    $s->stf_first_name           = $_POST["first_name"];
                                                    $s->stf_last_name            = $_POST["last_name"];
                                                    $s->stf_full_name            = $_POST["Full_name"];
                                                    $s->stf_address	             = $_POST["Address"];
                                                    $s->stf_telephone	         = $_POST["Contact_number"];
                                                    $s->stf_email	             = $_POST["Email"];
                                                    $s->stf_gender	             = $_POST["Gender"];
                                                    $s->stf_age	                 = $_POST["age"];
                                                    $s->stf_dob	                 = $_POST["Date_Of_Birth"];
                                                    $s->stf_username	         = $_POST["User_name"];
                                                    $s->stf_password	         = md5($_POST["Password"]);

                                                    $s->save_staff();

                                                    ?>
                                                        <div class="alert alert-success form-group col-md-12" role="alert">
                                                        Add staff Successfully!
                                                        </div>
                                                        <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                                    <?php


                                        } else{ // end of $_POST["Password"]==$_POST["confirm_password"]
                                            ?>
                                            <div class='alert alert-danger form-group col-md-12' role='alert'>Passwords are not match</div>
                                        <?php
                                        }

                                    }else{ // if a person already exist database

                                            if($_POST["Password"]==$_POST["confirm_password"]){ // check whether passwords ara match

                                                    $s->stf_id                   = $_POST["NIC"];
                                                    $s->stf_designation          = $_POST["designation"];
                                                    $s->branch_id                = $_POST["branch_id"];
                                                    $s->stf_experienced                = $_POST["experienced"];
                                                    $s->stf_first_name           = $_POST["first_name"];
                                                    $s->stf_last_name            = $_POST["last_name"];
                                                    $s->stf_full_name            = $_POST["Full_name"];
                                                    $s->stf_address	             = $_POST["Address"];
                                                    $s->stf_telephone	         = $_POST["Contact_number"];
                                                    $s->stf_email	             = $_POST["Email"];
                                                    $s->stf_gender	             = $_POST["Gender"];
                                                    $s->stf_age	                 = $_POST["age"];
                                                    $s->stf_dob	                 = $_POST["Date_Of_Birth"];
                                                    $s->stf_username	         = $_POST["User_name"];
                                                    $s->stf_password	         = md5($_POST["Password"]);

                                                    $s->edit_staff();

                                                    ?>
                                                        <div class="alert alert-success form-group col-md-12" role="alert">
                                                        Success!
                                                        </div>
                                                        <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                                    <?php


                                            }else{ // end of $_POST["Password"]==$_POST["confirm_password"]
                                                ?>
                                                <div class='alert alert-danger form-group col-md-12' role='alert'>Passwords are not match</div>
                                                <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                                <?php
                                            }

                                        
                                    }

                                }else{ // end check_nic_num($_POST["NIC"])
                                        ?>
                                            <div class='alert alert-danger form-group col-md-12' role='alert'>Plese Enter valid NIC Number</div>
                                            <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                        <?php
                                }
                            }else{ // end of check whether fill all text areas
                                ?>
                                <div class='alert alert-danger form-group col-md-12' role='alert'>Please fill the all text areas.</div>
                                <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                <?php
                            }

                        }else{  //end of mail else
                        ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label>Designation</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex:Manager" name="designation" required>  
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="branch_id">Branch</label>
                                <select id="branch_id" name="branch_id" class="form-control">
                                    <option value="0">--select branch--</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="branch_id">Experienced</label>
                                <select id="experienced" name="experienced" class="form-control">
                                    <option value="0">--select branch--</option>
                                    <option value="1">--1 year--</option>
                                    <option value="2">--2 year--</option>
                                    <option value="3">--3 year--</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                <label>First name</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex:Dian" name="first_name" required>  
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                <label>Last name</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex:perera" name="last_name" required>  
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                <label>Full name</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: k.Dian perera" name="Full_name" required>  
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                <label>NIC</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: 951724525V" name="NIC" required>  
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                <label for="exampleFormControlTextarea1">Address</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Ex: Kandy" name="Address" required></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                <label>Contact number</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: 072-6598864" name="Contact_number" required>  
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: dian@gmail.com" name="Email" required>   
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="inputState">Gender</label>
                                <select id="inputState" class="form-control" name="Gender">
                                    <option selected>Male</option>
                                    <option>Female</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                <label>Date Of Birth</label>
                                <input type="date" class="form-control select2" style="width: 100%" name="Date_Of_Birth" required>  
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                <label>Age</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: 25" name="age" required>  
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                <label>User name</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: Dian" name="User_name" required>  
                                </div>
                            </div>

                            <div class="col-md-3">
                            <label for="password">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="Password" placeholder="Ex: 123" required>
                                    <div class="input-group-append">
                                    <i class="far fa-eye input-group-text" id="eye"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                            <label for="password">Confirm Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Ex: 123" required>
                                    <div class="input-group-append">
                                    <i class="far fa-eye input-group-text" id="eyeConfirm"></i>
                                    </div>
                                </div>
                            </div>

                            

                            <!-- <div class="col-md-3">
                                <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" class="form-control select2" style="width: 100%" placeholder="Ex: 123" name="confirm_password" required>  
                                </div>
                            </div> -->

                            <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                            <input class="btn btn-primary btn-sm" id="submit"type="submit" value="Add Staff" style="margin:2px;"><!--add staff button-->
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
<script src="js/passwordHide.js"></script>
<script>
  $(document).ready(function(){

    $('#submit').click(function(e){
            if($('#branch_id').val() == 0){
                e.preventDefault();
                alert('Select branch.');
            }
        })






    $.get("ajax.php?branch_id=branch",function(data){
      
      parsedData=JSON.parse(data);


        $.each(parsedData,function(index,branch){
          $("#branch_id").append("<option value='"+ branch['id'] + "'>"+ branch['name'] + "</option>");

        });
    });



  });


</script>


<?php include"footer.php"; ?>




    

        

