<?php
session_start();

 //create account number
 $branch_id=$_SESSION["uu"]['branch_id'];
 $branch_code=str_pad($branch_id, 3, '0', STR_PAD_LEFT);
 $bank_code="007";
include_once "class/c_account.php";
 $acnt=new account;

 if($acnt->last_include_Acc()){//check whether last include account number available?

     $last_include_full_acc_num=$acnt->acc_id;
     $only_acc_num = substr($last_include_full_acc_num, -7); //without branch and bank code
     $new_only_acc_num=$only_acc_num+1;
     $new_only_acc_num=str_pad($new_only_acc_num, 7, '0', STR_PAD_LEFT);
     $new_full_acc_num=$bank_code.$branch_code.$new_only_acc_num;
     $new_full_acc_num_int=(int)$new_full_acc_num;

    echo $new_full_acc_num_int;

    $acnt2=new account;

    $cus_id=$acnt2->cus_id='956858695';
    $acc_type=$acnt2->acc_type='28';
    $acc_interest_amount=$acnt2->acc_interest_amount='1';
    $branch_id=$acnt2->branch_id=$_SESSION["uu"]['branch_id'];



$acnt2->registerAcc( $new_full_acc_num_int,$cus_id,$acc_type,$acc_interest_amount,$branch_id);

echo $new_full_acc_num_int;

     //$ac->acc_id=$new_full_acc_num;
  

 }else{

     $new_only_acc_num=str_pad("1", 7, '0', STR_PAD_LEFT);
     $new_full_acc_num=$bank_code.$branch_code.$new_only_acc_num;
     $new_full_acc_num_int=(int)$new_full_acc_num;

     //$ac->acc_id=$new_full_acc_num;
     $acnt2=new account;

     $cus_id=$acnt2->cus_id='956858695';
     $acc_type=$acnt2->acc_type='28';
     $acc_interest_amount=$acnt2->acc_interest_amount='1';
     $branch_id=$acnt2->branch_id=$_SESSION["uu"]['branch_id'];

     $acnt2->registerAcc( $new_full_acc_num_int,$cus_id,$acc_type,$acc_interest_amount,$branch_id);

     echo $new_full_acc_num_int;
 }





?>