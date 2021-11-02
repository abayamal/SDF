<?php

include_once("config.php");

class account_category
{
    public $acc_category_id;
    public $acc_category_name;
    public $date;
    public $note;
    public $acc_category_status;

    private $db;

    function __construct()
    {
        $this->db=new mysqli(host,un,pw,db);
    }

    
    function save_account_category()
    {
        $sql="insert into account_category_tbl(acc_category_name,note)values('$this->acc_category_name','$this->note')";
        $this->db->query($sql);
      
    }

    function get_account_category($id)
    {
        $sql="select * from account_category_tbl where acc_category_id='$id'";
        $res=$this->db->query($sql);

        $row=$res->fetch_array();

        $this->acc_category_id=$row["acc_category_id"];
        $this->acc_category_name=$row["acc_category_name"];
        $this->date=$row["date"];
        $this->note=$row["note"];
        $this->acc_category_status=$row["acc_category_status"];

        return $this;
    }

    function get_all_account_category()
    {
        $sql="select * from account_category_tbl where acc_category_status='active'";
        $res=$this->db->query($sql);
        $all_category=array();


        while($row=$res->fetch_array())
        {
            $ac=new account_category();

            $ac->acc_category_id=$row["acc_category_id"];
            $ac->acc_category_name=$row["acc_category_name"];
            $ac->date=$row["date"];
            $ac->acc_category_status=$row["acc_category_status"];

            $all_category[]=$ac;
        }
        return $all_category;
    }

    function update_account_category()
    {
        $sql="UPDATE account_category_tbl set acc_category_name='$this->acc_category_name',note='$this->note' WHERE acc_category_id=$this->acc_category_id";
       
        $this->db->query($sql);
       
        return true;
    }

    function del_account_category($id)
    {
        $sql="UPDATE account_category_tbl set acc_category_status='delete' WHERE acc_category_id='$id'";
        $this->db->query($sql);
        return true;
    }

}






?>