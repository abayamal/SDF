<?php

include_once("config.php");

class loan_category
{
    public $loan_category_id;
    public $loan_category_name;
    public $date;
    public $note;
    public $status;
    

    private $db;

    function __construct()
    {
        $this->db=new mysqli(host,un,pw,db);
    }

    
    function save_loan_category()
    {
        $sql="insert into loan_category_tbl(loan_category_name,note)values('$this->loan_category_name','$this->note')";
        $this->db->query($sql);
      
    }

    function get_loan_category($id)
        {
            $sql="select * from loan_category_tbl where loan_category_id='$id'";
            $res=$this->db->query($sql);
            
            $row=$res->fetch_array();

           $this->loan_category_id=$row["loan_category_id"];
           $this->loan_category_name=$row["loan_category_name"];
           $this->date=$row["date"];
           $this->note=$row["note"];
           $this->status=$row["status"];

            return $this;
        
        }

    function get_all_loan_category()
        {
            $sql="select * from loan_category_tbl where status='active'";
            $res=$this->db->query($sql);
            $all_category=array();


            while($row=$res->fetch_array())
            {
                $lc=new loan_category();

                $lc->loan_category_id=$row["loan_category_id"];
                $lc->loan_category_name=$row["loan_category_name"];
                $lc->date=$row["date"];
                $lc->status=$row["status"];

                $all_category[]=$lc;
            }
            return $all_category;
        }
        
    function del_loan_category($id)
        {
            $sql="UPDATE loan_category_tbl set status='delete' WHERE loan_category_id='$id'";
            $this->db->query($sql);
            return true;
        }    

    function update_loan_category()
        {
            $sql="UPDATE loan_category_tbl set loan_category_name='$this->loan_category_name',note='$this->note' WHERE loan_category_id=$this->loan_category_id";
        
            $this->db->query($sql);
        
            return true;
        }    

}






?>