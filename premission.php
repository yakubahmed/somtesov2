<?php include('includes/header.php'); ?>
<!-- plugin css -->
<link href="assets/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="assets/libs/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="assets/libs/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="assets/libs/datatables/select.bootstrap4.min.css" rel="stylesheet" type="text/css" /> 
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
                        <div class="col-12">
                                <div class="card">
                                    <div class="card-header bg-success text-light"> Premissions  </div>
                                    <div class="card-body">
                                        <form  method="post">
                                            <div class="from-group col-md-4">
                                                <label for=""> Previlege Sitting </label>
                                                <select name='group'  class="form-control select2" required>
                                                    <option value=""> Select premession</option>
                                                    <?php 
                                                        $ggid=$_SESSION['groupID'];
                                                        $sqgr="select g.groupID, g.name, u.User_id from groups g inner join users u  where g.groupID='$ggid'";
                                                        $quegr=mysqli_query($con, $sqgr);
                                                        while($row=mysqli_fetch_array($quegr)){
                                                            $gname=$row[1];	
                                                            
                                                        }
                                                        if($gname!='Supper Admin'){
                                                            $sql="Select * from groups where name!='Supper Admin' order by groupID desc";
                                                        }
                                                        else{
                                                            $sql="Select * from groups order by groupID desc";
                                                        }
                                                        $query=mysqli_query($con, $sql);
                                                        while($re=mysqli_fetch_array($query)){
                                                        ?>
						                                <option  value="<?php echo $re[0]; ?>"> <?php echo $re[1];?> </option>
		                                                <?php }	?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4 my-4">
                                                <label for=""></label>
                                                <input type="submit" value="Show" class="btn btn-info" name='btnShow'>
                                            </div>

                                            <?php
			  if(isset($_POST['show']) ){
				$_SESSION['gid']=$_POST['btnShow'];
				  
			  ?>
				  <form action="" method="post" >
						<?php
	                      
		  $sql="select * from menu";
		  $query=mysqli_query($con, $sql);
		  while($record=mysqli_fetch_array($query)){
			  $id=$record[0];
			  echo " <ul  data-widget='tree' style='list-style-type: none;'>
					   <li class='treeview'>
			 <input  type='checkbox' value='$record[0]'>"." <strong class='label label-warning'><b>".$record[1]."</b></strong><br>";
			   echo" <ul style='list-style-type: none;'>";
			  
			  $s="select * from submenu where mid='$id'";
			  
			 $qu=mysqli_query($con, $s);
			  
			 while($re=mysqli_fetch_array($qu)){
				 
				 $gr=$_SESSION['gid'];
				 
				 $ss="SELECT subid FROM privilege WHERE subid='$re[0]' and groupID='$gr'";
				 $querym=mysqli_query($con, $ss);
				  $rem=mysqli_fetch_array($querym);
				 if($rem==''){
					 
					  echo " <li> <input type='checkbox'name='menu[]' value='$re[0]'>"." ".$re[1]."</li>";
				 }
				 else
				 {
					  echo " <li> <input type='checkbox'name='menu[]' checked value='$re[0]'>"." ".$re[1]."</li>";
				 }
				 
		   
				 
			 }
			  echo "</ul></li></ul>";
			
				
		  }
        
					?>
					<input type="submit" name="submit" value="Set Previlege" class="btn btn-success btn-flat">
				</form>
					  <?php
				 
			  }
				  ?>
                                        </form>
                                        
                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <!-- row -->
                
                       
                    </div>
                </div> <!-- content -->

<?php include('includes/footer.php'); ?>
<!-- datatable js -->
<script src="assets/libs/datatables/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
<script src="assets/libs/datatables/dataTables.responsive.min.js"></script>
<script src="assets/libs/datatables/responsive.bootstrap4.min.js"></script>

<script src="assets/libs/datatables/dataTables.buttons.min.js"></script>
<script src="assets/libs/datatables/buttons.bootstrap4.min.js"></script>
<script src="assets/libs/datatables/buttons.html5.min.js"></script>
<script src="assets/libs/datatables/buttons.flash.min.js"></script>
<script src="assets/libs/datatables/buttons.print.min.js"></script>

<script src="assets/libs/datatables/dataTables.keyTable.min.js"></script>
<script src="assets/libs/datatables/dataTables.select.min.js"></script>

<!-- Datatables init -->
<script src="assets/js/pages/datatables.init.js"></script>

<script>
$('.delete').on('click', function(e){
        e.preventDefault();
        const href = $(this).attr('href')

        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.value) {
            document.location.href=href;
          }
        })
})
</script>  

<?php 
    if(isset($_GET['delete'])){
        $id = $_GET['id'];
        $stmt  = "DELETE FROM customer WHERE custid = $id";
        $result = mysqli_query($con, $stmt);
        if($result){
            echo "
            <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Customer deleted succesfully.',
            showConfirmButton: false,
            timer: 3500
            }).then((result) => {
                window.location.href = 'manage-customers'
              })
            </script>
            
            ";
        }
    }
?>
