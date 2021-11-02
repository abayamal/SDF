<?php
ob_start();
 include "header.php"; 
 include "sidebar.php"; 




?>      

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Edit branch</h3>

                </div><!-- /card-header -->
                <!--card body -->
                <div class="card-body">
                <?php
                    if(isset($_GET["branch_id"]) && !isset($_POST["branch_name"])){

                        include "class/c_branch.php";
                        $editb=new branch();

                        $editb->branch_id = $_GET["branch_id"];
                        $editb->get_branch($_GET["branch_id"]);  

                ?>
                
                    <form action="edit_branches_form.php" method="POST">  
                        <div class="row">
                        <?php
                                $branch_id=$_GET["branch_id"];

                        ?>

                            <input type="hidden" name="branch_id" value="<?php print $branch_id; ?>"/>


                            <div class="form-group col-md-6">
                                <label>Branch name</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: Kandy" name="branch_name" value="<?php echo $editb->branch_name?>" required>  
                            </div>

                            <div class="form-group col-md-6">
                                <label>City</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex:kandy" name="branch_city" value="<?php echo $editb->branch_city?>" required>  
                            </div>

                            <div class="form-group col-md-6">
                                <label for="#">Branch phone</label>
                                <input type="text" class="form-control" id="#" placeholder="Ex: 011-2265895" name="branch_phone" value="<?php echo $editb->branch_phone   ?>" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="#">Branch Manager Nic</label>
                                <input type="text" class="form-control" id="#" placeholder="Ex: 951710407V" name="branch_manager_id" value="<?php echo $editb->branch_manager_id ?>" required>
                            </div>

                            <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                            <input class="btn btn-primary btn-sm" type="submit" value="Update" style="margin:2px;">

                        </div>
                    </form> 
                <?php
                }else{
                    include_once "class/c_branch.php";
                    $edit_branch=new branch();

                    $edit_branch->branch_id=$_POST["branch_id"];
                    $edit_branch->branch_name=$_POST["branch_name"];
                    $edit_branch->branch_city=$_POST["branch_city"];
                    $edit_branch->branch_phone=$_POST["branch_phone"];
                    $edit_branch->branch_phone=$_POST["branch_phone"];
                    $edit_branch->branch_manager_id=$_POST["branch_manager_id"];
            
                    $edit_branch->edit_branch();
                ?>
               <div class='alert alert-success form-group col-md-12' role='alert'>Branch update successfully !</div>
               <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
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



    

        
<?php include"footer.php"; ?>

