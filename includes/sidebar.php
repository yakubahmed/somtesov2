<?php
function get_user_group(){
    global $con;
    $id = $_SESSION['member_id'];
    $stmt = "SELECT * FROM groups WHERE groupID IN (SELECT groupID from users WHERE User_id = $id )";
    $result = mysqli_query($con, $stmt);
    if($result){
        $row = mysqli_fetch_assoc($result);
        echo $row['name'];
    }else{
        echo "Fialed";
    }
}

?>

<div class="left-side-menu " style='background:#efefef;'>
                <div class="media user-profile mt-2 mb-2">
                    <img src="assets/images/<?php echo $_SESSION['img'];?>" class="avatar-sm rounded-circle mr-2" alt="" />
                    <img src="assets/images/<?php echo $_SESSION['img'];?>" class="avatar-xs rounded-circle mr-2" alt="" />

                    <div class="media-body">
                        <h6 class="pro-user-name mt-0 mb-0"><?php echo $_SESSION['fname'];?></h6>
                        <span class="pro-user-desc"><?php get_user_group(); ?></span>
                    </div>
                    <div class="dropdown align-self-center profile-dropdown-menu">
                        <a class="dropdown-toggle mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                            aria-expanded="false">
                            <span data-feather="chevron-down"></span>
                        </a>
                        <div class="dropdown-menu profile-dropdown">
                            <a href="pages-profile.html" class="dropdown-item notify-item">
                                <i data-feather="user" class="icon-dual icon-xs mr-2"></i>
                                <span>My Account</span>
                            </a>

                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i data-feather="settings" class="icon-dual icon-xs mr-2"></i>
                                <span>Settings</span>
                            </a>

                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i data-feather="help-circle" class="icon-dual icon-xs mr-2"></i>
                                <span>Support</span>
                            </a>

                            <a href="pages-lock-screen.html" class="dropdown-item notify-item">
                                <i data-feather="lock" class="icon-dual icon-xs mr-2"></i>
                                <span>Lock Screen</span>
                            </a>

                            <div class="dropdown-divider"></div>

                            <a href="logout" class="dropdown-item notify-item">
                                <i data-feather="log-out" class="icon-dual icon-xs mr-2"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-content">
                    <!--- Sidemenu -->
                    <div id="sidebar-menu" class="slimscroll-menu">
                        <ul class="metismenu" id="menu-bar">
                            <li class="menu-title">Navigation</li>
                                <?php
                                    $user=$_SESSION['member_id'];
                                    
                                    $sql = "SELECT m.mid, m.mname, menuicon FROM submenu s INNER JOIN menu m on m.mid=s.mid INNER JOIN privilege p ON  s.subid=p.subid ";
                                    $sql .= " WHERE  p.groupID in (SELECT  groupID FROM users WHERE User_id='$user') ";
                                    $sql .= " GROUP BY m.mname ORDER BY s.subid";
                                    $query=mysqli_query($con, $sql);
                                    while($record=mysqli_fetch_array($query)){
                                        $id=$record[0];
                                ?>
                                        
                                <?php
                                    $sql1 = " SELECT count(s.subid) FROM submenu s INNER JOIN menu m ON m.mid=s.mid ";
                                    $sql1 .= "INNER JOIN privilege p ON  s.subid=p.subid ";
                                    $sql1 .= "WHERE p.groupID in (select groupID from users where User_id=$user) AND s.mid='$id' ";
                                    $query1=mysqli_query($con, $sql1);
                                    while($record1=mysqli_fetch_array($query1)){
                                        $num=$record1[0];
                                    }
                                ?>

                                <li>
                                    <a href="javascript: void(0);">
                                        <i data-feather="<?php echo $record[2]  ?>" ></i>
                                        
                                        <span> <?php echo $record[1]; ?> </span>
                                        <span class="menu-arrow "></span>
                                    </a>

                                    <ul class="nav-second-level" aria-expanded="false">                                       
                                        <?php
                                            $s = "SELECT s.subid, s.subname, s.url FROM submenu s INNER JOIN menu m ON m.mid=s.mid ";
                                            $s .= "INNER JOIN privilege p on  s.subid=p.subid ";
                                            $s .= "where p.groupID in (select groupID from users where User_id='$user') and s.mid='$id' ";
                                            $s .= "group by s.subname order by s.subid";
                                            $qu=mysqli_query($con, $s);
                                            while($re=mysqli_fetch_array($qu)){
                                                
                                            
                                            ?>
                                            <li > <a href="<?php echo $re[2]; ?>"><?php echo $re[1]; ?></a> </li>
                                            
                                        
                                        
                                        <?php }?>

                                    </ul>
                                </li>

                             <?php } ?>

                        </ul>
                    </div>
                    <!-- End Sidebar -->

                    <div class="clearfix"></div>
                </div>
                <!-- Sidebar -left -->

            </div>