<?php
include_once("config.php");

class staff
{
    public $stf_id;
    public $stf_first_name;
    public $stf_last_name;
    public $stf_full_name;
    public $stf_address;
    public $stf_telephone;
    public $stf_email;
    public $stf_gender;
    public $stf_dob;
    public $stf_age;
    public $stf_status;
    public $stf_designation;
    public $stf_designation_state;
    public $stf_type;

    public $stf_experienced;

    public $exp_id;
    public $exp_name;
  

    public $branch_id;
    public $stf_username;
    public $stf_password;
    public $stf_confirm_password;

    private $db;

    function __construct()
    {
        $this->db=new mysqli(host,un,pw,db);
    }

    function save_staff()
        {
            //$db=new mysqli("localhost","root","","bank");
            $sql="insert into staff_tbl(stf_id,stf_experienced,stf_first_name,stf_last_name,stf_full_name,stf_address,branch_id,stf_designation,stf_telephone,stf_email,stf_gender,stf_dob,age,stf_username,stf_password)values('$this->stf_id','$this->stf_experienced','$this->stf_first_name','$this->stf_last_name','$this->stf_full_name','$this->stf_address','$this->branch_id','$this->stf_designation','$this->stf_telephone','$this->stf_email','$this->stf_gender','$this->stf_dob','$this->stf_age','$this->stf_username','$this->stf_password')";
            
            $this->db->query($sql);
            
    
        }

    function edit_staff()
        {
            $sql="UPDATE staff_tbl set stf_id='$this->stf_id',stf_experienced='$this->stf_experienced',stf_designation='$this->stf_designation',branch_id='$this->branch_id',stf_full_name='$this->stf_full_name',stf_address='$this->stf_address',stf_telephone='$this->stf_telephone',stf_email='$this->stf_email',stf_gender='$this->stf_gender',stf_dob='$this->stf_dob',stf_username='$this->stf_username',stf_password='$this->stf_password' WHERE stf_id='$this->stf_id'";
           
            $this->db->query($sql);

            return true;
            
        }  
    
    function delete_staff($id)
        {
            //$db=new mysqli("localhost","root","","bank");
            $sql="UPDATE staff_tbl set stf_status='delete' where stf_id='$id'";
            $this->db->query($sql);
            
        }

    function active_staff($id)
        {
            $sql="UPDATE staff_tbl set stf_status='active' where stf_id=$id";
            $this->db->query($sql);
        }  

    function get_staff($id)
        {
            $sql="select * from staff_tbl where stf_id=$id";
            $res=$this->db->query($sql);
            $row=$res->fetch_array();

            
            $this->stf_id=$row['stf_id'];
            $this->stf_designation=$row['stf_designation'];
            $this->branch_id=$row['branch_id'];
            $this->stf_full_name=$row['stf_full_name'];
            $this->stf_address=$row['stf_address'];
            $this->stf_telephone=$row['stf_telephone'];
            $this->stf_email=$row['stf_email'];
            $this->stf_gender=$row['stf_gender'];
            $this->stf_dob=$row['stf_dob'];
            $this->stf_username=$row['stf_username'];
            $this->stf_password=$row['stf_password'];
            
            return $this;
        
        } 
        
    function get_all_staff()
        {
            $sql="select * from staff_tbl where stf_status='active'";
            $r=$this->db->query($sql);

            $all_staff=array();
            include "class/c_branch.php";

            while($row=$r->fetch_array())
            {
                $s=new staff();

            $s->stf_id=$row['stf_id'];
            $s->stf_designation=$row['stf_designation'];

                $b=new branch();  //to get branch name
                $b2=$b->get_branch($row['branch_id']);

            $s->branch_id=$b2->branch_name;
            $s->stf_full_name=$row['stf_full_name'];
            $s->stf_address=$row['stf_address'];
            $s->stf_telephone=$row['stf_telephone'];
            $s->stf_email=$row['stf_email'];
            $s->stf_gender=$row['stf_gender'];
            $s->stf_dob=$row['stf_dob'];
            $s->stf_username=$row['stf_username'];
            $s->stf_password=$row['stf_password'];


            $experience=$row['stf_experienced'];
            
            include_once "class/c_staff.php";
            $s2=new staff();
            $s2->get_experience($experience);

            $s->stf_experienced=$s2->exp_name;

        
            
            $all_staff[]=$s;
            }
            return $all_staff;
        }

    function get_experience($id)
        {
            $sql="select * from experience_tbl where id='$id'";
            $res2=$this->db->query($sql);
            $row=$res2->fetch_array();

            
            $this->exp_id=$row['id'];
            $this->exp_name=$row['name'];
           
            
            return $this;
        
        }     




    function get_all_staff_in_branch($branch_id)
        {
            
            $sql="select * from staff_tbl where stf_status='active' and branch_id='$branch_id'";
            $r=$this->db->query($sql);

            $all_staff=array();
            
            while($row=$r->fetch_array())
            {
                $s=new staff();

           

            $s->stf_id=$row['stf_id'];
            $s->stf_full_name=$row['stf_full_name'];
            $s->stf_designation=$row['stf_designation'];
            $s->stf_address=$row['stf_address'];
            $s->stf_telephone=$row['stf_telephone'];
            $s->stf_gender=$row['stf_gender'];
            $s->stf_add_date=$row['stf_add_date'];
            $s->stf_age=$row['age'];
            $s->stf_status=$row['stf_status'];

            $all_staff[]=$s;
            }
            return $all_staff;
        }  
        
    function is_exist_staff($id)
        {
            $db = new mysqli("localhost","root","","bank");
            $sql="select * from staff_tbl where stf_id='$id'";
            $res=$db->query($sql);

        if($res->num_rows>0)
        {    
                $row=$res->fetch_array();

                $this->stf_id=$row['stf_id'];
                $this->stf_first_name=$row['stf_first_name'];
                $this->stf_last_name=$row['stf_last_name'];
                $this->stf_full_name=$row['stf_full_name'];
                $this->stf_address=$row['stf_address'];
                $this->stf_telephone=$row['stf_telephone'];
                $this->stf_email=$row['stf_email'];
                $this->stf_gender=$row['stf_gender'];
                $this->stf_dob=$row['stf_dob'];
                $this->stf_status=$row['stf_status'];

                return true;
        }
            else{
            return false;
            }        
                
        } 

    function staff_table_is_empty()
        {
            $db = new mysqli("localhost","root","","bank");
            $sql="select * from staff_tbl where stf_status='active'";
            $res=$db->query($sql);

            if($res->num_rows<1)
            {    
                    
                    return true;
            }else{
                        return false;
                 }        
                
        }     
        
        

        function login($u,$p)
        {
            $sql="select * from staff_tbl where stf_username='$u' and stf_password='$p'";
            $r=$this->db->query($sql);

            if($row=$r->fetch_array() )
            {
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
                values('$this->stf_id','login','$this->stf_type','$this->stf_first_name','$this->stf_last_name')";
            $this->db->query($sql);
            
        } 

        function logout_session_save() //save login details in session_tbl
        {
            $sql="insert into session_tbl(nic,activity,type,first_name,last_name)
                values('$this->stf_id','logout','$this->stf_type','$this->stf_first_name','$this->stf_last_name')";
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
        

        
    




}



?>