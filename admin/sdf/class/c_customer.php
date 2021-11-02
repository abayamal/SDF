<?php
include_once("config.php");

class customer
{
    public $cus_id;
    public $cus_first_name;
    public $cus_last_name;
    public $cus_full_name;
    public $cus_address;
    public $cus_telephone;
    public $cus_email;
    public $cus_gender;
    public $cus_dob;
    public $cus_age;
    public $cus_status;
    public $cus_designation;
    public $cus_designation_state;
    public $cus_monthely_income;
    public $cus_type;
  

    public $branch_id;
    public $cus_username;
    public $cus_password;
    public $cus_confirm_password;

    private $db;

    function __construct()
    {
        $this->db=new mysqli(host,un,pw,db);
    }

    
    function registercustomer()
        {
            $sql="insert into customer_tbl(cus_id,cus_first_name,cus_last_name,cus_full_name,cus_address,cus_telephone,cus_email,cus_gender,cus_dob,branch_id)
                values('$this->cus_id','$this->cus_first_name','$this->cus_last_name','$this->cus_full_name','$this->cus_address','$this->cus_telephone','$this->cus_email','$this->cus_gender','$this->cus_dob','$this->branch_id')";
            $this->db->query($sql);
            
        }
    
    function get_customer($id)
        {
            $db = new mysqli("localhost","root","","bank");
            $sql="select * from customer_tbl where cus_id=$id";
            $res=$db->query($sql);

            if($res->num_rows>0){
                $row=$res->fetch_array();

                $this->cus_id=$row['cus_id'];
                $this->cus_first_name=$row['cus_first_name'];
                $this->cus_last_name=$row['cus_last_name'];
                $this->cus_full_name=$row['cus_full_name'];
                $this->cus_address=$row['cus_address'];
                $this->cus_telephone=$row['cus_telephone'];
                $this->cus_email=$row['cus_email'];
                $this->cus_gender=$row['cus_gender'];
                $this->cus_dob=$row['cus_dob'];
                $this->cus_age=$row['age'];
                $this->cus_designation=$row['cus_designation'];
                $this->cus_designation_state=$row['cus_designation_state'];
                $this->cus_monthely_income=$row['cus_monthely_income'];
                $this->cus_status=$row['cus_status'];
                
                return $this;
            }else{
                return false;
            }
        } 

    function get_all_customer()
        {
            $sql="select * from customer_tbl where cus_status='active'";
            $r=$this->db->query($sql);

            $ar=array();

            while($row=$r->fetch_array())
            {
                $c=new customer();

                $c->cus_id=$row['cus_id'];
                $c->cus_first_name=$row['cus_first_name'];
                $c->cus_last_name=$row['cus_last_name'];
                $c->cus_full_name=$row['cus_full_name'];
                $c->cus_address=$row['cus_address'];
                $c->cus_telephone=$row['cus_telephone'];
                $c->cus_email=$row['cus_email'];
                $c->cus_gender=$row['cus_gender'];
                $c->cus_dob=$row['cus_dob'];
                $c->cus_status=$row['cus_status'];
            
                

            $all_customer[]=$c;
            }
            return $all_customer;
        }   
        
    function update_customer()
        {
            $sql="UPDATE customer_tbl set cus_first_name='$this->cus_first_name',cus_last_name='$this->cus_last_name',cus_full_name='$this->cus_full_name',cus_designation='$this->cus_designation',cus_designation_state='$this->cus_designation_state',cus_monthely_income='$this->cus_monthely_income',cus_address='$this->cus_address',cus_telephone='$this->cus_telephone',cus_email='$this->cus_email',cus_gender='$this->cus_gender',cus_dob='$this->cus_dob' WHERE cus_id=$this->cus_id";
           
            $this->db->query($sql);
           
            return true;
        } 

    function is_exist_customer($id)
        {
            $db = new mysqli("localhost","root","","bank");
            $sql="select * from customer_tbl where cus_id='$id'";
            $res=$db->query($sql);

        if($res->num_rows>0)
        {    
                $row=$res->fetch_array();

                $this->cus_id=$row['cus_id'];
                $this->cus_first_name=$row['cus_first_name'];
                $this->cus_last_name=$row['cus_last_name'];
                $this->cus_full_name=$row['cus_full_name'];
                $this->cus_address=$row['cus_address'];
                $this->cus_telephone=$row['cus_telephone'];
                $this->cus_email=$row['cus_email'];
                $this->cus_gender=$row['cus_gender'];
                $this->cus_dob=$row['cus_dob'];
                $this->cus_status=$row['cus_status'];

                return $this;
        }
            else{
            return false;
            }        
                
        }
        
    
    function login($u,$p)
        {
            
            $sql="select * from customer_tbl where cus_username='$u' and cus_password='$p'";
            $r2=$this->db->query($sql);

            if($r2->num_rows>0)
            {
                $row=$r2->fetch_array();
                session_start();
                $_SESSION["uu"]=$row;
                return true;
            }else{
                return false;
            }
        }      

    function login_session_save() //save login details in session_tbl
        {
            $sql="insert into session_tbl(nic,activity,type,first_name,last_name)
                values('$this->cus_id','login','$this->cus_type','$this->cus_first_name','$this->cus_last_name')";
            $this->db->query($sql);
            
        }
    
    function logout_session_save() //save login details in session_tbl
        {
            $sql="insert into session_tbl(nic,activity,type,first_name,last_name)
                values('$this->cus_id','logout','$this->cus_type','$this->cus_first_name','$this->cus_last_name')";
            $this->db->query($sql);
            
        } 
     
    function last_login_details($nic)
        {
            $sql="SELECT * FROM session_tbl    
            WHERE date = (
            SELECT max(date)
            FROM session_tbl
            WHERE nic=$nic and activity='login')";

            $r=$this->db->query($sql);
            if($r->num_rows>0)
            {    
                    $row=$r->fetch_array();

                    $this->stf_id=$row['nic'];
                    $this->last_login=$row['date'];

                    return true;
            }
                else{
                return false;
                }        
                
        } 

    function last_logout_details($nic)
        {
            $sql="SELECT * FROM session_tbl    
            WHERE date = (
            SELECT max(date)
            FROM session_tbl
            WHERE nic=$nic and activity='logout')";

            $r=$this->db->query($sql);
            if($r->num_rows>0)
            {    
                    $row=$r->fetch_array();

                    $this->stf_id=$row['nic'];
                    $this->last_logout=$row['date'];

                    return true;
            }
                else{
                return false;
                }        
                
        } 
        
    function get_customer_password($id)
        {
            $db = new mysqli("localhost","root","","bank");
            $sql="select * from customer_tbl where cus_id=$id";
            $res=$db->query($sql);

            if($res->num_rows>0){
                $row=$res->fetch_array();

                $this->cus_id=$row['cus_id'];
                $this->cus_username=$row['cus_username'];
                $this->cus_password=$row['cus_password'];
                
                
                return $this;
            }else{
                return false;
            }
        }    
        
    function update_username_and_password()
        {
            $sql="UPDATE customer_tbl set cus_username='$this->cus_username',cus_password='$this->cus_password' WHERE cus_id=$this->cus_id";
           
            $this->db->query($sql);
           
            return true;
        }   

}



?>