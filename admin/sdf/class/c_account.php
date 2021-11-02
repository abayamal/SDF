<?php

include_once("config.php");

    class account
    {
        public $acc_id;
        public $cus_id;
        public $acc_type;
        public $acc_balance;
        public $acc_created_date;
        public $acc_interest_amount;
        public $acc_status;
        public $cust;
        public $branch_id;
        
        private $db;

        function __construct()
    {
        $this->db=new mysqli(host,un,pw,db);
    }


        function registerAcc($acc_no)
        {
            //$db=new mysqli("localhost","root","","bank");
            $sql="insert into account_tbl(acc_id,cus_id,acc_type,acc_interest_amount,branch_id)
            values($acc_no,'$this->cus_id','$this->acc_type','$this->acc_interest_amount','$this->branch_id')";
            $this->db->query($sql);

           
            
        }

        // function registerAcc($final,$cus_id,$acc_type,$acc_interest_amount,$branch_id)
        // {
        //     //$db=new mysqli("localhost","root","","bank");
        //     $sql="insert into account_tbl(acc_id,cus_id,acc_type,acc_interest_amount,branch_id)
        //     values($final,'$cus_id','$acc_type','$acc_interest_amount','$branch_id')";
        //     $this->db->query($sql);

           
            
        // }



        // function registerBranchAcc()
        // {
        //     //$db=new mysqli("localhost","root","","bank");
        //     $sql="insert into account_tbl(cus_id,acc_type,acc_interest_amount,branch_id)
        //     values('$this->cus_id','0','0','$this->branch_id')";
        //     $this->db->query($sql);
        // }

        

        // function edit_account()
        // {
        //     $sql="update account set Ac_no='$this->Ac_no',Ac_type='$this->Ac_type',Cust_id='$this->Cust_id',Balance='$this->Balance',Interest_rate='$this->Interest_rate',Open_date='$this->Open_date',Interest_id='$this->Interest_id',Interest_amount='$this->Interest_amount'";

        //     $this->db->query($sql);
        //     return true;
        // }

        /*
        function del_account($id)
        {
            $sql="delete from account where Ac_no=$id";
            $this->db->query($sql);
            return true;
        }
        */

        function get_account($id) //get account using account number
        {
            $db=new mysqli("localhost","root","","bank");
            $sql="select * from account_tbl where acc_id='$id'";
            $res=$db->query($sql);

            include_once "class/c_account_type.php";

            $row=$res->fetch_array();

            $this->acc_id=$row['acc_id'];

            $acctype=new account_type();     //To get account type name
            $acct=$acctype->get_account_type($row['acc_type']);

            $this->acc_type=$acct->acc_type_name;
            $this->acc_created_date=$row['acc_created_date'];
            $this->acc_status=$row['acc_status'];
            $this->cus_id=$row['cus_id'];
            $this->branch_id=$row['branch_id'];
            
            $sql2="select * from accbal where acc_id='$id' LIMIT 1";
            $res2=$db->query($sql2);
            $row2=$res2->fetch_array();

            $this->acc_balance=$row2['bal'];

            return $this;
        
        }


        function get_branch_account($branchId) //get branch account using branch_id
        {
            $db=new mysqli("localhost","root","","bank");
            $sql="select * from branch_tbl where branch_id='$branchId'";
            $res=$db->query($sql);

            $row=$res->fetch_array();

            $this->acc_id=$row['acc_id'];

            return $this;
        
        }

        function get_branch_account_balance($accId) //get branch account using branch_id
        {
            $db=new mysqli("localhost","root","","bank");
            $sql="select * from accbal where acc_id='$accId'";
            $res=$db->query($sql);

            $row=$res->fetch_array();

            $this->acc_balance=$row['bal'];

            return $this;
        
        }



        

        function get_all_account($branch_id)
        {
            $sql="select * from account_tbl where acc_status='active' and branch_id='$branch_id'"; // Get only customer account
            $r=$this->db->query($sql);

            $all_account=array();
            include "c_customer.php";
            include "c_account_type.php";

            while($row=$r->fetch_array())
            {
                $a=new account();
               
                $a->acc_id=$row['acc_id'];
                $a->acc_type=$row['acc_type'];
                $a->branch_id=$row['branch_id'];

                //Get balance from view accbal table
                $sql2="select * from accbal where acc_id=$a->acc_id";
                $r2=$this->db->query($sql2);
                $row2=$r2->fetch_array();
                $a->acc_balance=$row2['bal'];

                $a->acc_created_date=$row['acc_created_date'];
                $a->acc_status=$row['acc_status'];

                //Get customer data from customer table
                $c=new customer();
                $a->cust =   $c->get_customer($row['cus_id']);

                //Get account type information from acc_type_table and assing acctype
                $at=new account_type();
                $a->acctype= $at->get_account_type($row['acc_type']);
                
                
            $all_account[]=$a;
            }
            return $all_account;
        }

        function get_all_account_in_all_branch()
        {
            $sql="select * from account_tbl where acc_status='active' or acc_status='hold' "; // Get only customer account
            $r=$this->db->query($sql);

            $all_account=array();
            include "c_customer.php";
            include "c_account_type.php";

            while($row=$r->fetch_array())
            {
                $a=new account();
               
                $a->acc_id=$row['acc_id'];
                $a->acc_type=$row['acc_type'];
                $a->branch_id=$row['branch_id'];

                //Get balance from view accbal table
                $sql2="select * from accbal where acc_id=$a->acc_id";
                $r2=$this->db->query($sql2);
                $row2=$r2->fetch_array();
                $a->acc_balance=$row2['bal'];

                $a->acc_created_date=$row['acc_created_date'];
                $a->acc_status=$row['acc_status'];

                //Get customer data from customer table
                $c=new customer();
                $a->cust =   $c->get_customer($row['cus_id']);

                //Get account type information from acc_type_table and assing acctype
                $at=new account_type();
                $a->acctype= $at->get_account_type($row['acc_type']);
                
                
            $all_account[]=$a;
            }
            return $all_account;
        }

        function get_all_accounts_open_in_today($branch_id) // all accounts open in today
        {
            $sql="select * from account_tbl where DATE(acc_created_date) = CURDATE() and branch_id='$branch_id'"; 
            $r=$this->db->query($sql);

            $all_account=array();

            while($row=$r->fetch_array())
            {
                $a=new account();
               
                $a->acc_id=$row['acc_id'];
                $a->cus_id=$row['cus_id'];
                $a->branch_id=$row['branch_id'];
                $a->acc_created_date=$row['acc_created_date'];
                

                include_once "c_account_type.php";
                $at=new account_type();
                $a->accType=$at->get_account_type($row['acc_type']);

                include_once "c_customer.php";
                $cs=new customer();
                $a->cus=$cs->get_customer($row['cus_id']);

                //Get balance from view accbal table
                $sql2="select * from accbal where acc_id=$a->acc_id";
                $r2=$this->db->query($sql2);
                $row2=$r2->fetch_array();
                $a->acc_balance=$row2['bal'];
                
                
            $all_account[]=$a;
            }
            return $all_account;
        }

        function get_all_accounts_opened_in_last_sevenday($branch_id) //last 7 day opened accounts
        {
            $sql="select * from account_tbl where  acc_created_date BETWEEN CURDATE()-7 AND CURDATE() and branch_id='$branch_id'";
            $r=$this->db->query($sql);

            $all_account=array();

            while($row=$r->fetch_array())
            {
                $a=new account();
               
                $a->acc_id=$row['acc_id'];
                $a->cus_id=$row['cus_id'];
                $a->branch_id=$row['branch_id'];
                $a->acc_created_date=$row['acc_created_date'];
                

                include_once "c_account_type.php";
                $at=new account_type();
                $a->accType=$at->get_account_type($row['acc_type']);

                include_once "c_customer.php";
                $cs=new customer();
                $a->cus=$cs->get_customer($row['cus_id']);

                //Get balance from view accbal table
                $sql2="select * from accbal where acc_id=$a->acc_id";
                $r2=$this->db->query($sql2);
                $row2=$r2->fetch_array();
                $a->acc_balance=$row2['bal'];
                
                
            $all_account[]=$a;
            }
            return $all_account;
        }

        function get_all_accounts_opened_in_last_month($branch_id) //last month opened accounts
        {
            $sql="select * from account_tbl where  MONTH(acc_created_date) = MONTH(CURRENT_TIMESTAMP)-1 AND YEAR(acc_created_date) = YEAR(CURRENT_TIMESTAMP) and branch_id='$branch_id'";
            $r=$this->db->query($sql);

            $all_account=array();

            while($row=$r->fetch_array())
            {
                $a=new account();
               
                $a->acc_id=$row['acc_id'];
                $a->cus_id=$row['cus_id'];
                $a->branch_id=$row['branch_id'];
                $a->acc_created_date=$row['acc_created_date'];
                

                include_once "c_account_type.php";
                $at=new account_type();
                $a->accType=$at->get_account_type($row['acc_type']);

                include_once "c_customer.php";
                $cs=new customer();
                $a->cus=$cs->get_customer($row['cus_id']);

                //Get balance from view accbal table
                $sql2="select * from accbal where acc_id=$a->acc_id";
                $r2=$this->db->query($sql2);
                $row2=$r2->fetch_array();
                $a->acc_balance=$row2['bal'];
                
                
            $all_account[]=$a;
            }
            return $all_account;
        }

        function get_all_hold_accounts($branch_id) //last month opened accounts
        {
            $sql="select * from account_tbl where acc_status='hold' and branch_id='$branch_id'";
            $r=$this->db->query($sql);

            $all_account=array();

            while($row=$r->fetch_array())
            {
                $a=new account();
               
                $a->acc_id=$row['acc_id'];
                $a->cus_id=$row['cus_id'];
                $a->branch_id=$row['branch_id'];
                $a->acc_created_date=$row['acc_created_date'];
                $a->acc_status=$row['acc_status'];
                

                include_once "c_account_type.php";
                $at=new account_type();
                $a->accType=$at->get_account_type($row['acc_type']);

                include_once "c_customer.php";
                $cs=new customer();
                $a->cus=$cs->get_customer($row['cus_id']);

                //Get balance from view accbal table
                $sql2="select * from accbal where acc_id=$a->acc_id";
                $r2=$this->db->query($sql2);
                $row2=$r2->fetch_array();
                $a->acc_balance=$row2['bal'];
                
                
            $all_account[]=$a;
            }
            return $all_account;
        }

        function get_all_closed_accounts($branch_id) //last month opened accounts
        {
            $sql="select * from account_tbl where acc_status='closed' and branch_id='$branch_id'";
            $r=$this->db->query($sql);

            $all_account=array();

            while($row=$r->fetch_array())
            {
                $a=new account();
               
                $a->acc_id=$row['acc_id'];
                $a->cus_id=$row['cus_id'];
                $a->branch_id=$row['branch_id'];
                $a->acc_created_date=$row['acc_created_date'];
                $a->acc_status=$row['acc_status'];
                

                include_once "c_account_type.php";
                $at=new account_type();
                $a->accType=$at->get_account_type($row['acc_type']);

                include_once "c_customer.php";
                $cs=new customer();
                $a->cus=$cs->get_customer($row['cus_id']);

                //Get balance from view accbal table
                $sql2="select * from accbal where acc_id=$a->acc_id";
                $r2=$this->db->query($sql2);
                $row2=$r2->fetch_array();
                $a->acc_balance=$row2['bal'];
                
                
            $all_account[]=$a;
            }
            return $all_account;
        }


        function get_all_account_from_nic($id)
        {
            $sql="select * from account_tbl where acc_status='active' and acc_type!=0 and cus_id='$id'"; // Get only customer account
            $r=$this->db->query($sql);

            $all_account=array();
            include "c_customer.php";
            include "c_account_type.php";

            if($r->num_rows>0){
                while($row=$r->fetch_array())
                {
                    $a=new account();
                
                    $a->acc_id=$row['acc_id'];
                    $a->acc_type=$row['acc_type'];
                    $a->branch_id=$row['branch_id'];

                    //Get balance from view accbal table
                    $sql2="select * from accbal where acc_id=$a->acc_id";
                    $r2=$this->db->query($sql2);
                    $row2=$r2->fetch_array();
                    $a->acc_balance=$row2['bal'];

                    $a->acc_created_date=$row['acc_created_date'];
                    $a->acc_status=$row['acc_status'];

                    //Get customer data from customer table
                    $c=new customer();
                    $a->cust =   $c->get_customer($row['cus_id']);

                    //Get account type information from acc_type_table and assing acctype
                    $at=new account_type();
                    $a->acctype= $at->get_account_type($row['acc_type']);
                    
                    
                $all_account[]=$a;
                }
                return $all_account;

            }else{
                return false;
            }
        }

        function last_include_Acc()    //Get last created loan account no
            {
                $sql="SELECT acc_id from account_tbl order by acc_id desc";
                $res=$this->db->query($sql);

                if($res->num_rows>0){
                    
                $row=$res->fetch_array();
                $this->acc_id=$row["acc_id"];
                //echo"$l2->loan_no";
                //return $l2;
                return true;
                }else{
                    return false;
                }
            }

        function last_insert_acc_id(){
            $sql="SELECT max(acc_id) as acc_id FROM account_tbl";
            $res=$this->db->query($sql);
            if($res->num_rows>0){
            $A=new account();
            $row=$res->fetch_array();
            // print_r($row);
            $A->acc_id=$row['acc_id'];
            return $A;
            }else{
                    return false;
            }
            

        }    

        function hold_account($accId) // hold account from account id
            {
                $sql="UPDATE account_tbl set acc_status='hold' WHERE acc_id='$accId'";
               
                $this->db->query($sql);
    
                return true;
                
            } 
            
        function unhold_account($accId) // hold account from account id
            {
                $sql="UPDATE account_tbl set acc_status='active' WHERE acc_id='$accId'";
               
                $this->db->query($sql);
    
                return true;
                
            }
        function closed_account($accId) // hold account from account id
            {
                $sql="UPDATE account_tbl set acc_status='closed' WHERE acc_id='$accId'";
               
                $this->db->query($sql);
    
                return true;
                
            }                  

        function is_exist_account($id)
        {
            $db=new mysqli("localhost","root","","bank");
            $sql="select * from account_tbl where acc_id='$id' and acc_type!=0";
            $res=$db->query($sql);

            include_once "class/c_account_type.php";

            if($res->num_rows>0)
            {  
                
                $row=$res->fetch_array();

                $this->acc_id=$row['acc_id'];

                $acctype=new account_type();     //To get account type name
                $acct=$acctype->get_account_type($row['acc_type']);

                $this->acc_type=$acct->acc_type_name;
                $this->acc_created_date=$row['acc_created_date'];
                $this->acc_status=$row['acc_status'];
                $this->cus_id=$row['cus_id'];
                
                $sql2="select * from accbal where acc_id='$id' LIMIT 1";
                $res2=$db->query($sql2);
                $row2=$res2->fetch_array();

                $this->acc_balance=$row2['bal'];

                return true;
            }else
            {
                return false;
            }
        }

        function is_exist_account_open_in_today($branch_id)// check whether is exist account opend today
        {
            $sql="select * from account_tbl where DATE(acc_created_date) = CURDATE() and branch_id='$branch_id'"; 
            $r=$this->db->query($sql);

            if($r->num_rows>=1)
            {
                return true;
            }else{
                return false;
            }
            
        }

        function is_exist_accounts_opened_in_the_last_sevendays($branch_id)// check whether is exist account opend last 7 day
        {
            $sql="select * from account_tbl where  acc_created_date BETWEEN CURDATE()-7 AND CURDATE() and branch_id='$branch_id' "; 
            $r=$this->db->query($sql);

            if($r->num_rows>=1)
            {
                return true;
            }else{
                return false;
            }
            
            
        }

        function is_exist_accounts_opened_in_the_last_month($branch_id)// check whether is exist account opend in last month
        {
            $sql="select * from account_tbl where MONTH(acc_created_date) = MONTH(CURRENT_TIMESTAMP)-1 AND YEAR(acc_created_date) = YEAR(CURRENT_TIMESTAMP) and branch_id='$branch_id'"; 
            $r=$this->db->query($sql);

            if($r->num_rows>=1)
            {
                return true;
            }else{
                return false;
            }
            
            
        }

        function is_exist_account_untill_now($branch_id)// check whether is exist account opend today
        {
            $sql="select * from account_tbl where acc_status='active' and branch_id='$branch_id'"; 
            $r=$this->db->query($sql);

            if($r->num_rows>=1)
            {
                return true;
            }else{
                return false;
            }
            
        }

        function is_exist_closed_account_untill_now($branch_id)// check whether is exist account opend today
        {
            $sql="select * from account_tbl where acc_status='closed' and branch_id='$branch_id'"; 
            $r=$this->db->query($sql);

            if($r->num_rows>=1)
            {
                return true;
            }else{
                return false;
            }
            
        }

        function is_exist_account_by_nic($id)
        {
            $db=new mysqli("localhost","root","","bank");
            $sql="select * from account_tbl where cus_id='$id' and acc_type!=0";
            $res=$db->query($sql);

            if($res->num_rows>0){
                return true;
            }else{
                return false;
            }
        }

        function is_active_account($acc_id) //check whether account is active
            {
                $sql="select * from account_tbl where acc_id='$acc_id' and acc_status='active'";
                $res=$this->db->query($sql); 

                if($res->num_rows==1)
                {
                    return true;
                }else{
                    return false;
                }
            } 
        
        function is_hold_account($acc_id) //check whether account is active
            {
                $sql="select * from account_tbl where acc_id='$acc_id' and acc_status='hold'";
                $res=$this->db->query($sql); 

                if($res->num_rows==1)
                {
                    return true;
                }else{
                    return false;
                }
            }

        function check_account_before_transfer($acc_id,$cus_id) //check whether when  transfer money one account to another sending account user is valid user.This using customer fund transfer form. 
            {
                $sql="select * from account_tbl where acc_id='$acc_id' and cus_id='$cus_id' and acc_type!=0";
                $res=$this->db->query($sql); 

                if($res->num_rows==1)
                {
                    return true;
                }else{
                    return false;
                }
            }    

            
        function is_exist_specialId($id)
        {
            $sql="select * from account_tbl where cus_id='$id'";
            $res=$this->db->query($sql);

            if($res->num_rows==1)
                {
                    return true;
                }else{
                    return false;
                }
        } 

        function is_exist_hold_accounts($branch_id)
        {
            $sql="select * from account_tbl where acc_status='hold' and branch_id='$branch_id'";
            $res=$this->db->query($sql);

            if($res->num_rows>=1)
                {
                    return true;
                }else{
                    return false;
                }
        } 

        
        function is_exist_branch_account($branch_id) //check whether approved or notapproved loan account exist using loan_no
        {
            $sql="select * from account_tbl where branch_id=$branch_id and acc_type=0";
            $res=$this->db->query($sql); 
    
            if($res->num_rows==1)
            {
                return true;
            }else{
                return false;
            }
        } 
        
        function account_balance_sufficient($acc_id,$credit)
        {
            $sql="select * from accbal where acc_id='$acc_id'";
            $res=$this->db->query($sql);

            $row=$res->fetch_array();
            if($row["bal"]-$credit>=1000){ // assume account hold 1000 rupee
                return true;
            }else{
                return false;
            }
            
        }

        function HeadOfficeAccount_balance_sufficient($acc_id,$credit)
        {
            $sql="select * from accbal where acc_id='$acc_id'";
            $res=$this->db->query($sql);

            $row=$res->fetch_array();
            if($row["bal"]-$credit>=10000000){ // assume account hold 10000000 rupee
                return true;
            }else{
                return false;
            }
            
        }




    
        function display_account_categories(){


            $db=new mysqli("localhost","root","","bank");
            $sql="SELECT * FROM account_category_tbl";
            $r=$db->query($sql);

            $array=array();

            while($row=$r->fetch_array())
            {
                $array[]=[
                    "id"=>$row["acc_category_id"],
                    "name"=>$row["acc_category_name"]

                ];
            }

        echo json_encode($array);
        }

        
        function display_account_types($cat_id){


            $db=new mysqli("localhost","root","","bank");
            $sql="SELECT * FROM account_type_tbl WHERE acc_category_id ='$cat_id'";
            $r=$db->query($sql);

            $array=array();

            while($row=$r->fetch_array())
            {
                $array[]=[
                    "id"=>$row["acc_type_id"],
                    "name"=>$row["acc_type_name"]

                ];
            }

            echo json_encode($array);
        }

    }

?>