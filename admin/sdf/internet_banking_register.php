<?php include"header.php"; ?>
<?php include"sidebar.php"; ?>
<?php
include "class/c_account.php";
$a = new account();
include "class/c_customer.php";
$c = new customer();
include "class/c_transaction.php";
$t =new transaction();



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
    <section class="content-header">
      <div class="container-fluid">
                <div class="row p-3 justify-content-center">
                    <div class="col-md-10">
                        <div class="card text-center">
                            <div class="card-header">
                            Enter Account Number
                            </div>
                            <div class="card-body">
                            
                                <input class="form-control no-controls <?php if(isset($_GET["acc_id"])){if( !check_acc_num($_GET["acc_id"])){echo "is-invalid";}} ?>" type="number" value="<?php if(isset($_GET["acc_id"])){ echo '011-2-001-2-0046036'.$_GET["acc_id"]; } ?>" placeholder="Account number" name="acc_id">

                                <br>
                                
                                <div class="sbmt btn btn-primary" data-type="accDet">Account Details</div>
                        
                                                                   
                            </div>
                        </div>
                        <?php                            

                            if(isset($_GET["type"])){

                                if(!empty($_GET["type"]) && check_acc_num($_GET["acc_id"])){
                                    switch($_GET["type"]){
                                        case "accDet":
                                            if($a->is_exist_account($_GET["acc_id"]))//fetch account details
                                            {
                                                $c->get_customer($a->cus_id); //fetch customer details
                                                ?>

                                                <div class="card text-center">
                                                    <div class="card-header">Account Details</div><!--Account Details-->
                                                        <div class="myDiv2"><!--background color div -->
                                                            <div class="card-body" style="text-align:left;"><!--card-body-->
                                                                <table class="responsive w-100">
                                                                    <tr>
                                                                        <td><b>Account ID:</b></td>
                                                                        <td><?php echo  $a->acc_id; ?></td>
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
                                                                        <td><?php echo $c->cus_id; ?>V</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><b>Customer Name:</b></td>
                                                                        <td><?php echo $c->cus_full_name  ?></td>
                                                                        <td><b>Customer Address:</b></td>
                                                                        <td><?php echo $c->cus_address; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><b>Customer Telephone:</b></td>
                                                                        <td><?php echo $c->cus_telephone; ?></td>
                                                                        <td><b>Customer Email:</b></td>
                                                                        <td><?php echo $c->cus_email; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><b>Gender:</b></td>
                                                                        <td><?php echo $c->cus_gender; ?></td>
                                                                        <td><b>Date of birth:</b></td>
                                                                        <td><?php echo $c->cus_dob; ?></td>
                                                                    </tr>
                                                                </table>
                                                                <br>
                                                                <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->
                                                                
                                                                <a href='uname_pwd_genarate.php?acc_id=<?php echo $a->acc_id; ?>' ><button type='button' class='btn btn-success btn-sm'>Register</button></a>
                                                            </div><!--/card-body-->
                                                        </div><!--/background color div -->
                                                    </div><!--/Account Details-->
                                                <?php
                                            }else
                                            {
                                                ?>

                                                <div class="alert alert-danger" role="alert">Account does not exist.</div>
                                                
                                                <?php
                                            }                                            
                                        break;
                                        
                                        default:
                                            ?>

                                            <div class="alert alert-danger" role="alert">Invalid Request</div>
                                                
                                            <?php  
                                    }
                                }else{
                                    ?>

                                    <div class="alert alert-danger" role="alert">Invalid Account Number or Invalid Request.</div>
                                    
                                    <?php
                                }
                            }

                           
                        ?>
                    </div>    
                </div>
      </div><!--/container-fluid -->
    </section>

    <script>
        $(document).ready(function(){
            $(".sbmt").click(function(){
                // $(this).data("type")

                //If account number is valid
                let url = window.location.href.split('?')[0] + "?type=" + $(this).data("type") + "&acc_id="+ $("input[name=acc_id]").val();
                window.location.href= url;
                
            });
        });
    </script>


<?php include"footer.php"; ?>
            
                

                
            

    

        

