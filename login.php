<?php session_start();
require("loginserv.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>შესვლა</title>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/x-icon" href="img/icons/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="css/bpg-arial-caps.min.css" />
    <link rel="stylesheet" href="css/matrix-login.css" />
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
    <style type="text/css">
    .geo {
        font-family: 'BPG Arial Caps', 'Times New Roman' !important;
    }
    </style>
</head>

<body>
    <div id="loginbox">
        <form id="loginform" class="form-vertical" method="post">
            <div class="control-group normal_text">
                <h3><img src="img/logo.png" alt="Logo" style="width:200px;"/></h3></div>
            <!-- Alert Message -->
            <?php if ($error!=""){
            ?>
            <div class="alert alert-danger geo">
                <strong>შეცდომა:</strong> <?php echo $error;?>
            </div>
            <?php } ?>
            <!-- Alert Message Close -->
            <div class="control-group">
                <div class="controls">
                    <div class="main_input_box">
                        <span class="add-on bg_lg"><i class="icon-user"> </i></span>
                        <input name="user" id="user" class="geo" type="text" placeholder="მომხმარებელი" />
                    </div>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <div class="main_input_box">
                        <span class="add-on bg_ly"><i class="icon-lock"></i></span>
                        <input name="pass" id="pass" class="geo" type="password" placeholder="პაროლი" />
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <center>
                    <input type="submit" name="submit" value="შესვლა" class="btn btn-success btn-large geo" />
                </center>
            </div>
        </form>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/matrix.login.js"></script>
</body>

</html>