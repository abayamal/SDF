<?php ob_start();  ?>
<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>

<?php

include "class/c_account_type.php";
$at=new account_type();
$acct=$at->get_all_account_types();

if(isset($_GET["del_id"])){
  $did=$_GET["del_id"];
  $at->del_account_type($did);
  header("location:view_acc_types_tbl.php");
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Account types</h3>

              
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form action="#" method="post">
                <div class="row">
                  <div class="col-md-12">
                  <?php
                  if($acct!=false){
                  ?>
                    <table class="table table-sm">
                            <thead>
                                <tr>
                                <th scope="col">Type ID</th>
                                <th scope="col">Category</th>
                                <th scope="col">Type Name</th>
                                <th scope="col">Open amount</th>
                                <th scope="col">Interest</th>
                                <th scope="col">Status</th> 
                                <th scope="col">Operation</th> 
                                </tr>
                            </thead>
                            <?php
                                foreach($acct as $item)
                                {
                                    echo"
                                <tr> 
                                    <td>$item->acc_type_id</td>
                                    <td>".$item->acc_cat->acc_category_name."</td>
                                    <td>$item->acc_type_name</td>
                                    <td>$item->open_amount.00</td>
                                    <td>$item->interest%</td>
                                    <td>$item->acc_type_status</td>
                                    <td>
                                    <a href='edit_account_types_form.php?type_id=$item->acc_type_id'><button type='button' class='btn btn-primary btn-sm'>Edit</button></a>
                                     <button onclick=delfunc($item->acc_type_id); type='button' class='btn btn-danger btn-sm'>Delete</button>
                                    </td>
                                </tr>
                                     
                                    ";
                                }
                                ?>
                    </table>
                  <?php
                  }else{
                    ?>
                    <h1 style="text-align:center;color:#FF0000"><b> Account types not exist! <b></h1>
                    <?php
                  }
                  ?>
                </div>
              </form> 
            </div>
            <!-- /.card-body -->
            
        </div>
      </div><!-- /.container-fluid -->
    </section>

        
<?php include"footer.php"; ?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
  function delfunc(fu){
    Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {      
      window.location.href = "view_acc_types_tbl.php?del_id="+fu;
      Swal.fire(
        'Deleted!',
        'Your file has been deleted.',
        'success'
      )
    }
  })
}
</script>
