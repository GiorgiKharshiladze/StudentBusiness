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
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="icon" type="image/x-icon" href="img/icons/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="css/fullcalendar.css" />
    <link rel="stylesheet" href="css/uniform.css" />
    <link rel="stylesheet" href="css/select2.css" />
    <link rel="stylesheet" href="css/matrix-style.css" />
    <link rel="stylesheet" href="css/matrix-media.css" />
    <link rel="stylesheet" href="css/bootstrap-wysihtml5.css" />
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
    input[type=radio   ]:not(old){
      width     : 0.5em;
      margin    : 0;
      padding   : 0;
      font-size : 0em;
      opacity   : 0;
    }
    </style>
    <!-- Masks go here -->
    <script type='text/javascript' src='js/jquery-1.11.0.js'></script>
    <script type='text/javascript'>
        $('document').ready(function() {
        $("#perID").mask("99999999999");
        });
        $('document').ready(function() {
        $("#percent").mask("99.99%");
        });
        $('document').ready(function() {
        $("#pick-date").mask("9999/99/99");
        });
        $('document').ready(function() {
        $("#pick-date3").mask("9999/99/99");
        });
        $('document').ready(function() {
        $("#pick-date1").mask("9999/99/99");
        });
        $('document').ready(function() {
        $("#pick-date2").mask("9999/99/99");
        });
        $('document').ready(function() {
        $("#geophone").mask("(+999) 999 99-99-99");
        });
        $('document').ready(function() {
        $("#geophone2").mask("(+999) 999 99-99-99");
        });
        $('document').ready(function() {
        $("#risk").mask("9");
        });
    </script>
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
    <div id="sidebar"> <a href="#" class="visible-phone geo"><i class="icon icon-plus"></i> მონაცემების დამატება</a>
        <ul>
            <li class="geo"><a href="index.php"><i class="icon icon-home"></i> <span>მთავარი</span></a> </li>
            <li class="geo"> <a href="portfolio.php"><i class="icon icon-signal "></i> <span>პორტფოლიო</span> <span class="label label-success"><?php echo $portfolionum?></span></a> </li>
            <li class="geo active"> <a href="addperson.php"><i class="icon icon-plus"></i> <span>მონაცემების დამატება</span></a></li>
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
            <div id="breadcrumb" class="geo"> <a href="index.php" title="მთავარზე გადასვლა" class="tip-bottom"><i class="icon-home"></i> მთავარი</a><a href="addperson.php" class="current"><i class="icon-plus-sign"></i> მონაცემების დამატება</a></div>
        </div>
        <!--End-breadcrumbs-->
        <?php

        if(isset($_GET['submit'])){
            // WHEN YOU CLICK ON SUBMIT
        ?>

        <div class="widget-box center geo" style="margin:auto;max-width: 70%;height: auto;">
            <div class="widget-title"> <a href="addperson.php"><span class="icon"> <i class="icon-backward"></i> </span></a>
              <h5 style="font-size: 20px;">მონაცემების გაგზავნა</h5>
            </div>
                <div class="widget-content nopadding">

	                <div class="control-group">
	                  <div class="controls" style="margin: auto; width: 70%">

                <?php 

                	if(strlen($_POST['personalid'])==11 && $_POST['total']!=""){

                	// Define Variables
                	$creditnum = $_POST['creditnum'];
                	$personalid =  $_POST['personalid'];
                	$bank = $_POST['bank'];
                	$risk = $_POST['risk'];
                	$deadline1 = $_POST['deadline1'];
                	$name = $_POST['name'];
                	$surname = $_POST['surname'];
                	$phone = $_POST['phone'];
                	$startline = $_POST['startline'];
                	$deadline2 = $_POST['deadline2'];
                	$credit = $_POST['credit'];
                	$percent = $_POST['percent'];
                	$total = $_POST['total'];
                	$job = $_POST['job'];
                	$position = $_POST['position'];
                	$regaddress = $_POST['regaddress'];
                	$curraddress = $_POST['curraddress'];
                	$p2fullname = $_POST['p2fullname'];
                	$p2phone = $_POST['p2phone'];
                	$birthday = $_POST['birthday'];
                	$gender = $_POST['gender'];
                	$comments = $_POST['comments'];

                	$myalgorithm = $total * $risk;

                    if($comments=="") { $comments="კომენტარი არ არის..."; }



			        $sql = "INSERT INTO portfolio (creditnum, personalid, bank, risk, deadline1, name, surname, phone, startline, deadline2, credit, percent, total, job, position, regaddress, curraddress, p2fullname, p2phone, birthday, gender, comments, myscore, discount, algorithm, paid, document, finaltopay)
						VALUES ('".$creditnum."', '".$personalid."', '".$bank."', '".$risk."', '".$deadline1."', '".$name."', '".$surname."', '".$phone."', '".$startline."', '".$deadline2."', '".$credit."', '".$percent."', '".$total."', '".$job."', '".$position."', '".$regaddress."', '".$curraddress."', '".$p2fullname."', '".$p2phone."', '".$birthday."', '".$gender."', '".$comments."', '0','0','".$myalgorithm."','0','http://','".$total."')";

					
					if (mysqli_query($conn, $sql)) {
						
					 	$message = "<br><div class='alert alert-success alert-block'> <a class='close' data-dismiss='alert' href='#'>×</a>
              			<h4 class='alert-heading geo'>მონაცემები წარმატებით დაემატა!</h4></div>";
					} 

					else {
						
	                    $message = "<br><div class='alert alert-error alert-block'> <a class='close' data-dismiss='alert' href='#'>×</a>
              			<h4 class='alert-heading geo'>შეცდომა ბაზაში დამატებისას</h4></div>";

					}

                    echo $message;

					$conn->close();


                	}

                	else {

                		$message = "<br><div class='alert alert-error alert-block'> <a class='close' data-dismiss='alert' href='#'>×</a>
              			<h4 class='alert-heading geo'>შეცდომა ბაზაში დამატებისას</h4></div>";

              			echo $message;

                	}


                ?>
					
                  		</div>
                	</div>
                </div>
            </div>

        <?php

        }

        else {

        ?>
        <br />
        <div style="overflow-x:auto;">
          <div class="widget-box center geo" style="margin:auto;max-width: 80%;height: auto;">
            <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
              <h5 style="font-size: 16px;">შეიყვანეთ მონაცემები</h5>
            </div>
            <div class="widget-content nopadding">
              <form action="addperson.php?submit" method="post" class="form-horizontal" >
                <div class="control-group">
                  <div class="controls" style="margin: auto; width: 70%">
                    <input type="text" class="geo" placeholder="კრედიტის #" name="creditnum" style="width: 100%;margin:auto;">
                  </div>
                </div>
                <div class="control-group">
                  <div class="controls" style="margin: auto; width: 70%">
                    <input type="text" id="perID" class="mask text geo" placeholder="პირადი ნომერი" name="personalid" style="width: 100%;margin:auto;">
                  </div>
                </div>
                <div class="control-group">
                  <div class="controls" style="margin: auto; width: 70%">
                    <input type="text" class="mask text geo" placeholder="ანგარიშის ნომერი" name="bank" style="width: 100%;margin:auto;">
                  </div>
                </div>
            <div style="overflow-x:auto;">
                <div class="control-group" data-toggle="buttons" class="btn-group">
                    <div style="margin: auto;">
                        <div class="controls" style="width: 70%; margin: auto;">
                        <span class="help-block geo">რისკ სტატუსი (მცირდება 1-დან 4-მდე)</span>
                            <div class="btn-toolbar">
                                <div data-toggle="buttons-radio" class="btn-group">
                                    <label class="btn geo active"><input type="radio" name="risk" value="1" style="visibility: hidden;" checked>1</label>
                                    <label class="btn geo"><input type="radio" name="risk" value="2" style="visibility: hidden;">2</label>
                                    <label class="btn geo"><input type="radio" name="risk" value="3" style="visibility: hidden;">3</label>
                                    <label class="btn geo"><input type="radio" name="risk" value="4" style="visibility: hidden;">4</label>
                                </div>
                            </div>
                        </div>
                	</div>
                </div>
            </div>
                <div class="control-group">
                    <div class="controls" style="margin: auto; width: 70%">
                        <span class="help-block geo">ფორმატი yyyy-mm-dd</span>
                        <input type="text" id="pick-date" placeholder="პირველადი დასრულების თარიღი" name="deadline1" class="mask text datepicker geo" style="width: 100%;margin:auto;">
                    </div>
                </div>
                <div class="control-group">
                  <div class="controls" style="margin: auto; width: 70%">
                    <input type="text" class="geo" placeholder="სახელი" name="name" style="width: 100%;margin:auto;">
                  </div>
                </div>
                <div class="control-group">
                  <div class="controls" style="margin: auto; width: 70%">
                    <input type="text" class="geo" placeholder="გვარი" name="surname" style="width: 100%;margin:auto;">
                  </div>
                </div>
                <div class="control-group">
                  <div class="controls" style="margin: auto; width: 70%">
                    <span class="help-block geo">ფორმატი (995) 5XX XX-XX-XX)</span>
                    <input type="text" id="geophone" class="mask text geo" name="phone" placeholder="მობილურის ნომერი" style="width: 100%;margin:auto;">
                  </div>
                </div>
                <div class="control-group">
                    <div class="controls" style="margin: auto; width: 70%">
                        <span class="help-block geo">ფორმატი yyyy-mm-dd</span>
                        <input type="text" id="pick-date1" placeholder="დაწყების თარიღი" name="startline" class="mask text datepicker geo" style="width: 100%;margin:auto;">
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls" style="margin: auto; width: 70%">
                        <span class="help-block geo">ფორმატი yyyy-mm-dd</span>
                        <input type="text" id="pick-date2" placeholder="დასრულების თარიღი" name="deadline2" class="mask text datepicker geo" style="width: 100%;margin:auto;">
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls" style="margin: auto; width: 70%">
                        <div class="input-append" style="width: 100%;margin:auto;">
                          <input type="text" class="geo" placeholder="ძირი თანხა: 0.00" name="credit" style="width: 100%; margin:auto;">
                          <span class="add-on">₾</span>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                  <div class="controls" style="margin: auto; width: 70%">
                    <div class="input-append" style="width: 100%;margin:auto;">
                    	<input type="text" class="geo" placeholder="პროცენტი" name="percent" style="width: 100%;margin:auto;">
                    	<span class="add-on">%</span>
                    </div>
                  </div>
                </div>
                <div class="control-group">
                    <div class="controls" style="margin: auto; width: 70%">
                        <div class="input-append" style="width: 100%;margin:auto;">
                          <input type="text" class="geo" placeholder="ჯამური დავალიანება: 0.00" name="total" style="width: 100%; margin:auto;">
                          <span class="add-on">₾</span>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                  <div class="controls" style="margin: auto; width: 70%">
                    <input type="text" class="geo" placeholder="სამსახურის დასახელება" name="job" style="width: 100%;margin:auto;">
                  </div>
                </div>
                <div class="control-group">
                  <div class="controls" style="margin: auto; width: 70%">
                    <input type="text" class="geo" placeholder="დაკავებული პოზიცია" name="position" style="width: 100%;margin:auto;">
                  </div>
                </div>
                <div class="control-group">
                  <div class="controls" style="margin: auto; width: 70%">
                    <input type="text" class="geo" placeholder="რეგისტრაციის მისამართი" name="regaddress" style="width: 100%;margin:auto;">
                  </div>
                </div>
                <div class="control-group">
                  <div class="controls" style="margin: auto; width: 70%">
                    <input type="text" class="geo" placeholder="ფაქტობრივი მისამართი" name="curraddress" style="width: 100%;margin:auto;">
                  </div>
                </div>
                <div class="control-group">
                  <div class="controls" style="margin: auto; width: 70%">
                    <input type="text" class="geo" placeholder="საკონტაქტო პირი" name="p2fullname" style="width: 100%;margin:auto;">
                  </div>
                </div>
                <div class="control-group">
                  <div class="controls" style="margin: auto; width: 70%">
                    <input type="text" id="geophone2" class="geo" placeholder="საკონტაქტო პირის ნომერი" name="p2phone" style="width: 100%;margin:auto;">
                  </div>
                </div>
                <div class="control-group">
                    <div class="controls" style="margin: auto; width: 70%">
                        <span class="help-block geo">ფორმატი yyyy-mm-dd</span>
                        <input type="text" id="pick-date3" placeholder="დაბადების თარიღი" name="birthday" class="mask text datepicker geo" style="width: 100%;margin:auto;">
                    </div>
                </div>
            <div style="overflow-x:auto;">
                <div class="control-group" data-toggle="buttons" class="btn-group">
                    <div style="margin: auto;">
                        <div class="controls" style="width: 70%; margin: auto;">
                        <span class="help-block geo">სქესი</span>
                            <div class="btn-toolbar">
                                <div data-toggle="buttons-radio" class="btn-group">
                                    <label class="btn geo active"><input type="radio" name="gender" value="მამრობითი" style="visibility: hidden;" checked><i class="fa fa-mars custom"></i> მამრ.</label>
                                    <label class="btn geo"><input type="radio" name="gender" value="მდედრობითი" style="visibility: hidden;"><i class="fa fa-venus custom"></i> მდედრ.</label>
                                </div>
                            </div>
                        </div>
                	</div>
                </div>
            </div>
                <div class="control-group">
                  <div class="controls" style="margin: auto; width: 70%">
                    <textarea class="geo" placeholder="კომენტარი" name="comments" style="width: 100%;margin:auto;"></textarea>
                  </div>
                </div>   
                <div class="form-actions">
                    <div style="text-align: center;">
                      <button type="submit" class="btn btn-success geo">ბაზაში დამატება</button>
                    </div>
                </div>
              </form>
            </div>
          </div>
          </div>
        <?php
        } // If submit is not set
        ?>
            
            
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
    <script src="js/matrix.interface.js"></script>
    <script src="js/matrix.chat.js"></script>
    <script src="js/masked.js"></script> 
    <script src="js/jquery.uniform.js"></script> 
    <script src="js/select2.min.js"></script> 
    <script src="js/matrix.js"></script> 
    <script src="js/matrix.form_common.js"></script> 
    <script src="js/wysihtml5-0.3.0.js"></script> 
    <script src="js/jquery.peity.min.js"></script> 
    <script src="js/bootstrap-wysihtml5.js"></script> 
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