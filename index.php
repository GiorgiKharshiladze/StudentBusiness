<?php session_start();

if(!isset($_SESSION["sess_user"])){
    header("Location:login.php");
}
else 
{
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>ადმინ პანელი</title>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/x-icon" href="img/icons/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="css/fullcalendar.css" />
    <link rel="stylesheet" href="css/matrix-style.css" />
    <link rel="stylesheet" href="css/matrix-media.css" />
    <link rel="stylesheet" href="css/bpg-arial-caps.min.css" />
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/jquery.gritter.css" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
    <style type="text/css">
    .geo {
        font-family: 'BPG Arial Caps', sans-serif !important;
    }
    .bar {
    color: #666666 !important;
    }
    </style>
</head>

<body>
<?php
include("connect.php");
$portfolionum = 0;
$qr1 = mysqli_query($conn, "SELECT * from portfolio");
$portfolionum = mysqli_num_rows($qr1);
?>
    <!--Header-part-->
    <div id="header">
        <h1><a href="#"></a></h1>
    </div>
    <!--close-Header-part-->
    <!--top-Header-menu-->
    <div id="user-nav" class="navbar navbar-inverse">
        <ul class="nav">
            <li class=""><a title="" href="logout.php"><i class="icon icon-user"></i> <span class="text geo">მომხმარებელი: <?php echo $_SESSION["sess_user"];?></span></a></li>
            <li class=""><a title="" href="logout.php"><i class="icon icon-share-alt"></i> <span class="text geo">გასვლა</span></a></li>
        </ul>
    </div>
    <!--close-top-Header-menu-->
    <!--sidebar-menu-->
    <div id="sidebar" class="geo"><a href="#" class="visible-phone"><i class="icon icon-home"></i> მენიუ</a>
        <ul>
            <li class="active geo"><a href="index.php"><i class="icon icon-home"></i> <span>მთავარი</span></a> </li>
            <li class="geo"> <a href="portfolio.php"><i class="icon icon-signal "></i> <span>პორტფოლიო</span> <span class="label label-success"><?php echo $portfolionum?></span></a> </li>
            <li class="geo"> <a href="addperson.php"><i class="icon icon-plus"></i> <span>მონაცემების დამატება</span></a></li>
            <li class="geo"><a href="searchuser.php"><i class="icon icon-search"></i> <span>აპლიკაციის მოძებნა</span></a></li>
            <li class="geo"><a href="stats.php"><i class="icon icon-signal"></i> <span>სტატისტიკა</span></a></li>
            <li class="geo"><a href="calc.php"><i class="icon icon-list-alt"></i> <span>მინი კალკულატორი</span></a></li>
            <?php 

            $paidtome = 0;
            $totaltopay = 0;

            while ($row = mysqli_fetch_assoc($qr1)) 
            {
                $paidtome = $paidtome + $row['paid'];
                $totaltopay = $totaltopay + $row['total'];
            }

            $prog = 0;
            $prcl = "";
            $prog = round($paidtome / $totaltopay * 100, 2);

            if($prog<=30){$prcl="progress progress-striped progress-danger active";}
            elseif($prog<=60){ $prcl="progress progress-striped progress-warning active";}
            elseif($prog<=99){ $prcl="progress progress-striped active";}
            else {$prcl="progress progress-striped progress-success active";}

            ?>
            <li class="content"> <span>სრული ამოღებული თანხა:</span>
                <div class='<?php echo $prcl;?>' style="width: 100%;">
                    <div style="width: <?php echo $prog;?>%;" class="bar"></div>
                </div>
            <center>
                <div class="stat geo" style="font-size: 14px;"><?php echo $paidtome." / ".$totaltopay." ₾ = "; ?>
                    <span class="geo"><?php echo $prog;?>%</span>
                </div>
            </center>
            </li>
        </ul>
    </div>
    <!--sidebar-menu-->
    <!--main-container-part-->
    <div id="content">
        <!--breadcrumbs-->
        <div id="content-header">
            <div id="breadcrumb"> <a href="#" title="მთავარზე გადასვლა" class="tip-bottom geo"><i class="icon-home"></i> მთავარი</a></div>
        </div>
        <!--End-breadcrumbs-->
        
        <!--Action boxes-->
        <div class="container-fluid">
            <div class="quick-actions_homepage" style="text-align: center;">
                <ul class="quick-actions">
                    
                    <li class="bg_lr span3">
                        <a href="index.php"> <i class="icon-home"></i><div class="geo">მთავარი</div></a>
                    </li>
                    <li class="bg_lb span3">
                        <a href="portfolio.php"> <i class="icon-th"></i><span class="label label-success"><?php echo $portfolionum;?></span> <div class="geo">პორტფოლიო</div></a>
                    </li>
                    <li class="bg_lo span3">
                        <a href="addperson.php"> <i class="icon-plus-sign"></i><div class="geo">მონაცემების დამატება</div></a>
                    </li>
                    <li class="bg_ly span3">
                        <a href="searchuser.php"> <i class="icon-search"></i> <div class="geo">აპლიკაციის მოძებნა</div></a>
                    </li>
                    <li class="bg_lg span3">
                        <a href="stats.php"> <i class="icon-signal"></i> <div class="geo">სტატისტიკა</div></a>
                    </li>
                    <li class="bg_ls span3">
                        <a href="calc.php"> <i class="icon-list-alt"></i><div class="geo">მინი კალკულატორი</div></a>
                    </li>
                </ul>
            </div>
        </div>
            <!--End-Action boxes--><br><hr/><br>
            <!-- Tabs Open -->
            <center>
            <div style="overflow-x:auto;">
                <div class="widget-box" style="width: 80%;">
                    <div class="widget-title">
                        <ul class="nav nav-tabs"><span class="icon"><i class="icon-legal"></i></span>
                            <li class="active geo"><a data-toggle="tab" href="#tab1">To Do ლისტი</a></li>
                            <li class="geo"><a data-toggle="tab" href="#tab2">შესრულებული</a></li>
                        </ul>
                    </div>
                    <div class="widget-content tab-content">
                        <div id="tab1" class="tab-pane active">
                            <ul class="recent-posts">
                            <?php
                                
                                $qr2 = mysqli_query($conn, "SELECT * from todo WHERE done=0 ORDER BY mydate,mytime DESC");

                                // Insert new task
                                if(isset($_GET['msg'])){
                                    $user = $_SESSION["sess_user"];
                                    date_default_timezone_set('Etc/GMT-4');
                                    $date = date("Y/m/d");
                                    $time = date("h:i A");
                                    $msg = $_GET['msg'];

                                    $ins = "INSERT INTO todo(user,msg,mydate,mytime,done) VALUES('".$user."','".$msg."','".$date."','".$time."','0')";
                                    mysqli_query($conn,$ins);
                                

                                    unset($_GET['msg']);
                                    
                                    echo '<meta http-equiv="refresh" content="0; url=index.php" />';
                                }

                                // When task is done
                                if(isset($_GET['check'])){

                                    $id = $_GET['check'];

                                    $upd  = "UPDATE todo set done = '1' WHERE ID='".$id."'";
                                    mysqli_query($conn,$upd);

                                    unset($_GET['check']);
                                    
                                    echo '<meta http-equiv="refresh" content="0; url=index.php" />';
                                }

                                // Undo task
                                if(isset($_GET['uncheck'])){

                                    $id = $_GET['uncheck'];

                                    $upd  = "UPDATE todo set done = '0' WHERE ID='".$id."'";
                                    mysqli_query($conn,$upd);

                                    unset($_GET['uncheck']);
                                    
                                    echo '<meta http-equiv="refresh" content="0; url=index.php" />';
                                }

                                // Delete task
                                if(isset($_GET['del'])){

                                    $id = $_GET['del'];

                                    $upd  = "DELETE from todo WHERE ID='".$id."'";
                                    mysqli_query($conn,$upd);

                                    unset($_GET['del']);
                                    
                                    echo '<meta http-equiv="refresh" content="0; url=index.php" />';
                                }


                                    
                                while ($row = mysqli_fetch_assoc($qr2)) {

                                ?>
                                <li>
                                    <div class="article-post"> <span class="user-info geo"> <?php echo "ავტორი: <b style='font-size:13px;color:#f39c12;'>".$row['user']." </b>/ თარიღი: ".$row['mydate']." / დრო: ".$row['mytime']; ?></span>
                                        <div class="pull-right"> 
                                            <a class="tip" href="?check=<?php echo $row['ID'];?>" title="შესრულებული"><i class="icon-check"></i></a> <a class="tip" href="?del=<?php echo $row['ID'];?>" title="წაშლა"><i class="icon-remove-circle"></i></a> 
                                        </div>
                                        <p class="geo" style="font-size: 15px;color: #8e44ad;"><?php echo $row['msg'];?></p>
                                    </div>
                                </li>
                            <?php }?>
                            </ul>
                            <form action="" method="get">
                            <div class="chat-message well">
                                <span class="input-box" style="text-align: center;width:100%">
                                    <input type="text" class="geo" name="msg" placeholder="შეიყვანეთ დავალება..." id="msg-box" style="width:85%;float:center;">
                                    <input type="submit" name="" class="geo btn btn-success" value="დამატება" style="float:center;"></a>
                                </span>
                            </div>
                            </form>
                        </div>
                        <div id="tab2" class="tab-pane">
                            <ul class="recent-posts">
                            <?php
                                
                                $qr2 = mysqli_query($conn, "SELECT * from todo WHERE done=1");
                                    
                                    while ($row = mysqli_fetch_assoc($qr2)) {
                                    
                            ?>
                                <li>
                                    <div class="article-post"> <span class="user-info geo"> <?php echo "ავტორი: <b style='font-size:13px;color:#34495e;'>".$row['user']." </b>/ თარიღი: ".$row['mydate']." / დრო: ".$row['mytime']; ?></span>
                                        <div class="pull-right"> 
                                            <a class="tip" href="?uncheck=<?php echo $row['ID'];?>" title="შეუსრულებელი"><i class="icon-check-empty"></i></a> <a class="tip" href="?del=<?php echo $row['ID'];?>" title="წაშლა"><i class="icon-remove-circle"></i></a> 
                                        </div>
                                        <p class="geo" style="font-size: 14px;color: #95a5a6;"><?php echo $row['msg'];?></p>
                                    </div>
                                </li>
                            <?php }?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            </center>
            <!-- End of Tabs --><hr/>
            <!--Chart-box-->
            <center>
            <div class="row-fluid" style="width: 80%;">
                <div class="widget-box">
                    <div class="widget-title bg_lg"><span class="icon"><i class="icon-signal"></i></span>
                        <h5>Site Analytics</h5>
                    </div>
                    <div class="widget-content">
                        <div class="row-fluid">
                            <div class="span9">
                                <div class="chart"></div>
                            </div>
                            <div class="span3">
                                 <ul class="site-stats">
                                    <li class="bg_lh"><i class="icon-user"></i> <strong>2540</strong> <small>Total Users</small></li>
                                    <li class="bg_lh"><i class="icon-plus"></i> <strong>120</strong> <small>New Users </small></li>
                                    <li class="bg_lh"><i class="icon-shopping-cart"></i> <strong>656</strong> <small>Total Shop</small></li>
                                    <li class="bg_lh"><i class="icon-tag"></i> <strong>9540</strong> <small>Total Orders</small></li>
                                    <li class="bg_lh"><i class="icon-repeat"></i> <strong>10</strong> <small>Pending Orders</small></li>
                                    <li class="bg_lh"><i class="icon-globe"></i> <strong>8540</strong> <small>Online Orders</small></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </center>
            <!--End-Chart-box-->
            <hr/>
            
    </div>
    <!--end-main-container-part-->
    <!--Footer-part-->
    <div class="row-fluid">
        <div id="footer" class="span12"> 2017 &copy; სტუდენტური ბიზნეს პროექტისთვის. ავტორი: <a href="#">Giorgi Kharshiladze</a> </div>
    </div>
    <!--end-Footer-part-->
    <script src="js/excanvas.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.ui.custom.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.flot.min.js"></script>
    <script src="js/jquery.flot.resize.min.js"></script>
    <script src="js/jquery.peity.min.js"></script>
    <script src="js/fullcalendar.min.js"></script>
    <script src="js/matrix.js"></script>
    <script src="js/matrix.dashboard.js"></script>
    <!-- <script src="js/jquery.gritter.min.js"></script> -->
    <script src="js/matrix.interface.js"></script>
    <script src="js/matrix.chat.js"></script>
    <script src="js/jquery.validate.js"></script>
    <script src="js/matrix.form_validation.js"></script>
    <script src="js/jquery.wizard.js"></script>
    <script src="js/jquery.uniform.js"></script>
    <script src="js/select2.min.js"></script>
    <script src="js/matrix.popover.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/matrix.tables.js"></script>
    <script type="text/javascript">
    // This function is called from the pop-up menus to transfer to
    // a different page. Ignore if the value returned is a null string:
    function goPage(newURL) {

        // if url is empty, skip the menu dividers and reset the menu selection to default
        if (newURL != "") {

            // if url is "-", it is this page -- reset the menu:
            if (newURL == "-") {
                resetMenu();
            }
            // else, send page to designated URL            
            else {
                document.location.href = newURL;
            }
        }
    }

    // resets the menu selection upon entry to this page:
    function resetMenu() {
        document.gomenu.selector.selectedIndex = 2;
    }
    </script>
</body>

</html>
<?php
}
?>