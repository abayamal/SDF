<?php include"header.php"; ?>
<?php include"sidebar.php"; ?>
<?php

include_once "class/c_account.php";
$a=new account();
include_once "class/c_person.php";
$c = new person();

function check_acc_num($number){
    if(empty($number)){
        return false;
    }elseif(is_numeric($number)){
        return true;
    }else{
        return false;
    }
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"><!--section-->
        <div class="container-fluid"><!--container-fluid -->
            <div class="row p-3 justify-content-center"><!--row p-3 justify-content-center-->
                <div class="col-md-10"><!--col-md-8-->
                    
                        
                            
                            <?php
                            if(!isset($_GET["type"]))
                            {
                            ?>

                             <div class="card text-center"><!--card text-center -->
                                <div class="card-header">
                                    <h3 class="card-title">Account Details</h3>
                                </div><!-- /card-header -->
                                    <div class="card-body"><!--card body -->       
                                        
                                    <input class="form-control no-controls <?php if(isset($_GET["accNo"])){if( !check_acc_num($_GET["accNo"])){echo "is-invalid";}} ?>" type="number" value="<?php if(isset($_GET["accNo"])){ echo $_GET["accNo"]; } ?>" placeholder="Account Number" name="accNo">
                                    <br>

                                    <div class="search btn btn-primary" data-type="accDet">Search</div>


                                    </div><!-- /.card-body -->
                            </div><!--/card text-center -->                             
                            
                            
                            <?php
                            }else {

                                switch($_GET["type"]){

                                    case "accDet":
                                            
                                        if(check_acc_num($_GET["accNo"])){
                                            if($a->is_exist_account($_GET["accNo"])){
                                                $a->get_account($_GET["accNo"]); //fetch account details
                                                $c->get_customer($a->per_id); //fetch customer details
                                                ?>
                                                <div class="card text-center"><!--card text-center -->
                                                    <div class="card-header">
                                                        <h3 class="card-title">Account Details</h3>
                                                    </div><!-- /card-header -->
                                                    <div class="myDiv2"><!--background color div -->
                                                        <div class="card-body" style="text-align:left;"><!--card body -->       
                                                            <table>
                                                                <tr>
                                                                    <td><b>Account ID:</b></td>
                                                                    <td><?php echo $a->acc_id; ?></td>
                                                                    <td><b>Account Type:</b></td>
                                                                    <td><?php echo $a->acc_type; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><b>Account Status:</b></td>
                                                                    <td><b><?php echo "<span style='color:#2ab71e'>$a->acc_status</span>" ?><b></td>
                                                                    <td><b>Opened Date:</b></td>
                                                                    <td><?php echo $a->acc_created_date; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><b>Account Balance:</b></td>
                                                                    <td><?php echo "LKR. " . number_format($a->acc_balance,2 , ".", ","); ?></td>
                                                                    <td><b>Customer NIC:</b></td>
                                                                    <td><?php echo $c->per_id; ?>V</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><b>Customer Name:</b></td>
                                                                    <td><?php echo $c->per_full_name  ?></td>
                                                                    <td><b>Customer Address:</b></td>
                                                                    <td><?php echo $c->per_address; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><b>Customer Telephone:</b></td>
                                                                    <td><?php echo $c->per_telephone; ?></td>
                                                                    <td><b>Customer Email:</b></td>
                                                                    <td><?php echo $c->per_email; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><b>Gender:</b></td>
                                                                    <td><?php echo $c->per_gender; ?></td>
                                                                    <td><b>Date of birth:</b></td>
                                                                    <td><?php echo $c->per_dob; ?></td>
                                                                </tr>
                                                            </table>
                                                        </div><!-- /.card-body -->
                                                    </div><!--/background color div -->
                                                </div><!--/card text-center -->            



                                                

                                                <?php
                                            }else{ //end $a->is_exist_account($_GET["accNo"])
                                                ?>
                                                <div class="alert alert-danger" role="alert">Account does not exist.</div>
                                                <?php

                                            }
                                              
                                        }else{  //end check_acc_num($_GET["accNo"])
                                            ?>
                                            <div class="alert alert-danger" role="alert">Invalid Account Number</div>
                                            <?php
                                        }

                                    break;  //end of accDet case







                                }//end of switch
                               
                            } // end of man else


                            ?>

                </div><!--col-md-10--> 
                </div>     
            </div><!--/row p-3 justify-content-center-->    
        </div><!--/container-fluid -->
    </section><!--/section-->

    <script>

        $(document).ready(function(){
            $(".search").click(function(){
                // $(this).data("type")

                //If account number is valid
                let url = window.location.href.split('?')[0] + "?type=" + $(this).data("type") + "&accNo="+ $("input[name=accNo]").val();
                window.location.href= url;
                
            });
        });                   



    </script>                        


<?php include"footer.php"; ?>


    

        
