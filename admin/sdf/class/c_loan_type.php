<?php

include_once("config.php");

class loan_type
{
    public $loan_type_id;
    public $loan_category_id;
    public $loan_type_name;
    public $interest;
    public $date;
    public $note;
    public $loan_type_status;
    

    private $db;

    function __construct()
    {
        $this->db=new mysqli(host,un,pw,db);
    }

    function save_loan_type()
    {
        $sql="insert into loan_type_tbl(loan_category_id,loan_type_name,interest,note)values('$this->loan_category_id','$this->loan_type_name','$this->interest','$this->note')";
        $this->db->query($sql);
      
    }

    function get_loan_type($id)
        {
            $sql="select * from loan_type_tbl where loan_type_id='$id'";
            $res=$this->db->query($sql);
            
            $row=$res->fetch_array();

           $this->loan_type_id=$row["loan_type_id"];
           $this->loan_category_id=$row["loan_category_id"];
           $this->loan_type_name=$row["loan_type_name"];
           $this->interest=$row["interest"];
           $this->note=$row["note"];
           $this->date=$row["date"];
           $this->loan_type_status=$row["loan_type_status"];

            return $this;
        
        }
    
     function get_all_loan_types()
    {
        $sql="select * from loan_type_tbl where loan_type_status='active'";
        $res=$this->db->query($sql);
        $all_types=array();

        include "class/c_account_category.php";
        if($res->num_rows>0){
            while($row=$res->fetch_array())
            {
                $lt=new loan_type();

                $lt->loan_type_id=$row["loan_type_id"];
                include_once "class/c_loan_category.php";
                $lc=new loan_category();
                
                $lt->loan_cat=$lc->get_loan_category($row["loan_category_id"]);
                $lt->loan_type_name=$row["loan_type_name"];
                $lt->interest=$row["interest"];
                $lt->date=$row["date"];
                $lt->loan_type_status=$row["loan_type_status"];

                $all_types[]=$lt;
            }
            return $all_types;
        }else{
            return false;
        }
    }


    function del_loan_type($id)
        {
            $sql="UPDATE loan_type_tbl set loan_type_status='delete' WHERE loan_type_id='$id'";
            $this->db->query($sql);
            return true;
        }  
        
    function update_loan_type()
    {
        $sql="UPDATE loan_type_tbl set loan_category_id='$this->loan_category_id',loan_type_name='$this->loan_type_name',note='$this->note',interest='$this->interest' WHERE loan_type_id=$this->loan_type_id";
       
        $this->db->query($sql);
       
        return true;
    }    

}





?>