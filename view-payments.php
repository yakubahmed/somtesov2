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
                            <div class="col-md-12">
                                <center>
                                    <script>
                                        function printDiv(data) {
                                            var printContents = document.getElementById('data').innerHTML;    
                                            var originalContents = document.body.innerHTML;      
                                            document.body.innerHTML = printContents;     
                                            window.print();     
                                            document.body.innerHTML = originalContents;
                                        }
                                    </script>

                                    <body style=" background-size:cover; font-family:'Courier New', Courier; background-color:white;">
                                        <?php
                                            function formatDollars($dollars)
                                            {
                                                $formatted = "$" . number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $dollars)), 2);
                                                return $dollars < 0 ? "({$formatted})" : "{$formatted}";
                                            }
                                        ?>

                                    <style type="text/css">
                                        #data { margin: 0 auto; width:800px; padding:20px; background-color: white;  height:600px; }
                                        .stroke{
                                            width: 100px;
                                            border-bottom: 1px solid black;
                                            padding-bottom: 5px;
                                            

                                        }
                                        tr{
                                            border: 1px solid black;
                                        }
                                        td{
                                            border: 1px solid black;
                                        }
                                    </style>
    
                                    <div id="dataA" >

                                        <div id="data" style='background-color: white; height:600px;'>
                                                <center>
                                                <!--<h4>SOMTESO Technology</h4>
                                                <p>Muqdisho - Somalia</p>
                                                <p><strong>Receipt Invoice</strong></p>
                                                <p>Phone: +255-61-5508401</p>
                                                <i style="text-align:right; margin-left:250px;">Print Date: <?php echo date('Y-M-d'); ?></i> -->
                                                </center>
                                                <div id="context">
                                                    <?php
                                                        //session_start();
                                                        $id =$_GET['lastId'];
                                                        //$ssid= $_SESSION['sid'];

                                                        $sql = "SELECT w.websid, c.fullname, w.amount, w.discount, w.webname, w.referenceno, a.accountname, w.url, w.regdate, c.phone
                                                        FROM webservice w INNER JOIN customer c on w.custid=c.custid inner JOIN cashactivity ca on w.referenceno=ca.refno INNER JOIN accounts a on ca.accountNo=a.accountNo WHERE a.catogary='INCOME' and w.websid='$id'";
                                                        $result = mysqli_query($con, $sql);
                                                        while($row = mysqli_fetch_assoc($result)) {
                                                            
                                                            $fna=$row['fullname'];
                                                            $dis=$row['discount'];
                                                            $wname=$row['webname'];
                                                            $amount=$row['amount'];
                                                            $recdate=$row['regdate'];
                                                            $stype=$row['accountname'];
                                                            $invoice=$row['referenceno'];
                                                            $wurl=$row['url'];
                                                            $ph=$row['phone'];
                                                            
                                                        }

                                                        ?>
                                                        <div class="col-md-12">
                                                            <img src="assets/images/banner.png" width="100%" height="140">

                                                            <h4> <strong> <center>RECEIPT VOUCHER</center> </strong> </h4>

                                                            <div class="row " style='width:80%; margin:0 auto;'> 
                                                                <div class="col-md-6"> <p style='color:black; font-size:16px;'> <strong>Rv No: <span class=''> <?php echo $invoice;  ?></span></strong> </p> </div>
                                                                <div class="col-md-6"> <p style='color:black; font-size:16px;'> <strong>Date: <span> <?php echo  date(" jS M, Y", strtotime($recdate )); ?> </span></strong> </p> </div>
                                                            </div>
                                                        </div>
                                                        <div class="table" style='width:80%; margin: 0 auto; '>
                                                            <table class="table "  style='color:black; font-size:16px; '>

                                                            <tr  ><td style='border-top: 1px solid black;'>Customer Name:</td><td colspan="4" style='border-top: 1px solid black;'><?php echo $fna; ?></td>
                                                                
                                                                
                                                                <!-- <td>Student Number</td><td><i>SMART/00<?php echo formatDollars($amount); ?></i></td> -->

                                                                </tr>
                                                            <tr><td bordercolor="#000000">Amount: </td><td><?php echo $amount ?></td>
                                                            <td>Discount:</td><td>$<?php echo $dis;?></td>
                                                            </tr>

                                                            <tr><td>Service Type</td> <td> <?php echo $stype; ?> </td> <td>Total:</td>  <td>  <?php echo $amount - $dis; ?> </td></tr>


                                                            <tr><td colspan="2">Customer:<b><?php echo $_SESSION['username'];?></b></td><td colspan="2">Cashier:  <?php echo $_SESSION['username'];?></td></tr>


                                                            </table>

                                                        </div>


                                                </div>
                                        </div>
                                    <br>	
                                    <!-- -->
                                    </div>
                                    <CENTER><button type="button"  class="btn btn-info " onclick="printDiv(data)"><span
                                        class=" glyphicon glyphicon-print "></span>&nbsp;Print Invoice</button>&nbsp;<a href="webreceiptlist.php"><button class="btn btn-danger"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Go back</button></a></CENTER>
                                    </center>
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