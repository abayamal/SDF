<?php

if(isset($_GET["type"])){
    
    //Ajax response for Account Catergoties
    if($_GET['type'] == "accCat"){

        include "class/c_account.php" ;

        $account = new account();
        $account->display_account_categories();

    }
    

    //Ajax response for Account Types
    if(isset($_GET['acc_category_id']) && $_GET['type'] == "accType"){

        include "class/c_account.php";

        $account = new account();
        $account->display_account_types($_GET['acc_category_id']);

    }

}

else{

if(isset($_GET["branch_id"])){
    
    //Ajax response for sdf branches
    if($_GET['branch_id'] == "branch"){

        include "class/c_branch.php" ;

        $branch = new branch();
        $branch->display_sdf_branch();

    }
}


else{
    
if(isset($_GET["ltype"])){
    
    //Ajax response for loan Catergoties
    if($_GET['ltype'] == "loanCat"){

        include "class/c_loan.php" ;

        $loan = new loan();
        $loan->display_loan_categories();

    }

    //Ajax response for Account Types
    if(isset($_GET['loan_category_id']) && $_GET['ltype'] == "loanType"){

        include "class/c_loan.php";

        $loantype = new loan();
        $loantype->display_loan_types($_GET['loan_category_id']);

    }
}

}
}









?>