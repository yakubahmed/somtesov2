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
                                    <div class="card-header bg-info text-ligiht"> Registered Customers  </div>
                                    <div class="card-body">
                                        <div class="from-group my-2">
                                            <a href="add-expanse" class='btn btn-info'> Add new expanse </a>
                                        </div>
                                        <table id="basic-datatable" class="table table-striped dt-responsive nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Payee name</th>
                                                    <th>Description</th>
                                                    <th>Account name</th>
                                                    <th>Amount</th>
                                                    <th>Post date</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                        
                                        
                                            <tbody>
                                                <?php
                                                    $stmt = "SELECT * FROM view_expanses";
                                                    $result = mysqli_query($con, $stmt);
				                                   
				                                    while($row = mysqli_fetch_assoc($result)){
                                                        $id = $row['expenseid'];
                                                        $pyname = $row['payeename'];
                                                        $desc = $row['description'];
                                                        $accname = $row['accountname'];
                                                        $amount = $row['amount'];
                                                        $posdate = $row['posdate'];
			                                    ?>
                                                <tr>
                                                    <td><?php echo $row['payeename']; ?></td>
                                                    <td><?php echo $row['description']; ?></td>
                                                    <td><?php echo $row['accountname']; ?></td>
                                                    <td><?php echo $row['amount']; ?></td>
                                                    <td><?php echo $row['posdate']; ?></td>
                                                    
                                                    <td >
                                                        <a href="add-expanse?action=update&id=<?php echo $id ?>&accname=<?php echo $accname; ?>&desc=<?php echo $desc; ?>&amount=<?php echo $amount; ?>&payeename=<?php echo $pyname; ?>&amount=<?php echo $amount; ?>&date=<?php echo $posdate; ?>" class='btn btn-info edite' style='padding:0;' data-toggle='tooltip' title='Edit'>
                                                            <svg class="bi bi-pencil" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"/>
                                                                <path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z"/>
                                                            </svg>
                                                        </a>

                                                        <a href='manage-expanses?delete=true&id=<?php echo $id; ?>' class='btn btn-danger delete' style='padding:0;' data-toggle='tooltip' title='Delete'> 
                                                            <svg class='bi bi-trash-fill' width='1em' height='1em' viewBox='0 0 16 16' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
                                                                <path fill-rule='evenodd' d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z'/>
                                                            </svg>
                                                        </a>
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
        $stmt  = "DELETE FROM expenses WHERE expenseid = $id";
        $result = mysqli_query($con, $stmt);
        if($result){
            echo "
            <script>
                Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Expanse deleted successfully.',
                showConfirmButton: false,
                timer: 3500
                }).then((result) => {
                    window.location.href = 'manage-expanses'
                })
            </script>
            
            ";
        }
    }
?>
