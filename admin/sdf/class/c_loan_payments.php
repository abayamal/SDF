<?php

include_once("config.php");

class payments
{
    public $loan_no;
    public $payment_no;
    public $acc_id;
    public $amount;
    public $balance;
    public $date;
    public $status;
    
    public $paid_branch;
    public $panalty;

    private $db;



    function __construct()
    {
        $this->db=new mysqli(host,un,pw,db);
    }

    function save_payment_shedule()
    {
         //$db=new mysqli("localhost","root","","bank");
         $sql="insert into loan_payments_tbl(loan_no,payment_no,acc_id,amount,balance,date)
         values('$this->loan_no','$this->payment_no','$this->acc_id','$this->amount','$this->balance','$this->date')";
         $this->db->query($sql);

        //  $sql2="UPDATE loan_tbl set status='approved' where loan_no=$this->loan_no";
        //  $this->db->query($sql2);

    }

    function save_payment_history()
    {
         //$db=new mysqli("localhost","root","","bank");
         $sql="insert into loan_payments_history_tbl(loan_no,payment_no,paid_branch,acc_id,amount,panalty)
         values('$this->loan_no','$this->payment_no','$this->paid_branch','$this->acc_id','$this->amount','$this->panalty')";
         $this->db->query($sql);
         

    }

    function get_all_payments_from_LoanNo($LoanNo) // Get list of payment paticuler loan number
        {
            $sql="select * from loan_payments_tbl where loan_no='$LoanNo'"; 
            $r=$this->db->query($sql);

            $all_payments=array();

            while($row=$r->fetch_array())
            {
                $p=new payments();
               
                $p->loan_no=$row['loan_no'];
                $p->payment_no=$row['payment_no'];
                $p->amount=$row['amount'];
                $p->balance=$row['balance'];
                $p->date=$row['date'];
                $p->status=$row['status'];
                
            $all_payments[]=$p;
            }
            return $all_payments;
        }

    function get_all_daily_payments($branch_id) ////can get only all not approved loan account
        {
            $sql="select * from loan_payments_history_tbl where DATE(date) = CURDATE() and paid_branch='$branch_id'";
            $r=$this->db->query($sql);

            $all_payments=array();
            while($row=$r->fetch_array())
            {
                $l=new payments();
                $l->loan_no=$row['loan_no'];
                $l->payment_no=$row['payment_no'];
                $l->acc_id=$row['acc_id'];
                $l->amount=$row['amount'];
                $l->panalty=$row['panalty'];
                $l->date=$row['date'];

                //to get paid branch
                include_once "class/c_branch.php";
                $b=new branch();
                $l->branch=$b->get_branch($row['paid_branch']);
              

                $all_payments[]=$l;
            }
            return $all_payments;
        } 

    
    function get_number_of_remaining_payments($LoanNo) // Get list of payment paticuler loan number
        {
            $sql="select * from loan_payments_tbl where loan_no='$LoanNo' and status='active'"; 
            $r=$this->db->query($sql);

            $this->number_of_payments=$r->num_rows;
            return $this;
        }
    
    function get_number_of_complete_payments($LoanNo) // Get list of payment paticuler loan number
        {
            $sql="select * from loan_payments_tbl where loan_no='$LoanNo' and status='paid'"; 
            $r=$this->db->query($sql);

            $this->number_of_complete_payments=$r->num_rows;
            return $this;
        }    
    
        




    function get_payment_this_month($LoanNo) // Get current month payment details
        {
            $sql="select * from loan_payments_tbl where MONTH(date) = MONTH(CURRENT_DATE())
            AND YEAR(date) = YEAR(CURRENT_DATE())  AND loan_no='$LoanNo'";
            $res=$this->db->query($sql);
        
            if($res->num_rows>0){

            $row=$res->fetch_array();

           
            $this->loan_no=$row['loan_no'];
            $this->payment_no=$row['payment_no'];
            $this->acc_id=$row['acc_id'];
            $this->amount=$row['amount'];
            $this->balance=$row['balance'];
            $this->date=$row['date'];
            $this->status=$row['status'];

                return true;

        }else{
                return false;
            }
            
        
        }
    
    function get_payment($LoanNo,$payNo) // Get paticuler payment
        {
            $sql="select * from loan_payments_tbl where loan_no='$LoanNo' and payment_no='$payNo'";
            $res=$this->db->query($sql);
        
            if($res->num_rows>0){

            $row=$res->fetch_array();

           
            $this->loan_no=$row['loan_no'];
            $this->payment_no=$row['payment_no'];
            $this->acc_id=$row['acc_id'];
            $this->amount=$row['amount'];
            $this->balance=$row['balance'];
            $this->date=$row['date'];
            $this->status=$row['status'];

                return true;

        }else{
                return false;
            }
            
        
        }    

    function is_exist_payment_this_month($LoanNo)
        {
            $sql="select * from loan_payments_tbl where MONTH(date) = MONTH(CURRENT_DATE())
            AND YEAR(date) = YEAR(CURRENT_DATE()) AND date >= CURRENT_DATE() AND loan_no='$LoanNo' AND status='active'";
            $res=$this->db->query($sql);

            if($res->num_rows>0){
                return true;
            }else{
                return false;
            }
   
        }
    
    function is_exist_remaining_payments($LoanNo) // Get list of payment paticuler loan number
        {
            $sql="select * from loan_payments_tbl where loan_no='$LoanNo' and status='active'"; 
            $r=$this->db->query($sql);

            if($r->num_rows>0){
                return true;
            }else{
                return false;
            }
        }    


    
    function payment_done($loanNo,$payNo,$panalty)
        {
            $sql="UPDATE loan_payments_tbl set status='paid' WHERE loan_no='$loanNo' and payment_no='$payNo'";
            $this->db->query($sql);

            return true;
        } 
        
        
        function payment_done_from_customer($loanNo,$payNo,$panalty,$amount,$AccNo)
        {
            $sql="UPDATE loan_payments_tbl set status='paid' WHERE loan_no='$loanNo' and payment_no='$payNo'";
            $this->db->query($sql);

            //withdraw monthely loanpayment due panalty from customer account
            include_once "class/c_transaction.php";
            $t3=new transaction();
            $t3->acc_id=$AccNo; 
            $t3->acc_branch=$_SESSION["uu"]["branch_id"];
            $t3->credit=$panalty;
            $t3->note="Due payment panalty";
            $t3->withdraw();
            
            //withdraw monthely loan payment amount from customer account
            include_once "class/c_transaction.php";
            $t3=new transaction();
            $t3->acc_id=$AccNo; 
            $t3->acc_branch=$_SESSION["uu"]["branch_id"];
            $t3->credit=$amount;
            $t3->note="Loan payment";
            $t3->withdraw();

            return true;
        }    
    

        function get_due_payments($LoanNo) // Get previous due payment
        {

            $sql="select * from loan_payments_tbl where date < CURRENT_DATE() AND loan_no='$LoanNo' AND status='active' ORDER BY date ASC";
            $res=$this->db->query($sql);

            $all=array();
            if($res->num_rows>0){

          while($row=$res->fetch_array()){

            $a=new payments();
          $a->loan_no=$row['loan_no'];
          $a->payment_no=$row['payment_no'];
          $a->acc_id=$row['acc_id'];
          $a->amount=$row['amount'];
          $a->balance=$row['balance'];
          $a->date=$row['date'];
          $a->status=$row['status'];

          $all[]=$a;
          }
                return $all;
            }else{
                return false;
            }
        }

        function is_exist_due_payments($LoanNo)
            {
                $sql="select * from loan_payments_tbl where date < CURRENT_DATE() AND loan_no='$LoanNo' AND status='active' ORDER BY date ASC";
                $res=$this->db->query($sql);

                if($res->num_rows>0){
                    return true;
                }else{
                    return false;
                }

        }

        function is_exist_daily_payments($branch_id)
        {
            $sql="select * from loan_payments_history_tbl where DATE(date) = CURDATE() and paid_branch='$branch_id'";
            $res=$this->db->query($sql);

            if($res->num_rows>0){
                return true;
            }else{
                return false;
            }

    }



}
?>





