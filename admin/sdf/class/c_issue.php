<?php

include("config.php");

class issue
{
    public $Issue_id;
    public $Emp_id;
    public $Loan_id;
    public $Issue_date;
    public $Issue_status;
   
    

    private $db;



    function __construct()
    {
        $this->db=new mysqli(host,un,pw,db);
    }

    function save_issue()
    {
        //$db=new mysqli("localhost","root","","banking");
        $sql="insert into issue(Issue_id,Emp_id,Loan_id,Issue_date)values('$this->Issue_id','$this->Emp_id','$this->Loan_id','$this->Issue_date')";
        
        $this->db->query($sql);
       // $id=$this->db->insert_id;
       // move_uploaded_file($_FILES["pic"]["tmp_name"],"pics/$id.jpg");
    }

    function edit_account()
    {
        $sql="update issue set Issue_id='$this->Issue_id',Emp_id='$this->Emp_id',Loan_id='$this->Loan_id',Issue_date='$this->Issue_date'";

        $this->db->query($sql);
        return true;
    }

    function del_issue($id)
    {
        $sql="delete from issue where Issue_id=$id";
        $this->db->query($sql);
        return true;
    }

    function get_issue($id)
    {
        $sql="select * from issue where Issue_id=$id";
        $res=$this->db->query($sql);
        $row=$res->fetch_array();

        $this->Issue_id=$row['Issue_id'];
        $this->Emp_id=$row['Emp_id'];
        $this->Loan_id=$row['Loan_id'];
        $this->Issue_date=$row['Issue_date'];
        
        return $this;
    
    }

    function get_all_issue()
    {
        $sql="select * from issue where Issue_status='active'";
        $r=$this->db->query($sql);

        $ar=array();

        while($row=$r->fetch_array())
        {
            $Is=new issue();

       
        $Is->Issue_id=$row['Issue_id'];
        $Is->Emp_id=$row['Emp_id'];
        $Is->Loan_id=$row['Loan_id'];
        $Is->Issue_date=$row['Issue_date'];
        

        $all_issue[]=$Is;
        }
        return $Is;
    }



}





?>