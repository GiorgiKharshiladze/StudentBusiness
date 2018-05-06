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
    <div id="sidebar"> <a href="#" class="visible-phone"><i class="icon icon-th"></i> პორტფოლიო</a>
        <ul>
            <li class="geo"><a href="index.php"><i class="icon icon-home"></i> <span>მთავარი</span></a> </li>
            <li class="geo active"> <a href="portfolio.php"><i class="icon icon-signal "></i> <span>პორტფოლიო</span> <span class="label label-success"><?php echo $portfolionum?></span></a> </li>
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
            <div id="breadcrumb" class="geo"> <a href="index.php" title="მთავარზე გადასვლა" class="tip-bottom"><i class="icon-home"></i> მთავარი</a><a href="portfolio.php" class="current"><i class="icon-th"></i> პორტფოლიო</a></div>
        </div>
        <!--End-breadcrumbs-->
        <?php
        require("connect.php");
        $query = mysqli_query($conn, "SELECT * from portfolio ORDER BY algorithm DESC");
        $numrows = mysqli_num_rows($query);
        ?>
        <br />
        <div class="widget-box" style="max-width:95%;height:auto;margin:auto;">
          <div class="widget-title"> <a href="portfolio.php"><span class="icon"> <i class="icon-backward"></i> </span></a>
            <h5 class="geo" style="font-size: 20px;">მონაცემთა ბაზა</h5>
          </div>
          <div class="widget-content nopadding">
        <?php
        // When you click
        if(isset($_GET['userid']))
        {
            $query2 = mysqli_query($conn, "SELECT * from portfolio WHERE ID=".$_GET['userid']);
            $nums = mysqli_num_rows($query2);

            if($nums == 1){

                $row = mysqli_fetch_assoc($query2);


        ?>
        <!-- USER INFO HERE -->
          <div class="container-fluid"><hr>
            <div class="row-fluid">
              <div class="span12">
                <div class="widget-box">
                  <div class="widget-title"><span class="icon"> <i class="icon-th"></i> </span>
                    <h5 >აპლიკაცია</h5>
                  </div>
                  <div class="widget-content">
                    <div class="row-fluid">
                      <div class="span6">
                        <table>
                          <tbody>
                            <tr>
                                <td>
                                    <div class="alert alert-info geo" style="text-align: center;">
                                        <h3><strong>რანკი: <?php echo $row["algorithm"]; ?></strong></h3>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="alert alert-success" style="text-align: center;">
                                        <h4 class="geo" contenteditable="true" data-old_value="<?php echo $row["name"]; ?>" onBlur="saveInlineEdit(this,'name','<?php echo $row["ID"]; ?>')" onClick="highlightEdit(this);">
                                            <?php echo $row["name"]; ?>
                                        </h4>
                                        <h4 class="geo" contenteditable="true" data-old_value="<?php echo $row["surname"]; ?>" onBlur="saveInlineEdit(this,'surname','<?php echo $row["ID"]; ?>')" onClick="highlightEdit(this);">
                                            <?php echo $row["surname"]; ?>
                                        </h4>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                              <td><h5 class="geo">პირადი ნომერი: <b contenteditable="true" data-old_value="<?php echo $row["personalid"]; ?>" onBlur="saveInlineEdit(this,'personalid','<?php echo $row["ID"]; ?>')" onClick="highlightEdit(this);"><?php echo $row['personalid'];?></b></h5></td>
                            </tr>
                            <tr>
                                <td>
                                  <h5 class="geo">დაბადების თარიღი: 
                                    <b contenteditable="true" data-old_value="<?php echo $row["birthday"]; ?>" onBlur="saveInlineEdit(this,'birthday','<?php echo $row["ID"]; ?>')" onClick="highlightEdit(this);"><?php echo $row['birthday'];?>
                                    </b>
                                  </h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                  <h5 class="geo">სქესი: 
                                    <b contenteditable="true" data-old_value="<?php echo $row["gender"]; ?>" onBlur="saveInlineEdit(this,'gender','<?php echo $row["ID"]; ?>')" onClick="highlightEdit(this);"><?php echo $row['gender'];?>
                                    </b>
                                  </h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                  <h5 class="geo">მობილური: 
                                    <b contenteditable="true" data-old_value="<?php echo $row["phone"]; ?>" onBlur="saveInlineEdit(this,'phone','<?php echo $row["ID"]; ?>')" onClick="highlightEdit(this);"><?php echo $row['phone'];?>
                                    </b>
                                  </h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5 class="geo">ხელშეკრულების ლინკი: </h5>
                                    <label contenteditable="true" data-old_value="<?php echo $row["document"]; ?>" onBlur="saveInlineEdit(this,'document','<?php echo $row["ID"]; ?>')" onClick="highlightEdit(this);"><?php echo $row['document'];?>
                                    </label>
                                    <a href="<?php echo $row['document'];?>" target="_blank"><h1><i class="icon-file"></i></h1></a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                  <h5 class="geo">ანგარიშის ნომერი: 
                                    <b contenteditable="true" data-old_value="<?php echo $row["bank"]; ?>" onBlur="saveInlineEdit(this,'bank','<?php echo $row["ID"]; ?>')" onClick="highlightEdit(this);"><?php echo $row['bank'];?>
                                    </b>
                                  </h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                  <h5 class="geo">რეგისტრაციის მისამართი: 
                                    <b contenteditable="true" data-old_value="<?php echo $row["regaddress"]; ?>" onBlur="saveInlineEdit(this,'regaddress','<?php echo $row["ID"]; ?>')" onClick="highlightEdit(this);"><?php echo $row['regaddress'];?>
                                    </b>
                                  </h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                  <h5 class="geo">ფაქტობრივი მისამართი: 
                                    <b contenteditable="true" data-old_value="<?php echo $row["curraddress"]; ?>" onBlur="saveInlineEdit(this,'curraddress','<?php echo $row["ID"]; ?>')" onClick="highlightEdit(this);"><?php echo $row['curraddress'];?>
                                    </b>
                                  </h5>
                                </td>
                            </tr>
                          </tbody>
                        </table>
                        <hr />
                            <table class="table table-bordered table-invoice">
	                            <tbody>
	                            <tr>
	                              <td class="width30 geo"><h5>სამსახურის დასახელება</h5></td>
	                              <td class="width70 geo" style="text-align:center;"><strong><h5 contenteditable="true" data-old_value="<?php echo $row["job"]; ?>" onBlur="saveInlineEdit(this,'job','<?php echo $row["ID"]; ?>')" onClick="highlightEdit(this);"><?php echo $row['job'];?></h5> </strong></td>
	                            </tr>
	                            <tr>
	                              <td class="width30 geo"><h5>დაკავებული პოზიცია</h5></td>
	                              <td class="width70 geo" style="text-align:center;"><strong><h5 contenteditable="true" data-old_value="<?php echo $row["position"]; ?>" onBlur="saveInlineEdit(this,'position','<?php echo $row["ID"]; ?>')" onClick="highlightEdit(this);"><?php echo $row['position'];?></h5> </strong></td>
	                            </tr>
                            	</tbody>
                        	</table><br>
                            <table class="table table-bordered table-invoice" style="max-width: 200px;">
	                            <tbody>
	                            <tr>
	                              <td class="width30 geo"><h5>რისკ სტატუსი</h5></td>
	                              <td class="width70 geo" style="text-align:center;"><strong><h5 contenteditable="true" data-old_value="<?php echo $row["risk"]; ?>" onBlur="saveInlineEdit(this,'risk','<?php echo $row["ID"]; ?>')" onClick="highlightEdit(this);"><?php echo $row['risk'];?></h5> </strong></td>
	                            </tr>
	                            <tr>
	                              <td class="width30 geo"><h5>ჩვენი შეფასება</h5></td>
	                              <td class="width70 geo" style="text-align:center;"><strong><h5 contenteditable="true" data-old_value="<?php echo $row["myscore"]; ?>" onBlur="saveInlineEdit(this,'myscore','<?php echo $row["ID"]; ?>')" onClick="highlightEdit(this);"><?php echo $row['myscore'];?></h5> </strong></td>
	                            </tr>
                            	</tbody>
                        	</table>
                        	
                      </div>
                      <div class="span6" style="">
                        <table class="table table-bordered table-invoice"><?php require('formulas.php');?> 
	                      <thead><tr><td cols="2" class="geo"><h4>კრედიტის მონაცემები:</h4></td></tr></thead>
                          <tbody>
                            <tr>
                              <td class="width30 geo"><h5>კრედიტის #</h5></td>
                              <td class="width70 geo" style="text-align:center;"><strong><h5 contenteditable="true" data-old_value="<?php echo $row["creditnum"]; ?>" onBlur="saveInlineEdit(this,'creditnum','<?php echo $row["ID"]; ?>')" onClick="highlightEdit(this);"><?php echo $row['creditnum'];?></h5></strong></td>
                            </tr>
                            <tr>
                              <td class="width30 geo"><h5>კრედიტის ძირი (₾)</h5></td>
                              <td class="width70 geo" style="text-align:center;"><strong><h5 contenteditable="true" data-old_value="<?php echo $row["credit"]; ?>" onBlur="saveInlineEdit(this,'credit','<?php echo $row["ID"]; ?>')" onClick="highlightEdit(this);"><?php echo $row['credit'];?></h5></strong></td>
                            </tr>
                            <tr>
                              <td class="width30 geo"><h5>პროცენტი (%)</h5></td>
                              <td class="width70 geo" style="text-align:center;"><strong><h5 contenteditable="true" data-old_value="<?php echo $row["percent"]; ?>" onBlur="saveInlineEdit(this,'percent','<?php echo $row["ID"]; ?>')" onClick="highlightEdit(this);"><?php echo $row['percent'];?></h5></strong></td>
                            </tr>
                            <tr>
                              <td class="width30 geo"><h5>ჯამური დავალიანება (მოცემული)(₾)</h5></td>
                              <td class="width70 geo" style="text-align:center;"><strong><h5 contenteditable="true" data-old_value="<?php echo $row["total"]; ?>" onBlur="saveInlineEdit(this,'total','<?php echo $row["ID"]; ?>')" onClick="highlightEdit(this);"><?php echo $row['total'];?></h5></strong></td>
                            </tr>
                            <tr>
                              <td class="width30 geo"><h5>ფასდაკლება (%)</h5></td>
                              <td class="width70 geo" style="text-align:center;"><strong><h5 contenteditable="true" data-old_value="<?php echo $row["discount"]; ?>" onBlur="saveInlineEdit(this,'discount','<?php echo $row["ID"]; ?>')" onClick="highlightEdit(this);"><?php echo $row['discount'];?></h5></strong></td>
                            </tr>
                            <tr>
                              <td class="width30 geo"><h5>დაფარული თანხა (₾)</h5></td>
                              <td class="width70 geo" style="text-align:center;"><strong><h5 contenteditable="true" data-old_value="<?php echo $row["paid"]; ?>" onBlur="saveInlineEdit(this,'paid','<?php echo $row["ID"]; ?>')" onClick="highlightEdit(this);"><?php echo $row['paid'];?></h5> </strong></td>
                            </tr>
                            <tr style="opacity: 0.7;">
                              <td class="width30 geo" style="vertical-align: middle;"><h5>საბოლოო დავალიანება (₾)</h5></td>
                              <td class="width70 geo" style="text-align:center;"><strong>
                              <a target="_blank" title="კალკულატორით გამოთვლა" alt="კალკულატორით გამოთვლა" href="calc.php?x=<?php echo $row['finaltopay'];?>">
                              	<h5><?php echo $row['finaltopay'];?></h5><i class="icon icon-list-alt"></i>
                              </a></strong></td>
                            </tr>
                            <tr>
                                <td class="width70 geo" colspan="2">
                                    <div class="<?php echo $progclass;?>" style="width: 100%;margin:auto;">
                                        <div class="bar" style="width: <?php echo $progress.'%';?>;"><?php echo $progress.'%';?></div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                            </table>
                            <table class="table table-bordered table-invoice">
                            <br/>
	                            <thead><tr><td cols="2" class="geo"><h4>თარიღები:</h4></td></tr></thead>
	                            <tbody>
	                            <tr>
	                              <td class="width30 geo"><h5>დაწყების თარიღი</h5></td>
	                              <td class="width70 geo" style="text-align:center;"><strong><h5 contenteditable="true" data-old_value="<?php echo $row["startline"]; ?>" onBlur="saveInlineEdit(this,'startline','<?php echo $row["ID"]; ?>')" onClick="highlightEdit(this);"><?php echo $row['startline'];?></h5> </strong></td>
	                            </tr>
	                            <tr>
	                              <td class="width30 geo"><h5>პირველადი დასრულების თარიღი</h5></td>
	                              <td class="width70 geo" style="text-align:center;"><strong><h5 contenteditable="true" data-old_value="<?php echo $row["deadline1"]; ?>" onBlur="saveInlineEdit(this,'deadline1','<?php echo $row["ID"]; ?>')" onClick="highlightEdit(this);"><?php echo $row['deadline1'];?></h5> </strong></td>
	                            </tr>
	                            <tr>
	                              <td class="width30 geo"><h5>დასრულების თარიღი</h5></td>
	                              <td class="width70 geo" style="text-align:center;"><strong><h5 contenteditable="true" data-old_value="<?php echo $row["deadline2"]; ?>" onBlur="saveInlineEdit(this,'deadline2','<?php echo $row["ID"]; ?>')" onClick="highlightEdit(this);"><?php echo $row['deadline2'];?></h5> </strong></td>
	                            </tr>
                            	</tbody>
                        	</table>
                        	<br>
                        	<table class="table table-bordered table-invoice" style="max-width: 100%;">
	                            <tbody>
	                            <tr>
	                              <td class="width30 geo"><h5>საკონტაქტო პირი</h5></td>
	                              <td class="width70 geo" style="text-align:center;"><strong><h5 contenteditable="true" data-old_value="<?php echo $row["p2fullname"]; ?>" onBlur="saveInlineEdit(this,'p2fullname','<?php echo $row["ID"]; ?>')" onClick="highlightEdit(this);"><?php echo $row['p2fullname'];?></h5> </strong></td>
	                            </tr>
	                            <tr>
	                              <td class="width30 geo"><h5>საკონტაქტო პირის მობილური</h5></td>
	                              <td class="width70 geo" style="text-align:center;"><strong><h5 contenteditable="true" data-old_value="<?php echo $row["p2phone"]; ?>" onBlur="saveInlineEdit(this,'p2phone','<?php echo $row["ID"]; ?>')" onClick="highlightEdit(this);"><?php echo $row['p2phone'];?></h5> </strong></td>
	                            </tr>
                            	</tbody>
                        	</table>
                      </div>

                      		<table class="table table-bordered table-invoice">
                            <br/>
	                            <thead><tr><td cols="2" class="geo"><h4>კომენტარი:</h4></td></tr></thead>
	                            <tbody>
	                            <tr>
	                              <td colspan="2" class="width70 geo" style="text-align:center;"><strong><h5 contenteditable="true" data-old_value="<?php echo $row["comments"]; ?>" onBlur="saveInlineEdit(this,'comments','<?php echo $row["ID"]; ?>')" onClick="highlightEdit(this);"><?php echo $row['comments'];?></h5> </strong></td>
	                            </tr>
                            	</tbody>
                        	</table>
                    </div>
                    <hr>
                    <div class="row-fluid">
                      <div class="span12">

						
	                    <div class="alert alert-success" style="cursor:pointer" data-toggle="collapse" data-target="#reestri"><h4 class="geo text-center">მოძებნე ამონაწერი საჯარო რეესტრიდან</h4></div>
                        <div style="overflow-x:auto;" class="collapse" id="reestri">
                        <embed src="https://naprweb.reestri.gov.ge/#/search" style="width:100%; height: 700px;"></embed>
                        </div>
                        <hr>
                         
                        <div class="alert" style="cursor:pointer" data-toggle="collapse" data-target="#cesko"><h4 class="geo text-center">მოძებნე ფოტო და რეგისტრაციის მისამართი</h4></div>
                        <div style="overflow-x:auto;" class="collapse" id="cesko">
	                         <div class="alert alert-info">
	                            <h3 class="geo" style="text-align:center;"><?php echo $row['personalid']."<br>".$row['surname'];?></h3>
	                         </div>
                        	<embed src="http://voters.cec.gov.ge/" style="width:100%; height: 300px;"></embed>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <!-- CLOSE USER INFO HERE -->
        <?php
            }
        }
        else {
        ?>
            <div style="overflow-x:auto;">
            <table class="table table-bordered data-table geo">
              <thead>
                <tr >
                    <th style="font-size: 14px;">#</th>
                    <th style="font-size: 14px;">სახელი</th>
                    <th style="font-size: 14px;">გვარი</th>
                    <th style="font-size: 14px;">პირადი #</th>
                    <th style="font-size: 14px;">სტატისტიკა</th>
                    <th style="font-size: 14px;">ქულა</th>
                </tr>
              </thead>
              <tbody>
              <?php
                if($numrows != 0){

                    $counter = 1;

                    while ($row = mysqli_fetch_assoc($query)) {
                        
                        require('formulas.php');

                        $myuserid = $row['ID'];
                ?>
                
                <tr>
                    <td style="text-align:center;vertical-align:middle;"><a href="?userid=<?php echo $myuserid;?>"><?php echo $counter;?></a></td>
                    <td style="text-align:center;vertical-align:middle;"><a href="?userid=<?php echo $myuserid;?>"><?php echo $row['name'];?></a></td>
                    <td style="text-align:center;vertical-align:middle;"><a href="?userid=<?php echo $myuserid;?>"><?php echo $row['surname'];?></a></td>
                    <td style="text-align:center;vertical-align:middle;"><a href="?userid=<?php echo $myuserid;?>"><?php echo $row['personalid'];?></a></td>
                    <td style="text-align:center;" valign="middle">
                    <a href="?userid=<?php echo $myuserid;?>">
                    <div class="<?php echo $progclass;?>" style="width: 90%;margin:auto;">
                        <div class="bar" style="width: <?php echo $progress.'%';?>;"><?php echo $progress.'%';?></div>
                    </div>
                    </a>
                    </td>
                    <td style="text-align:center;vertical-align:middle;"><a href="?userid=<?php echo $myuserid;?>"><?php echo $row['algorithm'];?></a></td>
                </tr>

                <?php
                        $counter++;
                        }
                }

                else {
                    $error = "<tr><td style='font-size: 16px;' colspan='5'>
                    <div class='alert'>
                    <button class='close' data-dismiss='alert'>×</button>
                    <strong>მონაცემთა ბაზა ცარიელია!</strong>
                    </div>
                    </td></tr>";

                    echo $error;
                }
              ?>
              </tbody>
            </table>
            </div>
            <?php
            } // If $_GET['userid'] is not chosen yet
            ?>
          </div>
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
    <script src="js/inline.js"></script>
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