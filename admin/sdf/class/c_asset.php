<?php

include_once("config.php");

class asset
{
    public $cus_id;
    public $immovable_properties;
    public $movable_properties ;
    public $any_other_assets;
    public $guarantees_on_behalf;
    public $security_offered;
    public $tax_position;
    

    private $db;

    function __construct()
    {
        $this->db=new mysqli(host,un,pw,db);
    }


    function save_asset()
    {
         
         $sql="insert into asset_tbl(cus_id,immovable_properties,movable_properties,any_other_assets,guarantees_on_behalf,security_offered)
         values('$this->cus_id','$this->immovable_properties','$this->movable_properties','$this->any_other_assets','$this->guarantees_on_behalf','$this->security_offered')";
         $this->db->query($sql);

    }

    function update_asset()
        {
            $sql="UPDATE asset_tbl set immovable_properties='$this->immovable_properties',movable_properties='$this->movable_properties',any_other_assets='$this->any_other_assets',guarantees_on_behalf='$this->guarantees_on_behalf',security_offered='$this->security_offered' WHERE cus_id=$this->cus_id";
           
            $this->db->query($sql);
           
            return true;
        }
        

    function save_asset_gurantor()
    {
         
         $sql="insert into asset_tbl(cus_id,immovable_properties,movable_properties,any_other_assets,guarantees_on_behalf,tax_position)
         values('$this->per_id','$this->immovable_properties','$this->movable_properties','$this->any_other_assets','$this->guarantees_on_behalf','$this->tax_position')";
         $this->db->query($sql);

    }

    function get_asset($id)
        {
            $sql="select * from asset_tbl where cus_id='$id'";
            $res=$this->db->query($sql);
            $row=$res->fetch_array();

            $ass=new asset();
            $ass->cus_id=$row['cus_id'];
            $ass->immovable_properties=$row['immovable_properties'];
            $ass->movable_properties=$row['movable_properties'];
            $ass->any_other_assets=$row['any_other_assets'];
            $ass->guarantees_on_behalf=$row['guarantees_on_behalf'];
            $ass->security_offered=$row['security_offered'];
            $ass->tax_position=$row['tax_position'];
            
            return $ass;
        
        }

    function is_exist_asset($id)
        {
            //$db = new mysqli("localhost","root","","bank");
            $sql="select * from asset_tbl where cus_id='$id'";
            $res=$this->db->query($sql);

        if($res->num_rows>0)
        {   
            return true;
        }else{
            return false;
            }        
                
        }      

}









?>