<?php include"header.php"; ?>
<?php include"sidebar.php"; ?>

<?php

include "class/c_loan_category.php";

$lc=new loan_category();

$lc->loan_category_id=$_GET["category_id"];

$lc2=new loan_category();
$lc2->get_loan_category($_GET["category_id"]);

    
      
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Update Loan Category</h3>

                </div><!-- /card-header -->
                <!--card body -->
                <div class="card-body">
                    <form action="" method="post">         
                        <div class="row">
                        <?php
                            if(isset($_POST["submit"])){
                                if(!empty($_POST["loan_category"]) && !empty($_POST["description"])){

                                    $lc->loan_category_name     = $_POST["loan_category"];
                                    $lc->note                  = $_POST["description"];
   
                                    $lc->update_loan_category();
                                    ?>
                                    <div class="alert alert-success form-group col-md-12" role="alert">
                                                    Loan category update successfully!
                                    </div>
                                    <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-2);"><!--back button-->
                                    <?php

                                }else{
                                    ?>
                                    <div class='alert alert-danger form-group col-md-12' role='alert'>Please fill all text areas!</div>
                                    <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                                
                                    <?php
                                }
                                    
                            }else{ // end of isset($_POST["submit"])
                        
                        ?>

                            <div class="form-group col-md-12">
                                <label>Loan Category</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: Education Loan" name="loan_category" value="<?php echo $lc2->loan_category_name; ?>" required>  
                            </div>

                            <div class="form-group col-md-12">
                                <label for="exampleFormControlTextarea1">Description</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Ex: Description " name="description"  required><?php echo $lc2->note; ?></textarea>
                            </div>
                            <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                            <input class="btn btn-primary btn-sm" type="submit" value="Update" name="submit" style="margin:2px;">     

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

