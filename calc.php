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
            <li class="geo"><a href="index.php"><i class="icon icon-home"></i> <span>მთავარი</span></a> </li>
            <li class="geo"> <a href="portfolio.php"><i class="icon icon-signal "></i> <span>პორტფოლიო</span> <span class="label label-success"><?php echo $portfolionum?></span></a> </li>
            <li class="geo"> <a href="addperson.php"><i class="icon icon-plus"></i> <span>მონაცემების დამატება</span></a></li>
            <li class="geo"><a href="searchuser.php"><i class="icon icon-search"></i> <span>აპლიკაციის მოძებნა</span></a></li>
            <li class="geo"><a href="stats.php"><i class="icon icon-signal"></i> <span>სტატისტიკა</span></a></li>
            <li class="geo active"><a href="calc.php"><i class="icon icon-list-alt"></i> <span>მინი კალკულატორი</span></a></li>
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
    <!--sidebar-menu-->
    <!--main-container-part-->
    <div id="content">
        <!--breadcrumbs-->
        <div id="content-header">
            <div id="breadcrumb" class="geo"> <a href="index.php" title="მთავარზე გადასვლა" class="tip-bottom"><i class="icon-home"></i> მთავარი</a><a href="calc.php" title="მინი კალკულატორი" class="current"><i class="icon-list-alt"></i> მინი კალკულატორი</a></div>
        </div>
        <!--End-breadcrumbs-->
        
            <br><hr/><br>


                    <div class="widget-box" style="max-width: 80%; height: auto; margin: auto;">
                        <div class="widget-title bg_ly" ><span class="icon"><i class="icon-list-alt"></i></span>
                            <h5 class="geo">მინი კალკულატორი</h5>
                        </div>
                        <form action="addperson.php?submit" method="post" class="form-horizontal" >
                            <div class="control-group">
                              <div class="controls" style="margin: auto; width: 70%">
                                <input type="text" onkeyup="myFunction()" class="geo" placeholder="საბოლოო დავალიანება" name="finaltopay" id="finaltopay" style="width: 100%;margin:auto;" 
                                value="<?php if(isset($_GET['x'])) echo $_GET['x'];?>">
                              </div>
                              <div class="controls" style="margin: auto; width: 70%">
                                <input type="text" onkeyup="myFunction()" class="geo" placeholder="დავალიანების შემცირება X-მდე" name="final" id="final" style="width: 100%;margin:auto;">
                              </div>
                            </div>
                            <div class="control-group">
                              <div class="controls" style="margin: auto; width: 70%">
                                <input type="text" class="geo" placeholder="ფასდაკლება X-პროცენტით" name="discount" id="discount" style="width: 100%;margin:auto;" disabled>
                              </div>
                            </div>
                        </form>
                    </div>


                    <script>
                    function myFunction() {
                        var x = parseFloat(document.getElementById("finaltopay").value);
                        var y = parseFloat(document.getElementById("final").value);

                        if(document.getElementById("finaltopay").value == "") { x = 0; }
                        if(document.getElementById("final").value == "") { y = 0; }

                        var ans = (x - y)/x  * 100 +"%";

                        if(document.getElementById("finaltopay").value == "" || document.getElementById("final").value == "") 
                        {
                            ans = "მიუთითეთ ორივე მონაცემი!";
                        }

                        document.getElementById("discount").value = ans;
                    }
                    </script>

           
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