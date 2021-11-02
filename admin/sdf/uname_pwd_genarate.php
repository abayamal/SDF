<?php include"header.php"; ?>
<?php include"sidebar.php"; ?>

<?php
$acc_no=$_GET["acc_id"];

//////to create random password
function random_password( $length ) {

    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($chars),0,$length);

}
//$random_password=random_password(8);  //correct password
//$password=md5($random_password);      // hashed password


$common_password="123";
$common_password_hashed=md5($common_password);
//////to create username
include_once "class/c_account.php";
$ac=new account();
$ac->get_account($acc_no);
$cust_nic=$ac->cus_id;

include_once "class/c_customer.php";
$cs=new customer();
$cs->get_customer($cust_nic);

$username=$cs->cus_first_name;   //correct username
$to_email_address=$cs->cus_email;   //correct username


////user name and password send to gmail account

$to =$to_email_address;
$subject="Internet banking";
$body ="Hi ".$username."!\n"."Your internet banking service will be activate from this moment.Use the following password and username of mind to access the online banking service.\n Thank you!"."\n\n"."USER NAME: ".$username."\n"."PASSWORD: ".$common_password;
$headers ="From: Sarvodaya Development Finance";
// $cc = $_POST['cc_list'];

mail($to,$subject,$body,$headers);

//update user name and password in customer table
$cs2=new customer();
$cs2->cus_id=$cust_nic;
$cs2->cus_username=$username;
$cs2->cus_password=$common_password_hashed;

$cs2->update_username_and_password();


?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"><!--section-->
        <div class="container-fluid"><!--container-fluid -->

        <div class="row p-3 justify-content-center"><!--row p-3 justify-content-center-->
            <div class="col-md-8"><!--col-md-8-->
                <div class="card card-default"><!--card card-default -->
                    <div class="card-header">
                        <h3 class="card-title">Internet banking register</h3>
                    </div><!-- /card-header -->
                        <div class="card-body" style="text-align:center;"><!--card body --> 
                      <h3 style="color:#33cc33; text-align:center; "><b>Internet banking activate successfully!</b></h3>
                      <p style="text-align:center; "><b>Password and username sent to email account.Check the email and get the password and username!</b></p>

                      <input class="btn btn-info btn-sm" type="submit" value="Back" name="back" style="margin:2px;" onclick="history.go(-1);"><!--back button-->

                        </div><!-- /.card-body -->
                    <div class="card-footer"><!--card-footer --> 
                    </div><!--/card-footer -->
                </div><!--/card card-default -->
            </div><!--/col-md-8-->
        </div><!--/row p-3 justify-content-center-->

        </div><!--/container-fluid -->
    </section><!--/section-->
</div>
<?php include"footer.php"; ?>


    

        

