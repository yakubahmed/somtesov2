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
                                           <?php  if(isset($_GET['action']) && $_GET['action'] == 'update') { echo "Update customer detail";  }else{echo "Add new customer";}?> 
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label for=""> Full name </label>
                                                    <input type="text" name="fname" id="" class="form-control" placeholder="e.g Yakub Ahmed" required value="<?php get_fullname();?>">
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for=""> Gender </label>
                                                    <select name="gender" id="" class='form-control' required>
                                                        <?php get_gender(); ?>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for=""> Contact Address </label>
                                                    <input type="text" name="addr" id="" class="form-control" placeholder="e.g Heliwa, Mogadishu" required value="<?php get_addr(); ?>">
                                                </div>

                                                
                                                <div class="form-group col-md-4">
                                                    <label for=""> Phone number </label>
                                                    <input type="number" name="phone" id="" class="form-control" placeholder="e.g 0610000000" required value="<?php  get_phone(); ?>">
                                                </div>

                                                
                                                <div class="form-group col-md-4">
                                                    <label for=""> Contact Email </label>
                                                    <input type="email" name="email" id="" class="form-control" placeholder="e.g someone@mail.com" required value="<?php get_email();?>">
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for=""> Registration date </label>
                                                    <input type="date" name="rdate" id="" class="form-control" placeholder="" required value="<?php get_r_date(); ?>">
                                                </div>

                                            </div>
                                        </div>
                                        
                                    
                                    <div class="card-footer">
                                        <?php if(isset($_GET['action']) && $_GET['action'] == 'update'){  ?>
                                            <input type="submit" value="Update" class="btn btn-info" name='update-customer'>
                                        <?php }else{ ?>
                                            <input type="submit" value="Register" class="btn btn-info" name='add-customer'>
                                        <?php }?>
                                        <a href="manage-customers" class='btn btn-success'> View customers </a>
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
if(isset($_POST['add-customer'])){
    $fn=$_POST['fname'];
    $ge=$_POST['gender'];
    $add=$_POST['addr'];
    $ph=$_POST['phone'];
    $ma=$_POST['email'];
    $reg=$_POST['rdate'];
                
    //mysqli_query		
    $sqlcheck=mysqli_query($con,"select Phone, fullname, emailaddress from customer where phone='$ph'");
    while($rowph=mysqli_fetch_array($sqlcheck)){
        echo $rowphone=$rowph[0];
        echo $rowemail=$rowph[1];
        echo $rowfname=$rowph[2];
    }

    if($rowphone==$ph) {
        echo "
        <script>
            Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Customer with this number: $ph is allready registered, try agian ',
            showConfirmButton: false,
            timer: 3500
            })
        </script>
        
        "; 
    }elseif($rowemail == $ma ){
        echo "
        <script>
            Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Customer with this email: $ma is allready registered, try agian ',
            showConfirmButton: false,
            timer: 3500
            })
        </script>
        
        "; 
    }elseif($rowfname ==  $fn ){
        echo "
        <script>
            Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Customer with this name: $fn is allready registered, try agian ',
            showConfirmButton: false,
            timer: 3500
            })
        </script>
        
        "; 
    }else{
        $sqlsave="insert into customer values(custid, '$fn', '$ge', '$add', '$ph', '$ma', '$reg' )";
        $querycust=mysqli_query($con, $sqlsave);
        echo "
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Customer added successfully',
            showConfirmButton: false,
            timer: 1500
            }).then((result) => {
                window.location.href = 'add-customer'
            })
        </script>
        
        "; 
                
    }
}

function get_fullname(){
    if(isset($_POST['fname'])){
        echo $_POST['fname'];
    }elseif(isset($_GET['fname'])){
        echo $_GET['fname'];
    }
}

function get_gender(){
    if(isset($_POST['gender'])){
        if($_POST['gender'] == 'Male'){
            echo "
                <option value='Male'>Male</option>
                <option value='Female'>Female</option>
            ";
        }elseif($_POST['gender'] == "Female"){
            echo "
            <option value='Female'>Female</option>
            <option value='Male'>Male</option>
            ";
        }
        
    }elseif($_GET['gender']){
        if($_GET['gender'] == 'Male'){
            echo "
                <option value='Male'>Male</option>
                <option value='Female'>Female</option>
            ";
        }elseif($_GET['gender'] == "Female"){
            echo "
            <option value='Female'>Female</option>
            <option value='Male'>Male</option>
            ";
        }
    }else{
        echo "
        <option value=''>Select Gender</option>
        <option value='Male'>Male</option>
        <option value='Female'>Female</option>
        ";
    }
}

function get_addr(){
    if(isset($_POST['addr'])){
        echo $_POST['addr'];
    }elseif(isset($_GET['adrr'])){
        echo $_GET['adrr'];

    }
}

function get_phone(){
    if(isset($_POST['phone'])){
        echo $_POST['phone'];
    }elseif(isset($_GET['phone'])){
        echo $_GET['phone'];
    }
}

function get_email(){
    if(isset($_POST['email'])){
        echo $_POST['email'];
    }elseif(isset($_GET['mail'])){
        echo $_GET['mail'];
    }else{
        echo '';
    }
}

function get_r_date(){
    if(isset($_POST['rdate'])){
        echo $_POST['rdate'];
    }elseif($_GET['date']){
        echo $_GET['date'];
    }
}

if(isset($_POST['update-customer'])){
    $fn=$_POST['fname'];
    $ge=$_POST['gender'];
    $add=$_POST['addr'];
    $ph=$_POST['phone'];
    $ma=$_POST['email'];
    $reg=$_POST['rdate'];
    $id = $_GET['id'];

    $stmt = "UPDATE customer SET fullname = '$fn', gender = '$ge', address='$add', emailaddress='$ma', regdate='$reg' WHERE custid = $id";
    $result = mysqli_query($con, $stmt);
    if($result){
        echo "
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Customer updated successfully',
            showConfirmButton: false,
            timer: 1500
            }).then((result) => {
                window.location.href = 'manage-customers'
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
                window.location.href = 'manage-customers'
            })
        </script>
        
        "; 
    }
    
}
   
?>