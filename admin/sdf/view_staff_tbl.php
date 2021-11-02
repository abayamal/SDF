<?php ob_start(); ?>
<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>
<?php

include "class/c_staff.php";
$s = new staff();
$a = $s->get_all_staff();


if($s->staff_table_is_empty()) // check whether empty the database table
{
    ?>
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"><!--section-->
        <div class="container-fluid"><!--container-fluid -->
            <div class="card card-default"><!--card card-default -->
                <div class="card-header">
                    <h3 class="card-title">View Staff</h3>
                </div><!-- /card-header -->
                    <div class="card-body"><!--card body -->       
                        <h1 style="color:#FF0000; text-align:center"><b> Data Is Not Available In Database!</b></h1>
                    </div><!-- /.card-body -->
                <div class="card-footer"><!--card-footer --> 
                </div><!--/card-footer -->
            </div><!--/card card-default -->
        </div><!--/container-fluid -->
    </section><!--/section-->
    </div>


    <?php
}elseif(isset($_GET["del_id"]))
{

  $did = $_GET["del_id"];
  $s->delete_staff($did);
  header("location:view_staff_tbl.php");



}else{

  ?>

              <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
              <!-- Content Header (Page header) -->
              <section class="content-header">
                <div class="container-fluid">
                  <div class="card card-default">
                    <div class="card-header">
                      <h3 class="card-title">View staff</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                          <div class="col-md-12">
                            <table id="example1" class="table table-responsive table-bordered table-striped">
                              <thead>
                                <tr>
                                  <th>NIC</th>
                                  <th>Designation</th>
                                  <th>Experienced</th>
                                  <th>Branch</th>
                                  <th>Full name</th>
                                  <th>Address</th>
                                  <th>Contact No</th>
                                  <th>Email</th>
                                  <th>Gender</th>
                                  <th>DOB</th>
                                  <th>Action</th>

                                </tr>
                              </thead>
                              <tbody>
                                <?php

                                foreach ($a as $item) {

                                  echo "  
                                      <tr>
                                        <td>$item->stf_id</td>
                                        <td>$item->stf_designation</td>
                                        <td>$item->stf_experienced</td>
                                        <td>$item->branch_id</td>
                                        <td>$item->stf_full_name</td>
                                        <td>$item->stf_address</td>
                                        <td>$item->stf_telephone</td>
                                        <td>$item->stf_email</td>
                                        <td>$item->stf_gender</td>
                                        <td>$item->stf_dob</td>
                                        <td><a href='#' onclick=delfunc($item->stf_id);><img src='del.svg' width='20'</a>
                                        <a href='edit_staff_form.php?edit_id=$item->stf_id'><img src='edit.svg' width='20'</a></td>
                                          
                                    ";
                                }

                                ?>
                              </tbody>
                              <tfoot>
                                <tr>
                                  <th>NIC</th>
                                  <th>Designation</th>
                                  <th>Experienced</th>
                                  <th>Branch</th>
                                  <th>Full name</th>
                                  <th>Address</th>
                                  <th>Contact No</th>
                                  <th>Email</th>
                                  <th>Gender</th>
                                  <th>DOB</th>
                                  <th>Action</th>  
                                </tr>
                              </tfoot>
                            </table>
                          </div>
                    </div>
                    <!-- /.card-body -->
                  </div>
                </div><!-- /.container-fluid -->
              </section>
            </div>

<?php
}

?>
  <?php include "footer.php"; ?>
  <?php ob_end_flush();   ?>
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
      window.location.href = "view_staff_tbl.php?del_id="+fu;
      Swal.fire(
        'Deleted!',
        'Your file has been deleted.',
        'success'
      )
    }
  })
}
</script>




