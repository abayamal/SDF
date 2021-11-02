<?php

include_once("config.php");

class branch
{
    public $branch_id;
    public $acc_id;
    public $branch_name;
    public $branch_city;
    public $branch_phone;
    public $branch_manager_id;
    public $branch_status;
    
    private $db;

    function __construct()
    {
        $this->db=new mysqli(host,un,pw,db);
    }

    function save_branch()
    {
        
        $sql="insert into branch_tbl(branch_name,branch_city,branch_phone,branch_manager_id)values('$this->branch_name','$this->branch_city','$this->branch_phone','$this->branch_manager_id')";
        
        $this->db->query($sql);
        // $this->branch_id = $this->db->insert_id;
    
    }

    function del_branch($id)
    {
        $sql="UPDATE branch_tbl set branch_status='delete' where branch_id=$id";
        $this->db->query($sql);
        
    }

    function edit_branch()
    {
        $sql="UPDATE branch_tbl set branch_name='$this->branch_name',branch_city='$this->branch_city',branch_phone='$this->branch_phone',branch_manager_id='$this->branch_manager_id' WHERE branch_id=$this->branch_id";
       
        $this->db->query($sql);
       
        return true;
    }

    function update_acc_id($branchId)
    {
        $sql="UPDATE branch_tbl set acc_id='$this->acc_id' WHERE branch_id=$branchId";
       
        $this->db->query($sql);
       
        return true;
    }

    function get_branch($id)
    {
        $sql="select * from branch_tbl where branch_id='$id'";
        $res=$this->db->query($sql);
        $row=$res->fetch_array();

        $this->branch_id=$row['branch_id'];
        $this->branch_name=$row['branch_name'];
        $this->branch_city=$row['branch_city'];
        $this->branch_phone=$row['branch_phone'];
        $this->branch_manager_id=$row['branch_manager_id'];
        
        
        return $this;
    
    }

    function get_all_branch()
    {
        $sql="select * from branch_tbl where branch_status='active'";
        $r=$this->db->query($sql);

        if($r->num_rows>0){
        $ar=array();

        while($row=$r->fetch_array())
        {
            $br=new branch();

        $br->branch_id=$row['branch_id'];
        $br->branch_name=$row['branch_name'];
        $br->branch_city=$row['branch_city'];
        $br->branch_phone=$row['branch_phone'];
        $br->branch_manager_id=$row['branch_manager_id'];
            
        $all_branch[]=$br;
        }
        return $all_branch;

    }else{
        return false;
    }
    }

    function is_exist_branch($branch) //check whether approved or notapproved loan account exist using loan_no
    {
        $sql="select * from branch_tbl where branch_name='$branch'";
        $res=$this->db->query($sql); 

        if($res->num_rows==1)
        {
            return true;
        }else{
            return false;
        }
    } 


    



    function display_sdf_branch(){


        $db=new mysqli("localhost","root","","bank");
        $sql="SELECT * FROM branch_tbl";
        $r=$db->query($sql);

        $array=array();

        while($row=$r->fetch_array())
        {
            $array[]=[
                "id"=>$row["branch_id"],
                "name"=>$row["branch_name"]

            ];
        }

    echo json_encode($array);
    }

}





?>