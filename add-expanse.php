<?php include('includes/header.php'); ?>
    <body>
        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
                <?php include('includes/nav.php'); ?>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
                <?php include('includes/sidebar.php') ?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">
                    <div class="container-fluid">
                        <div class="row page-title align-items-center">
                            <div class="col-sm-4 col-xl-6">
                                <h4 class="mb-1 mt-0"> <strong>SOMTESO <small>Office Management </small> </strong> </h4>
                            </div>
                           
                        </div>

                        <!-- stats + charts -->
                        <div class="row">
                            <div  class="col-md-12">
                                <div class="card">
                                    <form  method="post">
                                       
                                        <div class="card-header bg-primary text-light ">
                                           <?php  if(isset($_GET['action']) && $_GET['action'] == 'update') { echo "Update expanses";  }else{echo "Add new expanse";}?> 
                                        </div>
                                        <div class="card-body">
                                         
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label for=""> Payee name </label>
                                                    <input type="text" name="pname" id="" class="form-control" placeholder="Payee name" required value="<?php get_pyname();?>">
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for=""> Description </label>
                                                    <input type="text" name="desc" id="" class="form-control" placeholder="Description..." value='<?php get_description();?>'>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for=""> Account name </label>
                                                    <select name="accname" id="" class='form-control' required>
                                                      
                                                        <?php get_acc_name(); ?>
                                                    </select>
                                                </div>

                                                
                                                <div class="form-group col-md-4">
                                                    <label for=""> Amount </label>
                                                    <input type="number" name="amount" id="" class="form-control" placeholder="Amount" required value="<?php  get_amount(); ?>">
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for=""> Post date </label>
                                                    <input type="date" name="rdate" id="" class="form-control" placeholder="" required value="<?php get_r_date(); ?>">
                                                </div>

                                            </div>
                                        </div>
                                        
                                    
                                    <div class="card-footer">
                                        <?php if(isset($_GET['action']) && $_GET['action'] == 'update'){  ?>
                                            <input type="submit" value="Update" class="btn btn-info" name='btn-upd-exp'>
                                        <?php }else{ ?>
                                            <input type="submit" value="Register" class="btn btn-info" name='btn-add-exp'>
                                        <?php }?>
                                        <a href="manage-expanses" class='btn btn-success'> View Expanses </a>
                                    </div>
                                    </form>
                                </div>
                       
                            </div>
                        </div>
                        <!-- row -->
                
                       
                    </div>
                </div> <!-- content -->

<?php include('includes/footer.php'); ?>

<?php

function get_acc_name(){
    global $con;
    if($_GET['accname']){
        $accname = $_GET['accname'];
        $stmt = "SELECT * FROM accounts WHERE accountname = '$accname' ";
        $result = mysqli_query($con, $stmt);

        if($row = mysqli_fetch_assoc($result)){
            $id = $row['accid'];
            $accname = $row['accountname'];
            echo " <option value='$id'>$accname</option> ";
        }

        $stm = "SELECT * FROM accounts WHERE accountname != '$accname' ";
        $res = mysqli_query($con, $stm);
        while($ro = mysqli_fetch_assoc($res)){
            $id = $ro['accid'];
            $accname = $ro['accountname'];
            echo " <option value='$id'>$accname</option> ";
        }



    }else{
        echo " <option value=''>Select account</option> ";
        $sql="select accountNo, accountname from accounts  WHERE catogary='EXPENSES' ";
        $query=mysqli_query($con, $sql);
        while($re=mysqli_fetch_array($query)){
            echo " <option value=" . " ' " . $re[0]  . " ' > " . $re[1] . "</option> ";
        }
    }
		
}

if(isset($_POST['btn-add-exp'])){
   
    $payeename = $_POST['pname'];
    $amount = $_POST['amount'];
    $discription = $_POST['desc'];
    $accname = $_POST['accname'];
    $amount = $_POST['amount'];
    $regdate = $_POST['rdate'];
        
    // how Find the autto ID
    $nextID="";

    $nextIDQuery="SELECT (concat('EXP',LPAD((SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$dbname' AND TABLE_NAME = 'expenses'),4,'0'))) as refno FROM `expenses` limit 1";
    $resultID = mysqli_query($con,$nextIDQuery) or die(mysqli_error($con));
    if($Re=mysqli_fetch_row($resultID)){
        $nextID= $Re[0];
    }
    if($nextID==null){
        $nextID='EXP0001';
    }
    //echo $nextID; exit();
    //End of Auto ID generation		  

    //Inserting data to the expense table danlow
    $sqlexp="INSERT INTO expenses VALUES(null, '$payeename', '$discription', '$accname', '$amount', '$regdate', '$nextID')";

    $queryExp=mysqli_query($con, $sqlexp);
    //end of insert expense table

    $sqlcashact1="INSERT INTO cashactivity VALUES(null, '$discription',  '$accname',  '$amount',  '0', '$regdate', '$nextID')";
    $quercashact=mysqli_query($con, $sqlcashact1);

    $sqlcashact2="INSERT INTO cashactivity VALUES(null, '$discription',  '10100',  '0',  '$amount', '$regdate', '$nextID')";
    $quercashact1=mysqli_query($con, $sqlcashact2);

    echo " 
    <script>
        Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Expanse added successfully',
        showConfirmButton: false,
        timer: 1500
        }).then((result) => {
            window.location.href = 'add-expanse'
        })
    </script>
    
    "; 
    
    
}
function get_pyname(){
    if(isset($_POST['pname'])){
        echo $_POST['pname'];
    }elseif(isset($_GET['payeename'])){
        echo $_GET['payeename'];

    }
}
function get_description(){
    if(isset($_POST['desc'])){
        echo $_POST['desc'];
    }elseif(isset($_GET['desc'])){
        echo $_GET['desc'];
    }
}





function get_amount(){
    if(isset($_POST['phone'])){
        echo $_POST['phone'];
    }elseif(isset($_GET['amount'])){
        echo $_GET['amount'];
    }
}



function get_r_date(){
 if($_GET['date']){
        echo $_GET['date'];
    }
}

if(isset($_POST['btn-upd-exp'])){
    $payeename = $_POST['pname'];
    $amount = $_POST['amount'];
    $discription = $_POST['desc'];
    $accname = $_POST['accname'];
    $amount = $_POST['amount'];
    $regdate = $_POST['rdate'];
    $id = $_GET['id'];

    $stmt = "UPDATE expenses SET payeename = '$payeename' , description = '$discription' , amount = '$amount' , posdate = '$regdate' WHERE expenseid = '$id'";
    $result = mysqli_query($con, $stmt);
    if($result){
        echo "
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Expanse Updated successfully',
            showConfirmButton: false,
            timer: 1500
            }).then((result) => {
                window.location.href = 'manage-expanses'
            })
        </script>
        
        "; 
    }else{
        echo "
        <script>
            Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Failed to update',
            showConfirmButton: false,
            timer: 1500
            }).then((result) => {
                window.location.href = 'manage-expanses'
            })
        </script>
        
        "; 
    }
    
}
   
?>