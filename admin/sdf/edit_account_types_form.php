<?php include"header.php"; ?>
<?php include"sidebar.php"; ?>

<?php

include "class/c_account_type.php";

$at=new account_type();
$at->acc_type_id=$_GET["type_id"];



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

$editAccTypes=new account_type();
$editAccTypes->get_account_type($_GET["type_id"]);

    
      
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Update Account Type</h3>

                </div><!-- /card-header -->
                <!--card body -->
                <div class="card-body">
                    <form id="" action="" method="post">         
                        <div class="row">
                        <?php
                            if(isset($_POST["submit"])){
                                if(!empty($_POST["account_category"]) && !empty($_POST["account_type"]) && !empty($_POST["interest"]) && !empty($_POST["open_amount"]) && !empty($_POST["description"])){
                                
                                    if(check_interest_num($_POST["interest"])){
                                            if(check_amount_num($_POST["open_amount"])){
                                                
                                                
                                                $at->acc_type_name                  = $_POST["account_type"];
                                                $at->acc_category_id                = $_POST["account_category"];
                                                $at->interest                       = $_POST["interest"];
                                                $at->open_amount                    = $_POST["open_amount"];
                                                $at->acc_type_description           = $_POST["description"];
                                                
                                                $at-> update_account_type();
                                               
                                                ?>
                                                <div class="alert alert-success form-group col-md-12" role="alert">
                                                   Account type update successfully!
                                                </div>
                                                <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-2);"><!--back button-->
                                                <?php


                                            }else{ // end of check_amount_num($_POST["interest"]
                                                ?>
                                                <div class='alert alert-danger form-group col-md-12' role='alert'>Invalid amount! Please enter numeric amount</div>
                                                <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                                <?php
                                            }
                                    }else{ // end of check_interest_num($_POST["open_amount"])
                                            ?>
                                            <div class='alert alert-danger form-group col-md-12' role='alert'>Invalid Interest!</div>
                                            <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                            <?php
                                    }
                                }else{ // end of check whether fill all text areas
                                    ?>
                                    <div class='alert alert-danger form-group col-md-12' role='alert'>Please fill all text areas!</div>
                                    <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                    <?php
                                }    

                            }else{ // end of isset($_POST["submit"])
                        ?>

                            <div class="col-md-6">
                                <label for="account_category">Account Category</label>
                                <select id="account_category" name="account_category" class="form-control" required>
                                <option value="0">--Select Account Category--</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Account Type</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: Daru Isuru Saving" name="account_type" value="<?php echo $editAccTypes->acc_type_name; ?>" required>  
                            </div>


                            <div class="form-group col-md-6">
                                <label>Interest</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: 5%" name="interest" value="<?php echo $editAccTypes->interest; ?>" required>  
                            </div>

                            <div class="form-group col-md-6">
                                <label>Open Amount</label>
                                <input type="text" class="form-control select2" style="width: 100%" placeholder="Ex: 1000.00" name="open_amount" value="<?php echo $editAccTypes->open_amount; ?>" required>  
                            </div>

                            <div class="form-group col-md-12">
                                <label for="exampleFormControlTextarea1">Description</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Ex: Description " name="description" ><?php echo $editAccTypes->acc_type_description; ?></textarea>
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


        $.get("ajax.php?type=accCat",function(data){ 

            parsedData=JSON.parse(data);
            
            $.each(parsedData, function(index,accCat){
                $("#account_category").append("<option value='"+accCat['id']+"'>"+accCat['name']+"</option>");
            });
        });

        // #add_account_type_form
        // input[name=submit]

        // $('input[name=submit]').click((e)=>{
        //     e.preventDefault(); // dont submit

        //     //check inputs
        //     if(!checkInput($('input[name=interest]'))){
        //         alert("fill the input box")
        //     }else{
        //         $('#add_account_type_form').submit();
        //     }

        // })

        // function checkInput(input){
        //     if(input.val() == ""){
        //         return false;
        //     }else{
        //         return true;
        //     }
        // }
   

    });


    

    </script>

<?php include"footer.php"; ?>

