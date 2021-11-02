<?php include"header.php"; ?>
<?php include"sidebar.php"; ?>

<?php

include "class/c_loan_category.php";

$ac=new loan_category();

    
      
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Add Loan Category</h3>

                </div><!-- /card-header -->
                <!--card body -->
                <div class="card-body">
                    <form action="add_loan_category_form.php" method="post">         
                        <div class="row">
                        <?php
                            if(isset($_POST["submit"])){
                                if(!empty($_POST["loan_category"]) && !empty($_POST["description"])){

                                    $ac->loan_category_name     = $_POST["loan_category"];
                                    $ac->note                  = $_POST["description"];
   
                                    $ac->save_loan_category();
                                    ?>
                                    <div class="alert alert-success form-group col-md-12" role="alert">
                                                    Loan category insert successfully!
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
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: Education Loan" name="loan_category" required>  
                            </div>

                            <div class="form-group col-md-12">
                                <label for="exampleFormControlTextarea1">Description</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Ex: Description " name="description" required></textarea>
                            </div>
                            <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                            <input class="btn btn-primary btn-sm" type="submit" value="Add" name="submit" style="margin:2px;">     

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

