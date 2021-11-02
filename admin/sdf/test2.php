<?php

include_once("config.php");


$db=new mysqli(host,un,pw,db);


$sql="INSERT INTO `test` (`name`) VALUES('BANDA')";
    $db->query($sql);