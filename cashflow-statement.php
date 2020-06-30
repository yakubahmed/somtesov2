<?php include('includes/header.php'); ?>
<link rel="stylesheet" href="assets/css/custome-style.css">
<script>
 function PrintDoc() {

        var toPrint = document.getElementById('printarea');

        var popupWin = window.open('', '_blank', 'width=595,height=842,location=no,left=200px');

        popupWin.document.open();

        popupWin.document.write('<html><title></title><link rel="stylesheet" type="text/css" href="print.css" /></head><body  onload="window.print()">')

        popupWin.document.write(toPrint.innerHTML);

        popupWin.document.write('</html>');

        popupWin.document.close();

    }
</script>
    <body>
    <?php
        function formatDollars($dollars)
        {
            $formatted = "$" . number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $dollars)), 2);
            return $dollars < 0 ? "({$formatted})" : "{$formatted}";
        }
	?>
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
                                   
                                       
                                        <div class="card-header bg-primary text-light ">
                                            Cash flow statements
                                        </div>
                                        <div class="card-body">
                                           
                                            <form  method="post">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Start Date</label>
                                                         <?php $dt = date('Y-m-d'); ?>
                                                        <input type="date" name="sdate"  value="<?php echo  date("Y-m-01", strtotime($dt));?>" class="form-control" id="exampleInputEmail1">
                                                    </div>


                                                    <div class="col-md-6">
                                                        <label>End Date</label>
                                                        <input type="date" name="edate" value="<?php echo  date('Y-m-d');?>" class="form-control" id="exampleInputEmail1">
                                                    </div>

                                                    <div class="col-md-6 my-4">
                                                        <input type="submit" value="Preiview statement" class="btn btn-info" name='btnPreview'>
                                                    </div>

                                                    </div>
                                                </div>
                                            </form>

                                            <?php
                                                $sdate="";
                                                $edate="";
                                                    if(isset($_POST['btnPreview']) ){
                                                    $sdate=$_POST['sdate'];
                                                    $edate=$_POST['edate'];
                                                    $_SESSION['sdate']= $sdate;
                                                    $_SESSION['edate']=$edate;
                                                    
                                                        //echo $edate;
                                            ?>

                                            <div class="col-md-12">
                                                
                                                <div align="center">

                                                    <div id="printarea">
                                                        <div class="form-group col-md-12">
                                                            <button type="button"  class="btn btn-primary " onclick="PrintDoc()"> <i data-feather="printer" ></i>&nbsp;Print</button>&nbsp;<a href="receiptlist.php"></a>

                                                        </div>
                                                        <table class="table-condensed" border="1" width=80%>
            
                                                            <tr>
                                                                <td> <center><img src="assets/images/banner.png" width="100%" height="180" /> </center></td>

                                                            </tr>
                                                            <tr>
                                                                <td style="text-align:center"><strong> Cash Flow Statement -  (<?php  echo $sdate.'---'.$edate; ?>)  </strong></td>
                                                            </tr>

                                                            <tr>

                                                            <!-- New Inside Tables are staring here -->
                                                            <table class="active" border="1" width="80%">
                                                            <?php
                                                                //where ac.catogary='INCOME' and DATE_FORMAT(ca.postDate, '%M')!=MONTHNAME(now())
                                                                $beginblance="select ac.accountname, sum(ca.Cr) from cashactivity ca inner join accounts ac on ca.accountNo=ac.accountNo";
                                                                $beginblance .= " where ac.catogary='INCOME' and ca.postDate < '$sdate' group by ac.accountname";
                                                                $resultbalance = mysqli_query($con,$beginblance) or die(mysqli_error($link));
                                                                $gigIncome=0.0;
                                                                while($Rebalance=mysqli_fetch_row($resultbalance))
                                                                {
                                                                    $gigIncome += $Rebalance[1];
                                                                }
                                                                //here begining expense
                                                                $beginblance1="SELECT  ac.accountname, coalesce (sum(ca.Dr), 0), ca.postDate from cashactivity ca ";
                                                                $beginblance1 .= "right join accounts ac on ca.accountNo=ac.accountNo where  ac.catogary='EXPENSES' and ca.postDate < '$sdate' ";
                                                                $beginblance1 .= "group by ac.accountname";
                                                                $resultbalance1 = mysqli_query($con,$beginblance1) or die(mysqli_error($con));
                                                                    $gigIncome1=0.0;
                                                                        while($Rebalance1=mysqli_fetch_row($resultbalance1))
                                                                        {
                                                                            $gigIncome1 += $Rebalance1[1];
                                                                        }
                                                                        
                                                                 $resultfinalbalance=$gigIncome - $gigIncome1;
                
                
                                                                echo "<tr style='bgcolor:pink;'> <th style='text-align:left;'>Begining Balance </th> <th><b>". formatDollars($resultfinalbalance) ."</b></th>  </tr>";    
                                                                $Dr=0;
                                                                $Cr=0;
                                                                $header="<tr> <th colspan='2' style='text-align:left'>CASH RECEIPT </th>   </tr>";
                                                                $query="select ac.accountname, sum(ca.Cr), ca.accountNo from cashactivity ca
                                                                inner join accounts ac on ca.accountNo=ac.accountNo
                                                                where ac.catogary='INCOME' and ca.postDate between '$sdate' and '$edate'
                                                                group by ac.accountname";

                                                                $result = mysqli_query($con,$query) or die(mysqli_error($con));
                                                                echo $header;
                                                                $sn=1;
                                                                while($Re=mysqli_fetch_row($result))
                                                                {
                                                                    echo "<tr>";
                                                                    
                                                                    
                                                                    echo "<td>".$Re[0]."</td>";
                                                                    
                                                                    echo "<td style='text-align:right'><a href='../reports/accountdetails.php?accid=$Re[2]'>". formatDollars($Re[1]) ."</a></td>";
                                                                    $Cr+=$Re[1];
                                                                
                                                                    echo "</tr>" ;
                                                                }
                                                                
                                                                ?>
                
                                                                <tr bgcolor="#CBEBD8">
                                                                    <td  style="text-align:right" > 
                                                                        <strong>
                                                                            
                                                                            <div align="right" >
                                                                            Total Cash Receipts + Begining Balance 
                                                                            </div>
                                                                        </strong> 
                                                                    </td>
                                                                    <td style="text-align:right"> <strong><u> <?php echo   formatDollars($Cr + $resultfinalbalance)?> </u></strong></td>
                                                                </tr>
            
                                                                <?php
                                                                    $Dr=0;
                                                                    $header="<tr> <th colspan='2' style='text-align:left'>CASH PAYMENT</th>   </tr>";
                                                                    $query="select ac.accountname, coalesce (sum(ca.Dr), 0), ca.postDate, ca.accountNo from cashactivity ca
                                                                    right join accounts ac on ca.accountNo=ac.accountNo
                                                                    where  ac.catogary='EXPENSES' and ca.postDate between '$sdate' and '$edate'
                                                                    group by ac.accountname";
                
                                                                    $result = mysqli_query($con,$query) or die(mysqli_error($con));
                                                                    echo $header;
                                                                    $sn=1;
                                                                    while($Re=mysqli_fetch_row($result))
                                                                    {
                                                                        echo "<tr>";
                                                                        
                                                                        
                                                                        echo "<td>".$Re[0]."</td>";
                                                                        echo "<td style='text-align:right'><a href='accountdetails.php?accid=$Re[3]'>". formatDollars($Re[1]) ."</a></td>";
                                                                        
                                                                        $Dr+=$Re[1];
                                                                    
                                                                        echo "</tr>" ;
                                                                    }
                                                                    
                                                                    ?>
                
                                                                    <tr bgcolor="#CBEBD8">
                                                                        <td  style="text-align:right" > 
                                                                            <strong>
                                                                                
                                                                                <div align="right" >
                                                                                Total Cash Payments
                                                                                </div>
                                                                            </strong> 
                                                                        </td>
                                                                        <td style="text-align:right"> <strong><u> <?php echo   formatDollars($Dr)?> </u></strong></td>
                                                                    </tr>
        
                                                                    <tr bgcolor="#CBEBD8">
                                                                            <td  style="text-align:right" > 
                                                                                <strong>
                                                                                    
                                                                                    <div align="right" >
                                                                                        NET CASH
                                                                                    </div>
                                                                                </strong> 
                                                                            </td>
                                                                            <td style="text-align:right; text-decoration: underline double;"> <strong> 
                                                                            <?php 
                                                                            echo  formatDollars($Cr- $Dr + $resultfinalbalance);
                                                                            ?></strong></td>
                                                                            

                                                                    </tr>
            
            
                                                            </table>





                                                        </tr></table>
                                                        <table class="table-condensed" border="0" width=80%>
    
    <thead>
               <tr> 
            
               
                 <th><center> Prepared By: </center></th>
                 <th><center> Checked By: </center></th>
                 
                 
               </tr>
             </thead>
   
    <tbody>
    <tr>
        <td><center>Cashier</center> </td>
           <td> <center>Accountant Manager</center></td>
             
    </tr>
    <tr>
        <td><center>_________________</center></td>
           <td> <center>_________________</center></td>
             
    </tr>
    
    </tbody>
   </table>
       
       </div>
       <?php }
       ?>
          </table>
                                                    </div>
                                                </div>
                                            </div>
                                            

                                       
                                         
                                        </div>
                                        
                                    
                                  
                                    
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