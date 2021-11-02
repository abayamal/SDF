<?php
    include "class/c_account.php";
    include "class/c_transaction.php";

    $ac=new account;
    $allacc=$ac->get_all_account_in_all_branch();

    foreach($allacc as $item)
    {
        
        $i=$item->acctype->interest;
        $ba=$item->acc_balance;
        $ac=$item->acc_id;

        //interest calculation for all saving accounts
        $total=($ba*$i)/100;

    
        $tr=new transaction;
        $tr->acc_id=$ac;
        $tr->debit=$total;
        $tr->deposit_branch=$_SESSION["uu"]["branch_id"];
        $tr->note="interest";
        $tr->special_note="";
        
        if($total>0)
        {
        $tr->deposit();    
        }
    
    
    
    }
echo "interest calculated!";  
 



?> 
