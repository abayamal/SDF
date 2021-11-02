<?php 
 include "header.php"; 
 include "sidebar.php"; 

 include "class/c_branch.php";
 
 $b = new branch();
 
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

function check_phone_num($number){
    if(empty($number)){
        return false;
    }elseif(!is_numeric($number)){
        return false;
    }elseif(strlen($number)==10){
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
                    <h3 class="card-title">Add branch</h3>

                    
                </div><!-- /card-header -->
                <!--card body -->
                <div class="card-body">
                    <form action="add_branch_form.php" method="POST">  
                        <div class="row">
                            <?php
                                if(isset($_POST["submit"])){
                                        if(!empty($_POST["branch_name"]) && !empty($_POST["branch_city"]) && !empty($_POST["branch_phone"]) && !empty($_POST["branch_manager_id"]) ){

                                            if(!$b->is_exist_branch($_POST["branch_name"])){
                                                if(check_phone_num($_POST["branch_phone"])){
                                                    if(check_nic_num($_POST["branch_manager_id"])){
                                                        
                                                        $b->branch_name         = $_POST["branch_name"];
                                                        $b->branch_city         = $_POST["branch_city"];
                                                        $b->branch_phone        = $_POST["branch_phone"];
                                                        $b->branch_manager_id   = $_POST["branch_manager_id"];


                                                        $b->save_branch();
                                                        ?>
                                                        <div class="alert alert-success form-group col-md-12" role="alert">
                                                        Branch insert successfully!
                                                        </div>
                                                        <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-2);"><!--back button-->

                                                        <?php


                                                    }else{ // end check_nic_num($_POST["branch_manager_id"])
                                                        ?>
                                                        <div class='alert alert-danger form-group col-md-12' role='alert'>Please enter valid nic number</div>
                                                        <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                                        <?php
                                                        
                                                    }

                                                }else{ // end check_phone_num($_POST["branch_phone"])
                                                    ?>
                                                        <div class='alert alert-danger form-group col-md-12' role='alert'>Please enter valid phone number</div>
                                                        <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                                    <?php

                                                }    
                                                
                                            }else{ // end !$b->is_exist_branch($_POST["branch_name"])
                                                ?>
                                                    <div class='alert alert-danger form-group col-md-12' role='alert'>This branch already exist!</div>
                                                    <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                                <?php
                                            }
                                        
                                        }else{
                                            ?>
                                                    <div class='alert alert-danger form-group col-md-12' role='alert'>Please fill all text areas.</div>
                                                    <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                            <?php


                                        }    

                                }else{ // end isset($_POST["submit"])

                            ?>
                            

                            <div class="form-group col-md-6">
                                <label>Branch name</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: Kandy" name="branch_name" required>  
                            </div>

                            <div class="form-group col-md-6">
                                <label>City</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex:kandy" name="branch_city" required>  
                            </div>

                            <div class="form-group col-md-6">
                                <label for="#">Branch phone</label>
                                <input type="text" class="form-control" id="#" placeholder="Ex: 011-2265895" name="branch_phone" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="#">Branch Manager Nic</label>
                                <input type="text" class="form-control" id="#" placeholder="Ex: 951710407V" name="branch_manager_id" required>
                            </div>
                            
                            <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                            <input class="btn btn-primary btn-sm" type="submit" value="Create" name="submit" style="margin:2px;">

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

    

        
<?php include"footer.php"; ?>

