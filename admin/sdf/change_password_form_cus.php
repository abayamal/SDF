<?php include"header2.php"; ?>
<?php include"sidebar2.php"; ?>




<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"><!--section-->
        <div class="container-fluid"><!--container-fluid -->
            <div class="row p-3 justify-content-center"><!--row p-3 justify-content-center-->
                <div class="col-md-8"><!--col-md-8-->

                    <div class="card card-default"><!--card card-default -->
                        <div class="card-header">
                            <h3 class="card-title">Change username and password</h3>
                        </div><!-- /card-header -->
                        <div class="myDiv2"><!--background color div -->
                            <div class="card-body"><!--card body -->
                            <?php
                            if(!isset($_POST["submit"])){
                            
                            ?>
                                <form action="" method="POST">       
                                    <div class="row"><!-- row-->   


                                   
                                        
                                       

                                        <div class="form-group col-md-6">
                                            <label>New user name :</label>
                                        </div> 
                                        <div class="form-group col-md-6">   
                                            <input type="text" class="form-control select2" style="width: 100%" placeholder="sathira" name="new_name" required>  
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Old password :</label>
                                        </div>
                                        <div class="form-group col-md-6">    
                                            <input type="password" class="form-control select2" style="width: 100%" placeholder="Password" name="old_passwd" required>  
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>New password :</label>
                                        </div>
                                        <div class="form-group col-md-6">    
                                            <input type="password" class="form-control select2" style="width: 100%" placeholder="Password" name="new_passwd" required>  
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Re-type-New password :</label>
                                        </div>
                                        <div class="form-group col-md-6">    
                                            <input type="password" class="form-control select2" style="width: 100%" placeholder="Password" name="re_new_passwd" required>  
                                        </div>

                                        
                                        <div class="form-group col-md-6">
                                      
                                        <input class="btn btn-success btn-sm" type="submit" name="submit" value="Change" style="margin:1px;">
                                        </div>
                                    </div><!-- /row-->  
                                </form>

                            <?php
                            }else{
                                    include_once "class/c_customer.php";
                                    $c=new customer();
                                    $c->get_customer_password($_SESSION["uu"]['cus_id']);
                                    $old_password=$c->cus_password;
                                    
                                    if($old_password==$_POST["old_passwd"]){//check whether old password match

                                        if($_POST["new_passwd"]==$_POST["re_new_passwd"]){//check twice enter new passwords are same?
                                            
                                            $c2=new customer();
                                            $c2->cus_id=$_SESSION["uu"]['cus_id'];
                                            $c2->cus_username=$_POST["new_name"];
                                            $c2->cus_password=$_POST["new_passwd"];

                                            $c2->update_username_and_password();
                                        ?>
                                            <div class='alert alert-success form-group col-md-12' role='alert'>Change password successfully !</div>
                                            <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"> <!--back button--> 
                                        <?php
                                        }else{
                                            ?>
                                         <div class='alert alert-danger form-group col-md-12' role='alert'>You must enter the same password twice in order to confirm it !</div>
                                         <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"> <!--back button-->

                                            <?php
                                        }
                                        

                                    }else{
                                        ?>
                                        <div class='alert alert-danger form-group col-md-12' role='alert'>The old password you entered is incorrect!</div>
                                        <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"> <!--back button-->

                                        <?php
                                    }

                                   
                            }
                            ?>

                            </div><!-- /.card-body -->
                        </div><!--/background color div -->
                        <div class="card-footer"><!--card-footer --> 
                        </div><!--/card-footer -->
                    </div><!--/card card-default -->
                </div><!--/col-md-8-->
            </div><!--/row p-3 justify-content-center-->
        </div><!--/container-fluid -->
    </section><!--/section-->

<script>


</script>









</div>
<?php include"footer2.php"; ?>


    

        

