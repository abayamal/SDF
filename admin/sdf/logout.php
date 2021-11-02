<?php
session_start();

if($_SESSION["uu"]['type']=='staff'){

// to save logout details session_tbl of staff
include_once "class/c_staff.php";
$s=new staff();
$s->stf_id=$_SESSION["uu"]['stf_id'];
$s->stf_first_name=$_SESSION["uu"]['stf_first_name'];
$s->stf_last_name=$_SESSION["uu"]['stf_last_name'];
$s->stf_type=$_SESSION["uu"]['type'];
$s->logout_session_save();
}

if($_SESSION["uu"]['type']=='customer'){
    
// to save logout details session_tbl of customer
include_once "class/c_customer.php";
$c=new customer();
$c->cus_id=$_SESSION["uu"]['cus_id'];
$c->cus_first_name=$_SESSION["uu"]['cus_first_name'];
$c->cus_last_name=$_SESSION["uu"]['cus_last_name'];
$c->cus_type=$_SESSION["uu"]['type'];
$c->logout_session_save();
}

session_destroy();
header("location:index.php");
?>