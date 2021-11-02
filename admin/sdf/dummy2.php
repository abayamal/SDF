<?php include"header.php"; ?>
<?php include"sidebar.php"; ?>
<?php

function check_acc_num($number){
    if(empty($number)){
        return false;
    }elseif(is_numeric($number)){
        return true;
    }else{
        return false;
    }
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"><!--section-->
        <div class="container-fluid"><!--container-fluid -->
            <div class="row p-3 justify-content-center"><!--row p-3 justify-content-center-->
                <div class="col-md-10"><!--col-md-8-->
                    
                        
                            
                            <?php
                            if(!isset($_GET["type"]))
                            {
                            ?>

                             <div class="card text-center"><!--card text-center -->
                                <div class="card-header">
                                    <h3 class="card-title">Account Details</h3>
                                </div><!-- /card-header -->
                                    <div class="card-body"><!--card body -->       
                                        
                                    <input class="form-control no-controls <?php if(isset($_GET["accNo"])){if( !check_acc_num($_GET["accNo"])){echo "is-invalid";}} ?>" type="number" value="<?php if(isset($_GET["accNo"])){ echo $_GET["accNo"]; } ?>" placeholder="Account Number" name="accNo">
                                    <br>

                                    <div class="search btn btn-primary" data-type="accDet">Search</div>


                                    </div><!-- /.card-body -->
                            </div><!--/card text-center -->                             
                            
                            
                            <?php
                            }else {

                                switch($_GET["type"]){

                                    case "accDet":
                                            echo "hello";
                                    break;  //end of accDet case







                                }//end of switch
                               
                            } // end of man else


                            ?>






                   
                </div><!--/col-md-8-->        
            </div><!--/row p-3 justify-content-center-->    
        </div><!--/container-fluid -->
    </section><!--/section-->

    <script>

        $(document).ready(function(){
            $(".search").click(function(){
                // $(this).data("type")

                //If account number is valid
                let url = window.location.href.split('?')[0] + "?type=" + $(this).data("type") + "&nic="+ $("input[name=accNo]").val();
                window.location.href= url;
                
            });
        });                   



    </script>                        


<?php include"footer.php"; ?>


    

        

