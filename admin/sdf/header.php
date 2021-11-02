<?php

session_start();
if(!isset($_SESSION["uu"]))
{
  header("location:login.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sarvodaya Finance</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="date.min.css">

  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- jQuery -->


  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

  <style>
/* * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
} */
.no-controls::-webkit-inner-spin-button, 
.no-controls::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
.no-controls {
  -moz-appearance: textfield;
}

.frame {
  display: grid;
  padding: 10px;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  grid-gap: 10px;
  padding: 10px auto;
}
.frame a {
  text-decoration: none;
  display: block;
  box-shadow: 0px 0px 3px 1px rgba(0, 0, 0, 0.3);
  border-radius: 5px;
  padding: 15px;
  font-size: 25px;
  color: #444;
}
.frame a span {
  font-size: 18px;
  margin-bottom: 5px;
  padding-left: 10px;
  margin-left: 5px;
  border-left: 1px solid grey;
}

hr.style1{
	border-top: 1px solid #8c8b8b;
}

.myDiv{
  
  background-color:#f0f5f5;
  padding: 20px;
  border-radius: 5px
  
}
.myDiv2{
  
  background-color:  #e0ebeb;
  padding: 20px;
  
 
}
.myDiv3{
  
  background-color:  #e0ebeb;
  padding: 20px;
  margin: 10px;
  border-radius: 5px
 
}



  </style>
  
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link">Home</a>
      </li>
      
    </ul>


    <!-- Right navbar links -->
    <!-- <ul class="navbar-nav ml-auto"> -->
      <!-- Messages Dropdown Menu -->
      
    
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul> -->
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4 position-fixed">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      
      <span class="brand-text font-weight-light">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sarvodaya Finance</span>
    </a>
    

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="image/user.jpg" class="img-circle elevation-2" alt="User Image">
          <!--<i class="fas fa-user" class="img-circle elevation-2"></i>-->
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION["uu"]['stf_first_name']." ".$_SESSION["uu"]['stf_last_name']; ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search" id="sidebar_search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>



 