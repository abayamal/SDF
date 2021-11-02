<?php
session_start();
//response format if failed
$response = array(
    'status'=> false,
    'data'=> array(),
    'msg' => "Failed transaction"
);

//check if request came in and all parmeters are set
if(isset($_POST['sender']) && isset($_POST['reciever']) && isset($_POST['amount']) ){
    //do the transaction things


    include_once "class/c_transaction.php";
       //withdraw money sender saving account
       $t1=new transaction();
       $t1->acc_id=$_POST['sender'];
       $t1->withdraw_branch=$_SESSION["uu"]["branch_id"];
       $t1->credit=$_POST['amount'];
       $t1->note="fund_transfer";
       $t1->withdraw();

       //Deposit money to receiver saving account
       $t2=new transaction();
       $t2->acc_id=$_POST['reciever'];
       $t2->deposit_branch=$_SESSION["uu"]["branch_id"];
       $t2->debit=$_POST["amount"];
       $t2->note="fund_transfer";
       $t2->deposit();

       
       //if successful
       //change reponses if successfull
       $response['status'] = true;
       $response['data']['sender'] = $_POST['sender'];
       $response['data']['reciever'] = $_POST['reciever'];
       $response['data']['amount'] = $_POST['amount'];
       $response['data']['name'] = 'sathira';
       $response['msg'] = "Transaction Success";
    }
    
    echo json_encode($response); //send the response
   