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
                                            Customer Payement
                                        </div>
                                        <div class="card-body">
                                        <!--<h4 class="header-title mt-0 mb-1">Customer Payment Information</h4> -->
                                       
                                         
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label for=""> Customer name </label>
                                                    <input type="text" name="custname" id="" class="form-control" placeholder="" required value="<?php get_customer_name();?>" readonly>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for=""> Service type </label>
                                                    <select name="ser_type" id="" class='form-control' required>
                                                        <option value="">Select service type</option>
                                                        <?php get_services(); ?>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for=""> Service amount </label>
                                                    <input type="number" name="seramount" id="" class="form-control" placeholder="Amount" required value="Yakub Ahmed" required >
                                                    
                                                </div>

                                                
                                                <div class="form-group col-md-4">
                                                    <label for=""> Discount </label>
                                                    <input type="number" name="dis" id="" class="form-control" placeholder="Discount" required value="" required>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for=""> Web site name </label>
                                                    <input type="text" name="webname" id="" class="form-control" placeholder="Website name" required value="" required>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for=""> Web url </label>
                                                    <input type="url" name="weburl" id="" class="form-control" placeholder="e.g https://www.google.com" required value="" required>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for=""> Start date </label>
                                                    <input type="date" name="sdate" id="" class="form-control" placeholder="" required value="" required>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for=""> Ending date </label>
                                                    <input type="date" name="edate" id="" class="form-control" placeholder="" required value="" required>
                                                </div>

                                               

                                            </div>
                                        </div>
                                        
                                    
                                    <div class="card-footer">
                                        <?php if(isset($_GET['action']) && $_GET['action'] == 'update'){  ?>
                                            <input type="submit" value="Update" class="btn btn-info" name='btn-upd-exp'>
                                        <?php }else{ ?>
                                            <input type="submit" value="Register" class="btn btn-info" name='btn-add-webs'>
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
        <script>
            $('select').select2({
                placeholder: 'Select service type',
                allowClear: true
            });
        </script>

<?php include('includes/footer.php'); ?>

<?php

function get_services(){
    global $con;
    if($_GET['update']){
       /* $accname = $_GET['accname'];
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
        */


    }else{
        echo " <option value=''>Select account</option> ";
        $query=mysqli_query($con,"SELECT accountNo, accountname FROM accounts WHERE catogary='INCOME'");
        while($re=mysqli_fetch_array($query)){
            echo " <option value=" . " ' " . $re[0]  . " ' > " . $re[1] . "</option> ";
        }
    }
		
}

function get_customer_name(){
    global $con;
    
	if(isset($_GET['service'])){
        $custid=$_GET['service'];
        // echo $custid;
        $sqlcust="SELECT * FROM customer WHERE custid ='$custid' ";
        $querycust=mysqli_query($con, $sqlcust);
        while($rowc=mysqli_fetch_array($querycust)){
                 $cname=$rowc['fullname'];
                 $cid=$rowc['custid'];
                 echo $cname;
         }
    }

            
}

if(isset($_POST['btn-add-webs'])){
        extract($_POST);
        $custid = $_GET['service'];
        $regdate = date('yy-m-d');
        $uid = $_SESSION['member_id'];
        $dbname = 'somteso';
         // how Find the autto ID
         $nextID="";
         //$dbname="DB_DATABASE";
        $nextIDQuery="SELECT (concat('WSR',LPAD((SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$dbname' AND TABLE_NAME = 'webservice'),4,'0'))) as websid FROM `webservice` limit 1";
        $resultID = mysqli_query($con,$nextIDQuery) or die(mysqli_error($con));
        if($Re=mysqli_fetch_row($resultID)){
            $nextID= $Re[0];
        }
             
         if($nextID==null){
            $nextID='WSR0001';
         }
         //echo $nextID; exit();
         //End of Auto ID generation 
         
         
        $sql = "INSERT INTO webservice (custid,serid, amount, discount, webname, url, startdate, enddate, regdate, referenceno, userid) VALUES ";
        $sql .= " ('$custid', '$ser_type' ,  '$seramount', '$dis' , '$webname', '$weburl', '$sdate',  '$edate', '$regdate' , '$regdate', '$uid' ) ";
        $result = mysqli_query($con, $sql);
        if($result){
                     //cash activity Revenue Collections
         $des='Web Service';
         $amountactivity = $seramount - $dis;
         
         $sqlcashact2="INSERT INTO cashactivity VALUES(null, '$des',  '10100',  '$amountactivity',  '0', '$regdate', '$nextID')";
         $quercashact1=mysqli_query($con, $sqlcashact2);
         
         $sqlcashact1="INSERT INTO cashactivity VALUES(null, '$des',  '$ser_type',  '0',  '$amountactivity', '$regdate', '$nextID')";
         $quercashact=mysqli_query($con, $sqlcashact1);

         echo "
         <script>
         Swal.fire({
         position: 'center',
         icon: 'success',
         title: 'Invoice created successfully.',
         showConfirmButton: false,
         timer: 3500
         }).then((result) => {
             window.location.href = 'webservicecollect'
           })
         </script>
         
         ";
         
        }else{


        }
        //$r = mysqli_fetch_assoc($result);
        //$lastId = $db->lastInsertId(); 
           
            
         
         

         
         
         //End of Revenue cash activity
         
         
         

             
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