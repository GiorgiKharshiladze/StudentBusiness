<?php

include("connect.php");

$column = $_REQUEST['column'];
$value = $_REQUEST['value'];
$id = $_REQUEST['id'];


$sql = "UPDATE portfolio set ".$column." = TRIM('".$value."') WHERE ID='".$id."'";
mysqli_query($conn,$sql);


$qvariable = mysqli_query($conn,"SELECT * from portfolio WHERE ID='".$id."'");
$row = mysqli_fetch_assoc($qvariable);

$paid = $row['paid'];
$total = $row['total'];
$discount = $row['discount']/100; // Convert discount percent into decimal fraction
$index = 1 - $discount; // Index to reduce total $total

$finaltopay = $total * $index - $paid;

$risk = $row['risk'];
if($risk==0) {$risk = 1;}

$myscore = $row['myscore'];
if($row['myscore']==0) {$myscore = 1;}

$algorithm = ($risk+$myscore)*$finaltopay;


$sql1 = "UPDATE portfolio set finaltopay = TRIM('".$finaltopay."') WHERE ID='".$id."'";
mysqli_query($conn, $sql1);
$sql2 = "UPDATE portfolio set algorithm = TRIM('".$algorithm."') WHERE ID='".$id."'";
mysqli_query($conn, $sql2);




?>