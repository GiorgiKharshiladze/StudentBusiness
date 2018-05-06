
<?php
session_start();
session_destroy();
echo '<script type="text/javascript">
           window.location = "login.php"
      </script>';
// header('Location: http://GioKhar.Com/StudentBusiness/login.php');
exit();
?>
