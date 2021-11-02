<?php include"header.php"; ?>
<?php include"sidebar.php"; ?>
<?php
include_once "class/c_staff.php";
$s=new staff();




if($s->staff_table_is_empty()) // check whether empty the database table
{
    ?>
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"><!--section-->
        <div class="container-fluid"><!--container-fluid -->
            <div class="card card-default"><!--card card-default -->
                <div class="card-header">
                    <h3 class="card-title">Branch staff report</h3>
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
}else{
    $branch_id=$_SESSION["uu"]['branch_id'];
    $res=$s->get_all_staff_in_branch($branch_id);
    ?>

    <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"><!--section-->
        <div class="container-fluid"><!--container-fluid -->
            <div class="card card-default"><!--card card-default -->
                <div class="card-header">
                    <h3 class="card-title">Branch staff report</h3>
                </div><!-- /card-header -->
                <div class="card-body"><!--card body -->  
                    <?php
                    ?>

                        <div class="col-md-12">
                            <table id="example1" class="table table-responsive table-bordered table-striped">
                            <thead>
                                <tr>
                                <th scope="col">Person ID</th>
                                <th scope="col">Full Name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Designation</th>
                                <th scope="col">Telephone</th>
                                <th scope="col">Recruit Date</th>
                                <th scope="col">Gender</th>
                                <!-- <th scope="col">Age</th> -->
                                <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($res as $item) {

                                echo "  
                                    <tr>
                                    <th scope='row'>$item->stf_id v</th>
                                    <td>$item->stf_full_name</td>
                                    <td>$item->stf_address</td>
                                    <td>$item->stf_designation</td>
                                    <td>$item->stf_telephone</td>
                                    <td>$item->stf_add_date</td>
                                    <td>$item->stf_gender</td>
                                    <td>$item->stf_status</td>
                                      
                                    ";
                                }

                                ?>
                            </tbody>
                             <tfoot>
                                <tr>
                                <th scope="col">Person ID</th>
                                <th scope="col">Full Name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Designation</th>
                                <th scope="col">Telephone</th>
                                <th scope="col">Recruit Date</th>
                                <th scope="col">Gender</th>
                                <!-- <th scope="col">Age</th> -->
                                <th scope="col">Status</th> 
                                </tr>
                            </tfoot> 
                            </table>
                        </div>






                 
                    </div><!-- /.card-body -->
                <div class="card-footer"><!--card-footer --> 
                </div><!--/card-footer -->
            </div><!--/card card-default -->
        </div><!--/container-fluid -->
    </section><!--/section-->
</div>
<?php
}
?>

<?php include"footer.php"; ?>


    

        

