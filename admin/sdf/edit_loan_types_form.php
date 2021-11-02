<?php include"header.php"; ?>
<?php include"sidebar.php"; ?>

<?php

include "class/c_loan_type.php";

$lt=new loan_type();
$lt->loan_type_id=$_GET["type_id"];



function check_amount_num($number){
    if(empty($number)){
        return false;
    }elseif(!is_numeric($number)){
        return false;
    }else{
        return true;
    }
    
} 

function check_interest_num($number){
    if(empty($number)){
        return false;
    }elseif(!is_numeric($number)){
        return false;
    }else{
        return true;
    }
    
} 

$editLoanTypes=new loan_type();
$editLoanTypes->get_loan_type($_GET["type_id"]);

    
      
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Update loan type</h3>

                </div><!-- /card-header -->
                <!--card body -->
                <div class="card-body">
                    <form id="" action="" method="post">         
                        <div class="row">
                        <?php
                            if(isset($_POST["submit"])){
                                if(!empty($_POST["loan_category"]) && !empty($_POST["loan_type"]) && !empty($_POST["interest"])  && !empty($_POST["description"])){
                                
                                    if(check_interest_num($_POST["interest"])){
                                                
                                                $lt->loan_type_name             = $_POST["loan_type"];
                                                $lt->loan_category_id           = $_POST["loan_category"];
                                                $lt->interest                   = $_POST["interest"];
                                                $lt->note                       = $_POST["description"];
                                                
                                                $lt->update_loan_type();
                                                ?>
                                                <div class="alert alert-success form-group col-md-12" role="alert">
                                                    Loan type update successfully!
                                                </div>
                                                <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-2);"><!--back button-->
                                                <?php


                                           
                                            
                                            
                                    }else{ // end of check_interest_num($_POST["open_amount"])
                                            ?>
                                            <div class='alert alert-danger form-group col-md-12' role='alert'>Invalid interest! please enter numeric interest.</div>
                                            <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                            <?php
                                    }
                                }else{ // end of check whether fill all text areas
                                    ?>
                                    <div class='alert alert-danger form-group col-md-12' role='alert'>Please fill all text areas</div>
                                    <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                    <?php
                                }    

                            }else{ // end of isset($_POST["submit"])
                        ?>

                            <div class="col-md-4">
                                <label for="loan_category">Loan Category</label>
                                <select id="loan_category" name="loan_category" class="form-control" required>
                                <option value="0">--Select loan Category--</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Loan Type</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: Sihina Niwahana Loan" name="loan_type" value="<?php echo $editLoanTypes->loan_type_name; ?>" required>  
                            </div>


                            <div class="form-group col-md-4">
                                <label>Interest</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: 5%" name="interest"  value="<?php echo $editLoanTypes->interest; ?>" required>  
                            </div>

                         

                            <div class="form-group col-md-12">
                                <label for="exampleFormControlTextarea1">Description</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Ex: Description " name="description" required><?php echo $editLoanTypes->note; ?></textarea>
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

    <script>

$(document).ready(function(){

$.get("ajax.php?ltype=loanCat",function(data){
    
    parsedData=JSON.parse(data);

    $.each(parsedData, function(index,loanCat){
        $("#loan_category").append("<option value='"+loanCat['id']+"'>"+loanCat['name']+"</option>");
    });
});

    });


    

    </script>

<?php include"footer.php"; ?>

