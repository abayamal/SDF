<?php

include_once("config.php");

class account_type
{
    public $acc_type_id;
    public $acc_category_id;
    public $acc_type_name;
    public $interest;
    public $open_amount;
    public $acc_type_description;
    public $acc_type_status;
    
    

    private $db;

    function __construct()
    {
        $this->db=new mysqli(host,un,pw,db);
    }

    function save_account_type()
    {
        $sql="insert into account_type_tbl(acc_category_id,acc_type_name,interest,open_amount,acc_type_description)values('$this->category_id','$this->type_name','$this->interest','$this->open_amount','$this->description')";
        $this->db->query($sql);
      
    }

    function update_account_type()
    {
        $sql="UPDATE account_type_tbl set acc_category_id='$this->acc_category_id',acc_type_name='$this->acc_type_name',interest='$this->interest',open_amount='$this->open_amount',acc_type_description='$this->acc_type_description' WHERE acc_type_id=$this->acc_type_id";
       
        $this->db->query($sql);
       
        return true;
    }

    function del_account_type($id)
    {
        $sql="UPDATE account_type_tbl set acc_type_status='delete' WHERE acc_type_id='$id'";
        $this->db->query($sql);
        return true;
    }

    function get_account_type($id)
    {
        $sql="select * from account_type_tbl where acc_type_id='$id'";
        $res=$this->db->query($sql);
        $row=$res->fetch_array();

        $this->acc_type_id=$row["acc_type_id"];
        $this->acc_category_id=$row["acc_category_id"];
        $this->acc_type_name=$row["acc_type_name"];
        $this->interest=$row["interest"];
        $this->open_amount=$row["open_amount"];
        $this->acc_type_description=$row["acc_type_description"];
        

        return $this;
    }

    function get_all_account_types()
    {
        $sql="select * from account_type_tbl where acc_type_status='active'";
        $res=$this->db->query($sql);
        $all_types=array();

        include "class/c_account_category.php";
        if($res->num_rows>0){
            while($row=$res->fetch_array())
            {
                $at=new account_type();

                $at->acc_type_id=$row["acc_type_id"];
                
                $ac=new account_category();
                
                $at->acc_cat=$ac->get_account_category($row["acc_category_id"]);
                $at->acc_type_name=$row["acc_type_name"];
                $at->open_amount=$row["open_amount"];
                $at->interest=$row["interest"];
                $at->acc_type_status=$row["acc_type_status"];

                $all_types[]=$at;
            }
            return $all_types;
        }else{
            return false;
        }
    }

    // function get_account_type($id)
    // {
    //     $sql="select * from account_type_tbl where acc_type_id=$id";
    //     $res=$this->db->query($sql);
    //     $row=$res->fetch_array();

    //     $this->acc_type_id=$row['acc_type_id'];
    //     $this->acc_category_id=$row['acc_category_id'];
    //     $this->acc_type_name=$row['acc_type_name'];
    //     $this->interest=$row['interest'];
    //     $this->acc_type_status=$row['acc_type_status'];
          
    //     return $this;
    
    // }


    // function get_all_account_type()
    // {
    //     $sql="select * from account_type where Ac_type_status='active'";
    //     $r=$this->db->query($sql);

    //     $ar=array();

    //     while($row=$r->fetch_array())
    //     {
    //         $a=new account_type();

       
    //         $a->Type_id=$row['Type_id'];
    //         $a->Type_name=$row['Type_name'];
            
            

    //     $all_account_type[]=$a;
    //     }
    //     return $a;
    // }



}





?>