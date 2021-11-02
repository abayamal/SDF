<?php
session_start();
include_once "class/c_account.php";

//create account number
$branch_id=$_SESSION["uu"]['branch_id'];


$branch_code=str_pad($branch_id, 3, '0', STR_PAD_LEFT);
$bank_code="007";


echo $branch_code;
echo "<br>";
// echo $bank_code;

$first= $bank_code.$branch_code;



$acnt=new account;
$x=$acnt->last_insert_acc_id();
// print_r($x);
$last_id=$x->acc_id;
$last_id_com=substr($last_id, -7);
$new_id=$last_id_com+1;
$new_id_new=str_pad($new_id, 7, '0', STR_PAD_LEFT);
echo $last_id;

echo "<br>";
echo $new_id;
echo $new_id_new;
echo "<br>";

$final_id=$bank_code.$branch_code.$new_id_new;
$final=(int)$final_id;

echo $final;

$acnt2=new account;

$cus_id=$acnt2->cus_id='956858695';
$acc_type=$acnt2->acc_type='28';
$acc_interest_amount=$acnt2->acc_interest_amount='1';
$branch_id=$acnt2->branch_id=$_SESSION["uu"]['branch_id'];



$acnt2->registerAcc($final,$cus_id,$acc_type,$acc_interest_amount,$branch_id);

// if($acnt->last_include_Acc()){//check whether last include account number available?

//     $last_include_full_acc_num=$acnt->acc_id;
//     $only_acc_num = substr($last_include_full_acc_num, -7); //without branch and bank code
//     $new_only_acc_num=$only_acc_num+1;
//     $new_only_acc_num=str_pad($new_only_acc_num, 7, '0', STR_PAD_LEFT);
//     $new_full_acc_num=$bank_code.$branch_code.$new_only_acc_num;
//     $new_full_acc_num_int=(int)$new_full_acc_num;

//     //$ac->acc_id=$new_full_acc_num;
 

// }else{

//     $new_only_acc_num=str_pad("1", 7, '0', STR_PAD_LEFT);
//     $new_full_acc_num=$bank_code.$branch_code.$new_only_acc_num;
//     $new_full_acc_num_int=(int)$new_full_acc_num;

//     //$ac->acc_id=$new_full_acc_num;


// }





?>