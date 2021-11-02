<?php


include_once("config.php");

class loan
{
    public $loan_no;
    public $loan_category_id;
    public $loan_type_id;
    public $cus_id;
    public $spouse_id;
    public $grtr_id;
    public $g_spouse_id;
    public $acc_id;
    public $branch_id;
    public $date;
    public $amount;
    public $full_amount;
    public $int_amount;
    public $interest;
    public $repayment_period;
    public $purpose;
    public $status;
    

    private $db;



    function __construct()
    {
        $this->db=new mysqli(host,un,pw,db);
    }

    function save_loan()
    {
         //$db=new mysqli("localhost","root","","bank");
         $sql="insert into loan_tbl(loan_no,cus_id,spouse_id,grtr_id,acc_id,branch_id,loan_category_id,loan_type_id,amount,repayment_period,purpose)
         values('$this->loan_no','$this->cus_id','$this->spouse_id','$this->grtr_id','$this->acc_id','$this->branch_id','$this->loan_category_id','$this->loan_type_id','$this->amount','$this->repayment_period','$this->purpose')";
         $this->db->query($sql);

        //Interest rate save in loan_lable get from loan_type_table
         include "c_loan_type.php";
         $lty=new loan_type();
         $lty->get_loan_type($this->loan_type_id);

         $l=new loan();
         $l->last_include_loanAcc();//Get last created loan number

         $sql2="UPDATE loan_tbl set interest='$lty->interest' WHERE loan_no= $l->loan_no";
         $this->db->query($sql2);


    }

    function get_loan_account($id)  //can get approved or notapproved loan account using NIC
        {
            $sql="select * from loan_tbl where cus_id='$id'";
            $res=$this->db->query($sql);
            
            $row=$res->fetch_array();

           $this->loan_no=$row["loan_no"];
           $this->cus_id=$row["cus_id"];
           $this->spouse_id=$row["spouse_id"];
           $this->grtr_id=$row["grtr_id"];
           $this->g_spouse_id=$row["g_spouse_id"];
           $this->acc_id=$row["acc_id"];
           $this->loan_category_id=$row["loan_category_id"];
           $this->loan_type_id=$row["loan_type_id"];
           $this->amount=$row["amount"];
           $this->interest=$row["interest"];
           $this->repayment_period=$row["repayment_period"];
           $this->purpose=$row["purpose"];
           $this->date=$row["date"];

           include_once "c_customer.php";
           $p=new customer();
           $this->per=$p->get_customer($row["cus_id"]);

           include_once "c_loan_category.php";
           $lc =new loan_category();
           $this->loanCategory=$lc->get_loan_category($row["loan_category_id"]);

           include_once "c_loan_type.php";
           $lt =new loan_type();
           $this->loanType=$lt->get_loan_type($row["loan_type_id"]);
           
           include_once "c_spouse.php";
           $sp=new spouse();
           $this->spouse=$sp->get_spouse($row["spouse_id"]);

           include_once "c_guarantor.php";
           $g=new guarantor();
           $this->guarantor=$g->get_guarantor($row["grtr_id"]);

           $sp2=new spouse();
           $this->g_spouse=$sp2->get_spouse($row["g_spouse_id"]);

           include_once "c_asset.php";
           $as=new asset();
           $this->applicantAsset=$as->get_asset($row["cus_id"]);

           $as2=new asset();
           $this->guarantAsset=$as->get_asset($row["grtr_id"]);
            return $this;
        
        }

    function get_loan_account_loanNo($ln)   //can get approved or notapproved loan account using Loan Number
        {
            $sql="select * from loan_tbl where loan_no='$ln'"; 
            $res=$this->db->query($sql);  
            
            $row=$res->fetch_array();

           $this->loan_no=$row["loan_no"];
           $this->cus_id=$row["cus_id"];
           $this->branch_id=$row["branch_id"];
           $this->spouse_id=$row["spouse_id"];
           $this->grtr_id=$row["grtr_id"];
           $this->g_spouse_id=$row["g_spouse_id"];
           $this->acc_id=$row["acc_id"];
           $this->loan_category_id=$row["loan_category_id"];
           $this->loan_type_id=$row["loan_type_id"];
           $this->amount=$row["amount"];
           $this->full_amount=$row["full_amount"];
           $this->interest=$row["interest"];
           $this->repayment_period=$row["repayment_period"];
           $this->purpose=$row["purpose"];
           $this->date=$row["date"];

           include_once "c_customer.php";
           $p=new customer();
           $this->per=$p->get_customer($row["cus_id"]);

           include_once "c_loan_category.php";
           $lc =new loan_category();
           $this->loanCategory=$lc->get_loan_category($row["loan_category_id"]);

           include_once "c_loan_type.php";
           $lt =new loan_type();
           $this->loanType=$lt->get_loan_type($row["loan_type_id"]);

           include_once "c_spouse.php";
           $sp=new spouse();
           $this->spouse=$sp->get_spouse($row["spouse_id"]);

           include_once "c_guarantor.php";
           $g=new guarantor();
           $this->guarantor=$g->get_guarantor($row["grtr_id"]);

           $sp2=new spouse();
           $this->g_spouse=$sp2->get_spouse($row["g_spouse_id"]);

           include_once "c_asset.php";
           $as=new asset();
           $this->applicantAsset=$as->get_asset($row["cus_id"]);

           include_once "c_asset.php";
           $as2=new asset();
           $this->guarantAsset=$as->get_asset($row["grtr_id"]);
            return $this;
        
        }


    function get_approved_loan_account_loanNo($ln) // can get only approved loan account using loan number
        {
            $sql="select * from loan_tbl where loan_no='$ln' and status='approved'"; 
            $res=$this->db->query($sql);  
            
            $row=$res->fetch_array();

           $this->loan_no=$row["loan_no"];
           $this->cus_id=$row["cus_id"];
           $this->spouse_id=$row["spouse_id"];
           $this->grtr_id=$row["grtr_id"];
           $this->g_spouse_id=$row["g_spouse_id"];
           $this->acc_id=$row["acc_id"];
           $this->loan_category_id=$row["loan_category_id"];
           $this->loan_type_id=$row["loan_type_id"];
           $this->amount=$row["amount"];
           $this->interest=$row["interest"];
           $this->repayment_period=$row["repayment_period"];
           $this->purpose=$row["purpose"];
           $this->date=$row["date"];

           include_once "c_customer.php";
           $p=new customer();
           $this->per=$p->get_customer($row["cus_id"]);

           include_once "c_loan_category.php";
           $lc =new loan_category();
           $this->loanCategory=$lc->get_loan_account($row["loan_category_id"]);

           include_once "c_loan_type.php";
           $lt =new loan_type();
           $this->loanType=$lt->get_loan_type($row["loan_type_id"]);

           $sp=new spouse();
           $this->spouse=$sp->get_spouse($row["spouse_id"]);

           $g=new guarantor();
           $this->guarantor=$g->get_guarantor($row["grtr_id"]);

           $sp2=new spouse();
           $this->g_spouse=$sp2->get_spouse($row["spouse_id"]);

           include_once "c_asset.php";
           $as=new asset();
           $this->applicantAsset=$as->get_asset($row["cus_id"]);

           $as2=new asset();
           $this->guarantAsset=$as->get_asset($row["grtr_id"]);
            return $this;
        
        }    

    function get_branch_account($branchId) //get branch account using branch_id
        {
            $db=new mysqli("localhost","root","","bank");
            $sql="select * from loan_tbl where branch_id='$branchId'";
            $res=$db->query($sql);

            $row=$res->fetch_array();

            $this->acc_id=$row['acc_id'];

            return $this;
        
        } 
        
    
     function last_include_loanAcc()    //Get last created loan account no
     {
        $sql="SELECT loan_no from loan_tbl order by loan_no desc";
        $res=$this->db->query($sql);

        $row=$res->fetch_array();
        $this->loan_no=$row["loan_no"];
        //echo"$l2->loan_no";
        //return $l2;
     }

     function update_g_spouse_id_loan_tbl()
    {
        $sql="SELECT loan_no from loan_tbl order by loan_no desc"; //Get last insert record in loan_tbl
        $res=$this->db->query($sql);
        $row=$res->fetch_array();
        $this->loan_no=$row["loan_no"];

        $sql2="UPDATE loan_tbl set g_spouse_id='$this->g_spouse_id' WHERE loan_no=$this->loan_no";//add g_spouse_id in loan_tbl
        $this->db->query($sql2);
       
        return true;
    }

    function get_all_approved_loan_account($id,$branch_id) //can get only all approved loan account from customer nic
        {
            $sql="select * from loan_tbl where cus_id='$id' and status='approved' and branch_id='$branch_id'";
            $r=$this->db->query($sql);
    
            $ar=array();
            
            if($r->num_rows>0){
                while($row=$r->fetch_array())
                {
                    $l=new loan();
                $l->loan_no=$row['loan_no'];
                $l->cus_id=$row['cus_id'];
                $l->amount=$row['amount'];
                $l->date=$row['date'];
            
                $all_loan[]=$l;
                }
                return $all_loan;
            }else{
                return false;
            }
        }    

    function get_all_notapproved_loans($branchId) ////can get only all not approved loan account
        {
            $sql="select * from loan_tbl where status='not approved' and branch_id=$branchId";
            $r=$this->db->query($sql);
            
            while($row=$r->fetch_array())
            {
                $l=new loan();

                $l->loan_no=$row['loan_no'];
                $l->cus_id=$row['cus_id'];
                $l->amount=$row['amount'];
                $l->date=$row['date'];

                $all_loan[]=$l;
            }
            return $all_loan;
        } 

    function get_all_approved_loan_today($branch_id) ////can get only all not approved loan account
        {
            $sql="select * from loan_adjustment_tbl where DATE(date) = CURDATE() and branch_id='$branch_id' and status='approved'";
            $r=$this->db->query($sql);
            
            while($row=$r->fetch_array())
            {
                $l=new loan();
                $lo=$l->get_loan_account_loanNo($row['loan_no']);

                //get loan details from loan table
                $l2=new loan();
                $l2->loan_no=$lo->loan_no;
                $l2->cus_id=$lo->cus_id;
                $l2->acc_id=$lo->acc_id;
                $l2->amount=$lo->amount;
                $l2->interest=$lo->interest;

                //get customer details
                include_once "class/c_customer.php";
                $c=new customer();
                $l2->cus=$c->get_customer($lo->cus_id);

                //get loan type details
                include_once "class/c_loan_type.php";
                $lt=new loan_type();
                $l2->loanType=$lt->get_loan_type($lo->loan_type_id);

               

                $all_loan[]=$l2;
            }
            return $all_loan;
        } 
        
    function get_all_approved_loan_untill_now($branch_id) ////can get only all not approved loan account
        {
            $sql="select * from loan_adjustment_tbl where  branch_id='$branch_id' and status='approved'";
            $r=$this->db->query($sql);
            
            while($row=$r->fetch_array())
            {
                $l=new loan();
                $lo=$l->get_loan_account_loanNo($row['loan_no']);

                //get loan details from loan table
                $l2=new loan();
                $l2->loan_no=$lo->loan_no;
                $l2->cus_id=$lo->cus_id;
                $l2->acc_id=$lo->acc_id;
                $l2->amount=$lo->amount;
                $l2->interest=$lo->interest;

                //get customer details
                include_once "class/c_customer.php";
                $c=new customer();
                $l2->cus=$c->get_customer($lo->cus_id);

                //get loan type details
                include_once "class/c_loan_type.php";
                $lt=new loan_type();
                $l2->loanType=$lt->get_loan_type($lo->loan_type_id);

               

                $all_loan[]=$l2;
            }
            return $all_loan;
        }    

    function is_the_loan_approved($id) //check whether loan approve or not using by NIC
        {
            $sql="select * from loan_tbl where cus_id='$id' and status='approved'";
            $res=$this->db->query($sql); 

            if($res->num_rows>0)
            {
                return true;
            }else{
                return false;
            }
        }

    function is_the_approved_loanNo($ln) //check whether loan approve or not using by loan number
        {
            $sql="select * from loan_tbl where loan_no='$ln' and status='approved'";
            $res=$this->db->query($sql); 

            if($res->num_rows>0)
            {
                return true;
            }else{
                return false;
            }
        }

    function loan_approved() //after click approved button this function will run
        {
            $sql2="UPDATE loan_tbl set status='approved',full_amount=$this->full_amount,int_amount=$this->int_amount where loan_no=$this->loan_no";
            $this->db->query($sql2);

            $sql3="insert into loan_adjustment_tbl(loan_no,branch_id,status)
            values('$this->loan_no','$this->branch_id','approved')";
            $this->db->query($sql3);
        }

    function loan_reject() //after click approved button this function will run
        {
            $sql2="UPDATE loan_tbl set status='reject' where loan_no=$this->loan_no";
            $this->db->query($sql2);

            $sql3="insert into loan_adjustment_tbl(loan_no,status)
            values('$this->loan_no','rejected')";
            $this->db->query($sql3);
        }    
    
    function is_many_loan_account($id) //check many loan account approved or not approved
    {
        $sql="select * from loan_tbl where cus_id='$id'";
        $res=$this->db->query($sql); 

        if($res->num_rows>0 && $res->num_rows>1 )
        {
            return true;
        }else{
            return false;
        }
    }    

    function is_exist_atleast_one_loan_account($id) //check whether approved or notapproved loan account exist using NIC
    {
        $sql="select * from loan_tbl where cus_id='$id'";
        $res=$this->db->query($sql); 

        if($res->num_rows>0)
        {
            return true;
        }else{
            return false;
        }
    } 

    function is_exist_loan_account($loanNo) //check whether approved or notapproved loan account exist using loan_no
    {
        $sql="select * from loan_tbl where loan_no='$loanNo'";
        $res=$this->db->query($sql); 

        if($res->num_rows==1)
        {
            return true;
        }else{
            return false;
        }
    } 

    function is_exist_notapproved_loans($branchId)
    {
        $sql="select * from loan_tbl where status='not approved' and branch_id=$branchId";
        $res=$this->db->query($sql); 

        if($res->num_rows>0)
        {
            return true;
        }else{
            return false;
        }
    } 

    function is_exist_approved_loan_today($branch_id) //check whether today approved loan
    {
        $sql="select * from loan_adjustment_tbl where DATE(date) = CURDATE() and branch_id='$branch_id' and status='approved'";
        $res=$this->db->query($sql); 

        if($res->num_rows>0)
        {
            return true;
        }else{
            return false;
        }
    } 

    function is_exist_approved_loan_untill_now($branch_id) //check whether anyday approved loan
    {
        $sql="select * from loan_adjustment_tbl where branch_id='$branch_id' and status='approved'";
        $res=$this->db->query($sql); 

        if($res->num_rows>0)
        {
            return true;
        }else{
            return false;
        }
    } 
    


    

    function display_loan_categories(){


        $db=new mysqli("localhost","root","","bank");
        $sql="SELECT * FROM loan_category_tbl";
        $r=$db->query($sql);

        $array=array();

        while($row=$r->fetch_array())
        {
            $array[]=[
                "id"=>$row["loan_category_id"],
                "name"=>$row["loan_category_name"]

            ];
        }

    echo json_encode($array);
    }

    function display_loan_types($cat_id){


        $db=new mysqli("localhost","root","","bank");
        $sql="SELECT * FROM loan_type_tbl WHERE loan_category_id ='$cat_id'";
        $r=$db->query($sql);

        $array=array();

        while($row=$r->fetch_array())
        {
            $array[]=[
                "id"=>$row["loan_type_id"],
                "name"=>$row["loan_type_name"]

            ];
        }

        echo json_encode($array);
    }



}





?>