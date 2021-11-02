<?php ob_start();  ?>
<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>

<?php

include "class/c_account_category.php";
$ac=new account_category();
$accCat=$ac->get_all_account_category();

// delete account category
if(isset($_GET["del_id"])){
  $did=$_GET["del_id"];
  $ac->del_account_category($did);
  header("location:view_acc_category_tbl.php");
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Account categories</h3>

              
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form action="#" method="post">
                <div class="row">
                  <div class="col-md-12">
                    <table class="table table-sm">
                            <thead>
                                <tr>
                                <th scope="col">Category ID</th>
                                <th scope="col">Category Name</th>
                                <th scope="col">Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">operation</th>
                                
                                 
                                </tr>
                            </thead>
                            <?php
                                foreach($accCat as $item)
                                {
                                    echo"
                                <tr> 
                                    <td>$item->acc_category_id</td>
                                    <td>$item->acc_category_name</td>
                                    <td>$item->date</td>
                                    <td>$item->acc_category_status</td>
                                    <td>
                                    <a href='edit_account_category_form.php?category_id=$item->acc_category_id'><button type='button' class='btn btn-primary btn-sm'>Edit</button></a>
                                    <button onclick=delfunc($item->acc_category_id); type='button' class='btn btn-danger btn-sm'>Delete</button>
                                    </td>
                                    
                                </tr>
                                     
                                    ";
                                }
                                ?>
                    </table>
                  
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
      window.location.href = "view_acc_category_tbl.php?del_id="+fu;
      Swal.fire(
        'Deleted!',
        'Your file has been deleted.',
        'success'
      )
    }
  })
}
</script>
