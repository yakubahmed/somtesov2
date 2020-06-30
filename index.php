<?php include('includes/header.php'); ?>
<?php

function disp_progres(){
    global $con;

    $gid=$_SESSION['groupID'];
    $group="SELECT g.name FROM groups g WHERE g.groupID='$gid'";
    $querygr=mysqli_query($con, $group);
    while($rowgr=mysqli_fetch_array($querygr)){
        $gname=$rowgr[0];
    }
    if($gname=='admin' OR $gname=='Admin'){
        $stdcount = "SELECT * FROM view_progress ";
        $resulty= mysqli_query($con, $stdcount);
        //$number=0.00;
        while($ro=mysqli_fetch_array($resulty)){
            //$dname=$ro[0];
            $days=$ro[5];
            $number=$ro[6];
            $sername=$ro[2];
            $sertype=$ro[1];
            
            if ($days==0){
                $nofee=0;
                
            }
            else{
                $nofee= number_format(($number / $days)*100, 2);
            }

            echo "
            <div class='media px-3 py-4 border-bottom'>
                <div class='media-body'>
                    <h4 class='mt-0 mb-1 font-size-22 font-weight-normal'>
                        <div class='progress'>
                            <div class='progress-bar progress-bar-striped' role='progressbar' style='width: $nofee%' aria-valuenow='$nofee' aria-valuemin='0' aria-valuemax='100'>$nofee%</div>
                        </div>
                    </h4>
                    <span class='text-muted'> <a href='$sername' target='_BLANK'>$sername</a> <strong> ($sertype)</strong> </span>
                </div>
            </div>
            ";
        }
    }
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

                        <!-- content -->
                        <div class="row">

                            <div class="col-md-6 col-xl-3">
                                <div class="card">
                                    <div class="card-body p-0">
                                        <div class="media p-3">
                                            <div class="media-body">
                                                <span class="text-muted text-uppercase font-size-12 font-weight-bold">Current web projects
                                                    </span>
                                                <h2 class="mb-0"> 
                                                    <strong>
                                                    <?php
                                                        $sql = "SELECT custid FROM webservice w WHERE iscompleted=false and DATE_FORMAT(w.regdate, '%M')=MONTHNAME(now())";
                                                        $query = $con->query($sql);
                                                        echo $query->num_rows;
                                                    ?>
                                                    </strong> 
                                                </h2>
                                            </div>
                                            
                                        </div>
                                        <hr>
                                            <center><a href="" class=''>More info</a></center>
                                            <br>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="col-md-6 col-xl-3">
                                <div class="card">
                                    <div class="card-body p-0">
                                        <div class="media p-3">
                                            <div class="media-body">
                                                <span class="text-muted text-uppercase font-size-12 font-weight-bold">Completed web projects</span>
                                                <h2 class="mb-0"> 
                                                    <strong>
                                                    <?php
                                                        $sql = "SELECT custid FROM webservice w WHERE iscompleted=true and DATE_FORMAT(w.regdate, '%M')=MONTHNAME(now())";
                                                        $query = $con->query($sql);
                                                        echo $query->num_rows;
                                                    ?>

                                                    </strong> 
                                                </h2>
                                            </div>
                                           
                                        </div>
                                        <hr>
                                            <center><a href="" class=''>More info</a></center>
                                            <br>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="col-md-6 col-xl-3">
                                <div class="card">
                                    <div class="card-body p-0">
                                        <div class="media p-3">
                                            <div class="media-body">
                                                <span class="text-muted text-uppercase font-size-12 font-weight-bold">Customers</span>
                                                <h2 class="mb-0"> 
                                                    <strong>
                                                    <?php
                                                        $sql = "select fullname from customer";
                                                        $query = $con->query($sql);
                                                        echo $query->num_rows;
                                                    ?>
                                                    </strong> 
                                                </h2>
                                            </div>
                                            
                                        </div>
                                        <hr>
                                            <center><a href="" class=''>More info</a></center>
                                            <br>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="col-md-6 col-xl-3">
                                <div class="card">
                                    <div class="card-body p-0">
                                        <div class="media p-3">
                                            <div class="media-body">
                                                <span class="text-muted text-uppercase font-size-12 font-weight-bold">Users</span>
                                                <h2 class="mb-0"> 
                                                    <strong>
                                                        <?php
                                                            $sql = "select User_id from users";
                                                            $query = $con->query($sql);

                                                            echo "<h3>".$query->num_rows."</h3>";
                                                        ?>
                                                    </strong> 
                                                </h2>
                                            </div>
                                           
                                        </div>
                                        <hr>
                                            <center><a href="" class=''>More info</a></center>
                                            <br>
                                    </div>
                                </div>
                            </div>

                          
                        </div>

                        <!-- stats + charts -->
                        <div class="row">
                            <div class="col-xl-8">
                                <div class="card">
                                    <div class="card-body p-0">
                                        <h5 class="card-title header-title border-bottom p-3 mb-0">Progress of the projects</h5>
                                        <?php disp_progres(); ?>
                                    </div>
                                </div>
                            </div>

                         

                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body pb-0">
                                        <h5 class="card-title header-title">Income</h5>
                                        <div id="targets-chart" class="apex-charts mt-3" dir="ltr"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- row -->
                
                       
                    </div>
                </div> <!-- content -->

<?php include('includes/footer.php'); ?>