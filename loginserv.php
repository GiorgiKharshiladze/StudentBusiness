<?php
$error = "";

if (isset($_POST['submit'])){
	if(empty($_POST['user']) || empty($_POST['pass'])){
		$error = "მომხმარებელი ან პაროლი არასწორია";
	}
	else {
		$user = $_POST['user'];
		$pass = $_POST['pass'];

		require("connect.php");

		$query = mysqli_query($conn, "SELECT * from users WHERE pass='$pass' AND user='$user'");

		$numrows = mysqli_num_rows($query);
		if($numrows != 0){
			while ($row = mysqli_fetch_assoc($query)) {
					$dbusername = $row['user'];
					$dbpassword = $row['pass'];
				}
			if($user == $dbusername && $pass == $dbpassword){
				$_SESSION["sess_user"]=$user;
				header("Location:index.php");
				exit;
			}

		}
		else {
			$error = "მომხმარებელი ან პაროლი არასწორია";
		}
		mysqli_close($conn);
	}

}


?>