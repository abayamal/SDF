<?php

include_once("config.php");

class transaction
{
    public $trans_id;
    public $trans_date;
    public $cus_id;
    public $acc_id;
    public $debit;
    public $re_debit;
    public $credit;
    public $balance;
    public $re_credit;
    public $ref_no;
    public $deposit_branch;
    public $withdraw_branch;
    public $trans_branch;
    public $note;
    public $special_note;
    
    private $db;



    function __construct()
    {
        $this->db=new mysqli(host,un,pw,db);
    }

    function deposit()
    {
            //$db=new mysqli("localhost","root","","bank");
            //save amount deposit_tbl
            $sql="insert into deposit_tbl(acc_id,deposit_branch,amount,note,special_note)
             values('$this->acc_id','$this->deposit_branch','$this->debit','$this->note','$this->special_note')";
             $this->db->query($sql);

            //save amount transaction_tbl
             $sql2="insert into transaction_tbl(acc_id,debit,trans_branch,note,special_note)
             values('$this->acc_id','$this->debit','$this->deposit_branch','$this->note','$this->special_note')";
             //echo $sql2;
             $this->db->query($sql2);

            //To insert balance after transaction in transaction_tbl
            $sql3="SELECT trans_id from transaction_tbl order by trans_id desc";
            $res=$this->db->query($sql3);
            $row=$res->fetch_array();
            $this->trans_id=$row["trans_id"];
            include_once "class/c_account.php";
            $a=new account();
            $a->get_account($this->acc_id);
            $this->balance=$a->acc_balance;

            $sql4="UPDATE transaction_tbl set balance='$this->balance' WHERE trans_id= $this->trans_id";
            $this->db->query($sql4);

            //To insert balance after transaction in deposit_tbl
            $sql3="SELECT trans_id from deposit_tbl order by trans_id desc";
            $res=$this->db->query($sql3);
            $row=$res->fetch_array();
            $t2=new transaction();
            $t2->trans_id=$row["trans_id"];
            include_once "class/c_account.php";
            $a2=new account();
            $a2->get_account($this->acc_id);
            $t2->balance=$a2->acc_balance;

            $sql5="UPDATE deposit_tbl set balance='$t2->balance' WHERE trans_id= $t2->trans_id";
            $this->db->query($sql5);


           

    
    }

    

    function withdraw()
    {
            //$db=new mysqli("localhost","root","","bank");
            //save withdraw amount withdraw_tbl
            $sql="insert into withdraw_tbl(acc_id,withdraw_branch,amount,note,special_note)
             values('$this->acc_id','$this->withdraw_branch','$this->credit','$this->note','$this->special_note')";
             $this->db->query($sql);
             
            //save withdraw amount transaction_tbl
             $sql2="insert into transaction_tbl(acc_id,credit,trans_branch,note,special_note)
             values('$this->acc_id','$this->credit','$this->withdraw_branch','$this->note','$this->special_note')";
             $this->db->query($sql2);

            //To insert balance after transaction in transaction_tbl
            $sql3="SELECT trans_id from transaction_tbl order by trans_id desc";
            $res=$this->db->query($sql3);
            $row=$res->fetch_array();
            $this->trans_id=$row["trans_id"];
            include_once "class/c_account.php";
            $a=new account();
            $a->get_account($this->acc_id);
            $this->balance=$a->acc_balance;

            $sql4="UPDATE transaction_tbl set balance='$this->balance' WHERE trans_id= $this->trans_id";
            $this->db->query($sql4);

            //To insert balance after transaction in withdraw_tbl
            $sql3="SELECT trans_id from withdraw_tbl order by trans_id desc";
            $res=$this->db->query($sql3);
            $row=$res->fetch_array();

            $t2=new transaction();
            $t2->trans_id=$row["trans_id"];
            include_once "class/c_account.php";
            $a2=new account();
            $a2->get_account($this->acc_id);
            $t2->balance=$a2->acc_balance;

            $sql5="UPDATE withdraw_tbl set balance='$t2->balance' WHERE trans_id= $t2->trans_id";
            $this->db->query($sql5);
            
        
    }

    function get_all_transactions($id)
    {
        $sql="SELECT * FROM transaction_tbl where acc_id='$id'";
        $res=$this->db->query($sql);
        
        $alltrans=array();
        while($row=$res->fetch_array()){

            $tr=new transaction();

            $tr->trans_id=$row["trans_id"];
            $tr->trans_date=$row["trans_date"];
            $tr->acc_id=$row["acc_id"];
            $tr->debit=$row["debit"];
            $tr->credit=$row["credit"];
            $tr->balance=$row["balance"];

            $alltrans[]=$tr;
            $tr->db->close();

        }
        return $alltrans;

    }

    function get_all_daily_deposits($branch_id) // all deposits in today
    {
        $sql="select * from deposit_tbl where DATE(date) = CURDATE() and deposit_branch='$branch_id'"; 
        $r=$this->db->query($sql);

        $all_deposits=array();

        while($row=$r->fetch_array())
        {
            $t=new transaction();
           
            $t->trans_id=$row['trans_id'];
            $t->acc_id=$row['acc_id'];
            $t->debit=$row['amount'];
            $t->balance=$row['balance'];
            $t->trans_date=$row['date'];
            $t->note=$row['note'];

            //to get branch name
            include_once "class/c_branch.php";
            $b=new branch();
            $t->branch=$b->get_branch($row['deposit_branch']);

        $all_deposits[]=$t;
        }
        return $all_deposits;
    }

    function get_all_daily_withdrawals($branch_id) // all withdrawals in today
    {
        $sql="select * from withdraw_tbl where DATE(date) = CURDATE() and withdraw_branch='$branch_id'"; 
        $r=$this->db->query($sql);

        $all_withdrawals=array();

        while($row=$r->fetch_array())
        {
            $t=new transaction();
           
            $t->trans_id=$row['trans_id'];
            $t->acc_id=$row['acc_id'];
            $t->credit=$row['amount'];
            $t->balance=$row['balance'];
            $t->trans_date=$row['date'];
            $t->note=$row['note'];

            //to get branch name
            include_once "class/c_branch.php";
            $b=new branch();
            $t->branch=$b->get_branch($row['withdraw_branch']);

        $all_withdrawals[]=$t;
        }
        return $all_withdrawals;
    }

    function get_all_daily_transactions($branch_id) // all transaction in today
    {
        $sql="select * from transaction_tbl where DATE(trans_date) = CURDATE() and trans_branch='$branch_id'"; 
        $r=$this->db->query($sql);

        $all_transactions=array();

        while($row=$r->fetch_array())
        {
            $t=new transaction();
           
            $t->trans_id=$row['trans_id'];
            $t->acc_id=$row['acc_id'];
            $t->credit=$row['credit'];
            $t->debit=$row['debit'];
            $t->balance=$row['balance'];
            $t->trans_date=$row['trans_date'];
            $t->note=$row['note'];

            //to get branch name
            include_once "class/c_branch.php";
            $b=new branch();
            $t->branch=$b->get_branch($row['trans_branch']);

        $all_transactions[]=$t;
        }
        return $all_transactions;
    }

    function get_transaction_between_two_days($from,$to,$accNo)
    {
        $sql="SELECT * FROM transaction_tbl where trans_date >= '$from' 
        AND trans_date <= '$to' and acc_id='$accNo'";
        $res=$this->db->query($sql);
        
        $alltrans=array();
        while($row=$res->fetch_array()){

            $tr=new transaction();

            $tr->trans_id=$row["trans_id"];
            $tr->trans_date=$row["trans_date"];
            $tr->acc_id=$row["acc_id"];
            $tr->debit=$row["debit"];
            $tr->credit=$row["credit"];
            $tr->balance=$row["balance"];

            $alltrans[]=$tr;

        }
        return $alltrans;

    }

    function is_exist_transaction_between_two_days($from,$to,$accNo)
    {
        $sql="SELECT * FROM transaction_tbl where trans_date >= '$from' 
        AND trans_date <= '$to' and acc_id='$accNo'";
        $res=$this->db->query($sql);
        
        if($res->num_rows>0)
        {
            return true;
        }else{
            return false;
        }
        

    }

    function is_exist_daily_deposits($branch_id)// check whether is exist account opend today
    {
        $sql="select * from deposit_tbl where DATE(date) = CURDATE() and deposit_branch='$branch_id'"; 
        $r=$this->db->query($sql);

        if($r->num_rows>=1)
        {
            return true;
        }else{
            return false;
        }
        
    }

    function is_exist_daily_withdrawals($branch_id)// check whether is exist account opend today
    {
        $sql="select * from withdraw_tbl where DATE(date) = CURDATE() and withdraw_branch='$branch_id'"; 
        $r=$this->db->query($sql);

        if($r->num_rows>=1)
        {
            return true;
        }else{
            return false;
        }
        
    }

    function is_exist_daily_transactions($branch_id)// check whether is exist account opend today
    {
        $sql="select * from transaction_tbl where DATE(trans_date) = CURDATE() and trans_branch='$branch_id'"; 
        $r=$this->db->query($sql);

        if($r->num_rows>=1)
        {
            return true;
        }else{
            return false;
        }
        
    }



    

    

    

    

   


}





?>