<?php
include_once("config.php");

class spouse
{
    public $spouse_id;
    public $type;
    public $name;
    public $address;
    public $occupation;

    private $db;

    function __construct()
    {
        $this->db=new mysqli(host,un,pw,db);
    }

    function registerSpouse()
        {
            $sql="insert into spouse_tbl(spouse_id,type,name,address,occupation)
                values('$this->spouse_id','spouse','$this->name','$this->address','$this->occupation')";
            $this->db->query($sql);
            
        }

    
    function is_exist_spouse($id)
        {
            $db = new mysqli("localhost","root","","bank");
            $sql="select * from spouse_tbl where spouse_id='$id'";
            $res=$db->query($sql);

        if($res->num_rows>0)
        {   
            return true;
        }else{
            return false;
            }        
                
        }  
        
    function update_spouse()
        {
            $sql="UPDATE spouse_tbl set name='$this->name',address='$this->address',occupation='$this->occupation' WHERE spouse_id=$this->spouse_id";
           
            $this->db->query($sql);
           
            return true;
        }
        
    function get_spouse($id)
        {
            $db = new mysqli("localhost","root","","bank");
            $sql="select * from spouse_tbl where spouse_id=$id";
            $res=$db->query($sql);

            
                $row=$res->fetch_array();

                $this->spouse_id=$row['spouse_id'];
                $this->type=$row['type'];
                $this->name=$row['name'];
                $this->address=$row['address'];
                $this->occupation=$row['occupation'];
                
                return $this;
            
        }    


}





?>