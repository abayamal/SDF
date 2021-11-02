<?php
include "class/c_branch.php";
$b=new branch();
$res=$b->get_all_branch();

if(isset($_GET["del_id"]))
{
    
    $did=$_GET["del_id"];
    $b->del_branch($did);
    header("location:view_branches_tbl.php");
    
}
?>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Branches</h3>

              
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form action="#" method="post">
                <div class="row">
                  <div class="col-md-12">
                  <?php
                  if($res!=false){
                  ?>
                    <table class="table table-sm">
                            <thead>
                                <tr>
                                <th scope="col">Branch ID</th>
                                <th scope="col">Branch Name</th>
                                <th scope="col">Branch City</th>
                                <th scope="col">Telephone</th>
                                <th scope="col">operation</th>
                                
                                </tr>
                            </thead>
                            <?php
                                foreach($res as $item)
                                {
                                    echo"  
                                        <tbody>
                                            <tr>
                                            <th scope='row'>00$item->branch_id</th>
                                            <td>$item->branch_name</td>
                                            <td>$item->branch_city</td>
                                            <td>$item->branch_phone</td>
                                            <td>
                                            <a href='edit_branches_form.php?branch_id=$item->branch_id'><button type='button' class='btn btn-primary btn-sm'>Edit</button></a>
                                            <button onclick=delfunc($item->branch_id); type='button' class='btn btn-danger btn-sm'>Delete</button>
                                            </td>
                                            
                                            </tr>
                                            
                                        </tbody>
                                        ";
                                }
                                ?>
                    </table>
                  <?php
                  }else{
                    ?>

                    <h1 style="text-align:center;color:#FF0000"><b> Branch not exist! <b></h1>
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
      window.location.href = "view_branches_tbl.php?del_id="+fu;
      Swal.fire(
        'Deleted!',
        'Your file has been deleted.',
        'success'
      )
    }
  })
}
</script>