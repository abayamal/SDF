**Loan Form**
account number
nic 


**person class** 
    is_exists(); //returns true aor false
        $sql=select where person_i
    save_person();
    edit_person();


**account class** 
    is_exists();// returns true or false
    save_account();
    edit_acount();



**loan class** 
    save_loan_application();
        if(person->is_exists()){
            person->edit_person();
        }else{
            person->save_person();
        }

        if(account->is_exists()){
            account->edit_account();
        }else{
            account->save_account();
        }



