<?php include"header.php"; ?>
<?php include"sidebar.php"; ?>
<?php

include "class/c_staff.php";
 $s=new staff();
    

        
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Edit staff</h3>
                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                    </div><!--/card-tools-->
                </div><!-- /card-header -->
                <!--card body -->
                <div class="card-body"> 

                <?php
                if(!isset($_POST["designation"]) && isset($_GET["edit_id"])){

                    $s->get_staff($_GET["edit_id"]);
                
                ?>
                    <form action="edit_staff_form.php" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                <label>Designation</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex:Manager" name="designation" value="<?php echo $s->stf_designation?>">  
                                </div>
                            </div>


                            <div class="col-md-6">
                                <label for="branch_id">Branch</label>
                                <select id="branch_id" name="branch_id" class="form-control" value="<?php echo $s->stf_branch?>">
                                    <option value="0">--select branch--</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                <label>Full name</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: k.Dian perera" name="Full_name" value="<?php echo $s->stf_full_name?>">  
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                <label>NIC</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: 951724525V" name="NIC" value="<?php echo $s->stf_id?>">  
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                <label for="exampleFormControlTextarea1">Address</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Ex: Kandy" name="Address"><?php echo $s->stf_address?></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                <label>Contact number</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: 072-6598864" name="Contact_number" value="<?php echo $s->stf_telephone ?>">  
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: dian@gmail.com" name="Email" value="<?php echo $s->stf_email?>">  
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="inputState">Gender</label>
                                <select id="inputState" class="form-control" name="Gender" value="<?php echo $s->stf_gender?>">
                                    <option selected>Male</option>
                                    <option>Female</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                <label>Date Of Birth</label>
                                <input type="datetime-local" class="form-control select2" style="width: 100%" name="Date_Of_Birth" value="<?php echo $s->stf_dob?>">  
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                <label>User name</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: Dian" name="User_name" value="<?php echo $s->stf_username?>">  
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control select2" style="width: 100%" placeholder="Ex: 123" name="Password">  
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" class="form-control select2" style="width: 100%" placeholder="Ex: 123" name="confirm_password">  
                                </div>
                            </div>

                            <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-2);"><!--back button-->
                            <input class="btn btn-primary btn-sm" type="submit" value="Update" style="margin:2px;">
                        </div>
                    </form>
                <?php
                }else{

                    $s->stf_id                    = $_POST["NIC"];
                    $s->stf_designation           = $_POST["designation"];
                    $s->branch_id                = $_SESSION["uu"]['branch_id'];
                    $s->stf_full_name              = $_POST["Full_name"];
                    $s->stf_address	              = $_POST["Address"];
                    $s->stf_telephone	              = $_POST["Contact_number"];
                    $s->stf_email	                = $_POST["Email"];
                    $s->stf_gender	              = $_POST["Gender"];
                    $s->stf_dob	                  = $_POST["Date_Of_Birth"];
                    $s->stf_username	            = $_POST["User_name"];
                    $s->stf_password	            = md5($_POST["Password"]);
                    
                    $s->edit_staff();

                    ?>
                 <div class='alert alert-success form-group col-md-12' role='alert'>Update successfully !</div>
                 <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-2);"><!--back button-->

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


<!-- Content Wrapper. Contains page content -->

<script>
  $(document).ready(function(){

    $.get("ajax.php?branch_id=branch",function(data){
      
      parsedData=JSON.parse(data);


        $.each(parsedData,function(index,branch){
          $("#branch_id").append("<option value='"+ branch['id'] + "'>"+ branch['name'] + "</option>");

        });
    });



  });


</script>

<?php include"footer.php"; ?>




    

        

