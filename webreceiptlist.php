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
                                    <div class="card-header bg-success text-ligiht"> Payment Receipt  </div>
                                    <h4 class='mx-4'> All customers</h4>
                                    <div class="card-body">
                                        <div class="from-group my-">
                                            <a href="add-customer" class='btn btn-info'> Add new  </a>
                                        </div>
                                        <br>
                                        <table id="basic-datatable" class="table table-striped dt-responsive nowrap">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Full Name</th>
                                                    <th>Gender</th>
                                                    <th>Address</th>
                                                    <th>Phone number</th>
                                                    <th>Email Address</th>
                                                    <th align="center">Action</th>
                                                </tr>
                                            </thead>
                                        
                                        
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                    $result = mysqli_query($con, "SELECT * FROM customer ORDER BY fullname DESC");
                                                    while($row = mysqli_fetch_assoc($result)){
                                                        $id = $row['custid'];
                                                ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo $row['fullname']; ?></td>
                                                    <td><?php echo $row['gender']; ?></td>
                                                    <td> <?php echo $row['address']; ?></td>
                                                    <td><?php echo $row['phone']; ?></td>
                                                    <td><?php echo $row['emailaddress']; ?> </td>
                                                    <td>
                                                        <a href="webservicecollect?service=<?php echo $id; ?>" class="btn btn-success btn-sm edit btn-flat"  >	<i class="icon-plus-sign icon-large"></i> Receipt</a>
                                                    </td>
                                                </tr>
                                             <?php } ?>
                                            </tbody>
                                        </table>
                                        
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
