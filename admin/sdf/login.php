<?php

$txt="";
if(isset($_POST["un"]))
{
    
    include "class/c_staff.php";
    $st=new staff();
    $res=$st->login($_POST["un"],md5($_POST["pw"]));

    include "class/c_customer.php";
    $cs=new customer();
    $res2=$cs->login($_POST["un"],md5($_POST["pw"]));

    if($res==true || $res2==true){
      if($_SESSION["uu"]['type']=="staff"){
				header("location:index.php");

        // to save login details session_tbl
        include_once "class/c_staff.php";
        $s=new staff();
        $s->stf_id=$_SESSION["uu"]['stf_id'];
        $s->stf_first_name=$_SESSION["uu"]['stf_first_name'];
        $s->stf_last_name=$_SESSION["uu"]['stf_last_name'];
        $s->stf_type=$_SESSION["uu"]['type'];
        $s->login_session_save();

			}
			if($_SESSION["uu"]['type']=="customer"){
				header("location:index2.php");
        
        // to save login details session_tbl
        include_once "class/c_customer.php";
        $c=new customer();
        $c->cus_id=$_SESSION["uu"]['cus_id'];
        $c->cus_first_name=$_SESSION["uu"]['cus_first_name'];
        $c->cus_last_name=$_SESSION["uu"]['cus_last_name'];
        $c->cus_type=$_SESSION["uu"]['type'];
        $c->login_session_save();
			}
			
    //header("location:index.php");
    }
    else
    $txt="<span style='color:#FF0000'>Invalid username/password</span>";// If invalid username or password display error message

  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sarvodaya Finance | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../index2.html">  </a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
    <img src="sdf.jpg" alt="" width="320" height="50" style="margin-bottom: 30px; width: 300px;" > 
      <!--<p class="login-box-msg">Sign in to start your session</p>-->
      <?=$txt?>
      <form action="login.php" method="post" padding-bottom: 50px;>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username" name="un">
          <div class="input-group-append">
            <div class="input-group-text">
            <i class="fas fa-user"></i>
              <!--<span class="fas fa-envelope"></span>-->
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="pw">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Login</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

     
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>

</body>
</html>

