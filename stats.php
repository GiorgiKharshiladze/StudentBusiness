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
    <!--sidebar-menu-->
    <div id="sidebar"> <a href="#" class="visible-phone"><i class="icon icon-th"></i> აპლიკაცია</a>
        <ul>
            <li class="geo"><a href="index.php"><i class="icon icon-home"></i> <span>მთავარი</span></a> </li>
            <li class="geo"> <a href="portfolio.php"><i class="icon icon-signal "></i> <span>პორტფოლიო</span> <span class="label label-success"><?php echo $portfolionum?></span></a> </li>
            <li class="geo"> <a href="addperson.php"><i class="icon icon-plus"></i> <span>მონაცემების დამატება</span></a></li>
            <li class="geo"><a href="searchuser.php"><i class="icon icon-search"></i> <span>აპლიკაციის მოძებნა</span></a></li>
            <li class="active geo"><a href="stats.php"><i class="icon icon-signal"></i> <span>სტატისტიკა</span></a></li>
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
            <li class="content geo"> <span>სრული ამოღებული თანხა:</span>
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
    <!-- Content -->
    <div id="content">
        <!--breadcrumbs-->
        <div id="content-header">
            <div id="breadcrumb" class="geo"> <a href="index.php" title="მთავარზე გადასვლა" class="tip-bottom"><i class="icon-home"></i> მთავარი</a><a href="#" class="current"><i class="icon-signal"></i> სტატისტიკა</a></div>
        </div>
        <!--End-breadcrumbs-->

        <br />
        <div class="widget-box" style="max-width:95%;height:auto;margin:auto;">
          <div class="widget-title"> <span class="icon"><i class="icon-signal"></i></span>
            <h5 class="geo" style="font-size: 20px;">სტატისტიკა</h5>
          </div>
            
            <center>
            
            <!-- Mini Stats -->
            
            <div style="width: 50%;">

                <div style="overflow-x:auto;">
                
                <?php

                $query = mysqli_query($conn, "SELECT * FROM portfolio");
                $numrows = mysqli_num_rows($query);

                ?>
                
                
                <table class="table table-bordered data-table geo">
                  <thead>
                    <hr>
                    <h4 class="geo" style="text-align: center;">ჯამური მონაცემები</h4>
                    <tr> 
                        <th style="font-size: 14px;">სრული დაფარული (₾)</th>
                        <th style="font-size: 14px;">სრული დარჩენილი (₾) </th>
                        <th style="font-size: 14px;">პორტფოლიოს სრული მონაცემები</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    if($numrows != 0){

                        while ($row = mysqli_fetch_assoc($query)) {
                            
                            require('formulas.php');


                        }
                    }
                    ?>
                    
                    <tr>
                        
                        <td style="text-align:center;vertical-align:middle;"><?php echo $paidtome;?></td>
                        <td style="text-align:center;vertical-align:middle;"><?php echo $totaltopay-$paidtome;?></td>
                        <td style="text-align:center;vertical-align:middle;">
                            <div class="<?php echo $progclass;?>" style="width: 90%;margin:auto;">
                                <div class="bar" style="width: <?php echo $prog.'%';?>;"><?php echo $prog.'%';?></div>
                            </div>
                        </td>
                    </tr>
                  </tbody>
                </table>
                </div>

            </div>


            <div style="width: 90%;">
            
            <!-- TOP 5 PAYABLE -->

            <?php

            $query1 = mysqli_query($conn, "SELECT * FROM portfolio ORDER BY paid DESC LIMIT 5");
            $numrows1 = mysqli_num_rows($query1);

            ?>
            
            <div style="overflow-x:auto;">
            <table class="table table-bordered data-table geo">
              <thead>
                <hr>
                <h4 class="geo" style="text-align: center;">TOP 5 გადამხდელი</h4>
                <tr >
                    <th style="font-size: 14px;">#</th>
                    <th style="font-size: 14px;">სახელი</th>
                    <th style="font-size: 14px;">გვარი</th>
                    <th style="font-size: 14px;">პირადი #</th>
                    <th style="font-size: 14px;">მონაცემთა ანალიზი</th>
                    <th style="font-size: 14px;">დაფარული (₾)</th>
                </tr>
              </thead>
              <tbody>
              <?php
                if($numrows1 != 0){

                    $counter = 1;

                    while ($row = mysqli_fetch_assoc($query1)) {
                        
                        require('formulas.php');

                        $myuserid = $row['ID'];
                ?>
                
                <tr>
                    <td style="text-align:center;vertical-align:middle;"><a href="portfolio.php?userid=<?php echo $myuserid;?>"><?php echo $counter;?></a></td>
                    <td style="text-align:center;vertical-align:middle;"><a href="portfolio.php?userid=<?php echo $myuserid;?>"><?php echo $row['name'];?></a></td>
                    <td style="text-align:center;vertical-align:middle;"><a href="portfolio.php?userid=<?php echo $myuserid;?>"><?php echo $row['surname'];?></a></td>
                    <td style="text-align:center;vertical-align:middle;"><a href="portfolio.php?userid=<?php echo $myuserid;?>"><?php echo $row['personalid'];?></a></td>
                    <td style="text-align:center;" valign="middle">
                    <a href="?userid=<?php echo $myuserid;?>">
                    <div class="<?php echo $progclass;?>" style="width: 90%;margin:auto;">
                        <div class="bar" style="width: <?php echo $progress.'%';?>;"><?php echo $progress.'%';?></div>
                    </div>
                    </a>
                    </td>
                    <td style="text-align:center;vertical-align:middle;"><a href="portfolio.php?userid=<?php echo $myuserid;?>"><?php echo $row['paid'];?></a></td>
                </tr>

                <?php
                        $counter++;
                        }
                }

              ?>
              </tbody>
            </table>
            </div>

            <!-- TOP 5 APPLICATION -->

            <?php

            $query2 = mysqli_query($conn, "SELECT * FROM portfolio ORDER BY (paid/finaltopay) DESC LIMIT 5");
            $numrows2 = mysqli_num_rows($query2);

            ?>
            
            <div style="overflow-x:auto;">
            <table class="table table-bordered data-table geo">
              <thead>
                <hr>
                <h4 class="geo" style="text-align: center;">TOP 5 აპლიკაცია</h4>
                <tr >
                    <th style="font-size: 14px;">#</th>
                    <th style="font-size: 14px;">სახელი</th>
                    <th style="font-size: 14px;">გვარი</th>
                    <th style="font-size: 14px;">პირადი #</th>
                    <th style="font-size: 14px;">მონაცემთა ანალიზი</th>
                    <th style="font-size: 14px;">დაფარული (%)</th>
                </tr>
              </thead>
              <tbody>
              <?php
                if($numrows2 != 0){

                    $counter = 1;

                    while ($row = mysqli_fetch_assoc($query2)) {
                        
                        require('formulas.php');

                        $myuserid = $row['ID'];
                ?>
                
                <tr>
                    <td style="text-align:center;vertical-align:middle;"><a href="portfolio.php?userid=<?php echo $myuserid;?>"><?php echo $counter;?></a></td>
                    <td style="text-align:center;vertical-align:middle;"><a href="portfolio.php?userid=<?php echo $myuserid;?>"><?php echo $row['name'];?></a></td>
                    <td style="text-align:center;vertical-align:middle;"><a href="portfolio.php?userid=<?php echo $myuserid;?>"><?php echo $row['surname'];?></a></td>
                    <td style="text-align:center;vertical-align:middle;"><a href="portfolio.php?userid=<?php echo $myuserid;?>"><?php echo $row['personalid'];?></a></td>
                    <td style="text-align:center;" valign="middle">
                    <a href="?userid=<?php echo $myuserid;?>">
                    <div class="<?php echo $progclass;?>" style="width: 90%;margin:auto;">
                        <div class="bar" style="width: <?php echo $progress.'%';?>;"><?php echo $progress.'%';?></div>
                    </div>
                    </a>
                    </td>
                    <td style="text-align:center;vertical-align:middle;"><a href="portfolio.php?userid=<?php echo $myuserid;?>"><?php echo $progress;?></a></td>
                </tr>

                <?php
                        $counter++;
                        }
                }

              ?>
              </tbody>
            </table>
            </div>

            <!-- TOP 5 ToPay -->

            <?php

            $query3 = mysqli_query($conn, "SELECT * FROM portfolio ORDER BY finaltopay DESC LIMIT 5");
            $numrows3 = mysqli_num_rows($query3);

            ?>
            
            <div style="overflow-x:auto;">
            <table class="table table-bordered data-table geo">
              <thead>
                <hr>
                <h4 class="geo" style="text-align: center;">TOP 5 დავალიანება</h4>
                <tr >
                    <th style="font-size: 14px;">#</th>
                    <th style="font-size: 14px;">სახელი</th>
                    <th style="font-size: 14px;">გვარი</th>
                    <th style="font-size: 14px;">პირადი #</th>
                    <th style="font-size: 14px;">მონაცემთა ანალიზი</th>
                    <th style="font-size: 14px;">დავალიანება (₾)</th>
                </tr>
              </thead>
              <tbody>
              <?php
                if($numrows3 != 0){

                    $counter = 1;

                    while ($row = mysqli_fetch_assoc($query3)) {
                        
                        require('formulas.php');

                        $myuserid = $row['ID'];
                ?>
                
                <tr>
                    <td style="text-align:center;vertical-align:middle;"><a href="portfolio.php?userid=<?php echo $myuserid;?>"><?php echo $counter;?></a></td>
                    <td style="text-align:center;vertical-align:middle;"><a href="portfolio.php?userid=<?php echo $myuserid;?>"><?php echo $row['name'];?></a></td>
                    <td style="text-align:center;vertical-align:middle;"><a href="portfolio.php?userid=<?php echo $myuserid;?>"><?php echo $row['surname'];?></a></td>
                    <td style="text-align:center;vertical-align:middle;"><a href="portfolio.php?userid=<?php echo $myuserid;?>"><?php echo $row['personalid'];?></a></td>
                    <td style="text-align:center;" valign="middle">
                    <a href="?userid=<?php echo $myuserid;?>">
                    <div class="<?php echo $progclass;?>" style="width: 90%;margin:auto;">
                        <div class="bar" style="width: <?php echo $progress.'%';?>;"><?php echo $progress.'%';?></div>
                    </div>
                    </a>
                    </td>
                    <td style="text-align:center;vertical-align:middle;"><a href="portfolio.php?userid=<?php echo $myuserid;?>"><?php echo $row['finaltopay'];?></a></td>
                </tr>

                <?php
                        $counter++;
                        }
                }

              ?>
              </tbody>
            </table>
            </div>


            </div>
            </center>

        </div>
            
            
        </div>
    </div>
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