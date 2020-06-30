<?php include('includes/header.php'); ?>
<link rel="stylesheet" href="assets/css/custome-style.css">

<!-- plugin css -->
<link href="assets/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="assets/libs/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="assets/libs/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="assets/libs/datatables/select.bootstrap4.min.css" rel="stylesheet" type="text/css" /> 

<script>
function printDiv(data) {
      var printContents = document.getElementById('data').innerHTML;    
   var originalContents = document.body.innerHTML;      
   document.body.innerHTML = printContents;     
   window.print();     
   document.body.innerHTML = originalContents;
   }
</script>
<script>
 function PrintDoc() {

        var toPrint = document.getElementById('printarea');

        var popupWin = window.open('', '_blank', 'width=595,height=842,location=no,left=200px');

        popupWin.document.open();

        popupWin.document.write('<html><title></title><link rel="stylesheet" type="text/css" href="print.css" /></head><body onload="window.print()">')

        popupWin.document.write(toPrint.innerHTML);

        popupWin.document.write('</html>');

        popupWin.document.close();

    }
</script>
<?php
function formatDollars($dollars)
{
    $formatted = "$" . number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $dollars)), 2);
    return $dollars < 0 ? "({$formatted})" : "{$formatted}";
}
	?>
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
                                        <div class="card-header bg-success text-light"> Customer Report  </div>
                                        <div class="card-body">
                                         <div align="center">
                                            <div id="printarea">
                                                <div class="table-responsive">
                                                    <div class="form-group col-md-12">
                                                    <button type="button"  class="btn btn-info " onclick="PrintDoc()"><i data-feather="printer" ></i>&nbsp;Print</button>&nbsp;<a href="receiptlist.php">
                                                    </div>
                                            <table class="table-condensed" border="1" width=80%>
            
                                                <tr>
                                                    <td colspan="9"> <img src="assets/images/banner.png" width="100%" height="180" /></td>

                                                </tr>
            
                                                <tr>
                                                    <th>Serial No.</th>
                                                    <th>Customer Name</th>
                                                    <th>Gender</th>
                                                    <th>Address</th>
                                                    <th>Phone</th>
                                                    <th>E-Mail Address</th>
                                        
                                                </tr>
                                                <?php
                                                $sqlcust="select * from customer";
                                                $querycust=mysqli_query($con, $sqlcust);
                                                $serialNo=0;
                                                    while($rowc=mysqli_fetch_array($querycust)){
                                                        $serialNo++;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo$serialNo;?></td>
                                                            <td><?php echo $rowc['fullname'];?></td>
                                                            <td><?php echo $rowc['gender'];?></td>
                                                            <td><?php echo $rowc['address'];?></td>
                                                            <td><?php echo $rowc['phone'];?></td>
                                                            <td><?php echo $rowc['emailaddress'];?></td>
                                                        
                                                                
                                                            </tr>
                                                        <?php
                                                    }
                                                ?>
            
            
                                                
                                            </table>
                                            </div>
                                            </div>
                   
                                        
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
