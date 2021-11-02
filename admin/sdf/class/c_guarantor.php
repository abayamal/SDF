<?php
include_once("config.php");

class guarantor
{
    public $grtr_id;
    public $type;
    public $grtr_first_name;
    public $grtr_last_name;
    public $grtr_full_name;
    public $grtr_address;
    public $grtr_telephone;
    public $grtr_email;
    public $grtr_gender;
    public $grtr_dob;
    public $grtr_age;
    public $grtr_status;
    public $grtr_designation;
    public $grtr_designation_state;
    public $grtr_monthely_income;
  

    public $branch_id;
   

    private $db;

    function __construct()
    {
        $this->db=new mysqli(host,un,pw,db);
    }

function save_guarantor()
    {
        
        $sql="insert into guarantor_tbl(grtr_id,grtr_first_name,grtr_last_name,grtr_full_name,grtr_designation,grtr_designation_state,grtr_monthely_income,grtr_address,grtr_telephone,grtr_email,grtr_gender,grtr_dob)
            values('$this->grtr_id','$this->grtr_first_name','$this->grtr_last_name','$this->grtr_full_name','$this->grtr_designation','$this->grtr_designation_state','$this->grtr_monthely_income','$this->grtr_address','$this->grtr_telephone','$this->grtr_email','$this->grtr_gender','$this->grtr_dob')";
        $this->db->query($sql);
       
    }

function get_guarantor($id)
        {
            $db = new mysqli("localhost","root","","bank");
            $sql="select * from guarantor_tbl where grtr_id=$id";
            $res=$db->query($sql);

            
                $row=$res->fetch_array();

                $this->grtr_id=$row['grtr_id'];
                $this->type=$row['type'];
                $this->grtr_first_name=$row['grtr_first_name'];
                $this->grtr_last_name=$row['grtr_last_name'];
                $this->grtr_full_name=$row['grtr_full_name'];
                $this->grtr_address=$row['grtr_address'];
                $this->grtr_telephone=$row['grtr_telephone'];
                $this->grtr_email=$row['grtr_email'];
                $this->grtr_gender=$row['grtr_gender'];
                $this->grtr_dob=$row['grtr_dob'];
                $this->grtr_status=$row['grtr_status'];
                $this->grtr_designation=$row['grtr_designation'];
                $this->grtr_designation_state=$row['grtr_designation_state'];
                
                return $this;
            
        }  

    function is_exist_guarantor($id)
        {
            $db=new mysqli("localhost","root","","bank");
            $sql="select * from guarantor_tbl where grtr_id='$id'";
            $res=$db->query($sql);

            if($res->num_rows>0){
                return true;
            }else{
                return false;
            }
        }

    function update_guarantor()
        {
            $sql="UPDATE guarantor_tbl set grtr_first_name='$this->grtr_first_name',grtr_last_name='$this->grtr_last_name',grtr_full_name='$this->grtr_full_name',grtr_designation='$this->grtr_designation',grtr_designation_state='$this->grtr_designation_state',grtr_monthely_income='$this->grtr_monthely_income',grtr_address='$this->grtr_address',grtr_telephone='$this->grtr_telephone',grtr_email='$this->grtr_email',grtr_gender='$this->grtr_gender',grtr_dob='$this->grtr_dob' WHERE grtr_id=$this->grtr_id";
           
            $this->db->query($sql);
           
            return true;
        }  



}



?>