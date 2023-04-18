<?php
session_start();

$uID = $_SESSION['uID'];
$uName = $_SESSION['uName'];
$uPass = $_SESSION['uPass'];
$uLevel = $_SESSION['uLevel'];
$uBrand = $_SESSION['uBrand'];

//echo "<br><br><br><br><br><br><br><br><br><br>$uID;$uName;$uPass;$uLevel;$uBrand;;";

//echo $_SESSION['uID'];

//echo phpinfo();
?>

<?php  include "../include/dbinfo.inc" ?>

<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<body>

<h1>annual input</h1>

<?php

 /* Connect to MySQL and select the database. */

  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

  if(mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

   $database = mysqli_select_db($connection, DB_DATABASE);

  /* Ensure that the Employees table exists. */

  VerifyEmployeesTable($connection, DB_DATABASE);

  /* If input fields are populated, add a row to the Employees table. */
?>

<?php  include "../include/db_query.php" ?>

<?php

 $category = ($_POST['category']);

 $username = ($_POST['username']);
 $userjumin = ($_POST['userjumin']);
 $phone = ($_POST['phone']);
 $n_days = ($_POST['n_days']);
 $start_d = ($_POST['start_d']);
 $end_d = ($_POST['end_d']);

 $checkno = ($_POST['checkno']);

 $types = ($_POST['types']);
 $contents = ($_POST['contents']);
 $sign = ($_POST['sign']);

 $q_no = ($_POST['q_no']);

 $t_year = ($_POST['t_year']);
 $t_month = ($_POST['t_month']);
 $t_day = ($_POST['t_day']);

 $target_date = ($_POST['target_date']);
 $requestdate = $target_date;


$SrchYear = ($_POST['SrchYear']);
$SrchMonth = ($_POST['SrchMonth']);
$SrchDay = ($_POST['SrchDay']);


if(!$SrchYear){
	$SrchYear = date("Y");
}
if(!$SrchMonth){
	$SrchMonth = date("m");
}
if(!$SrchDay){
	$SrchDay = date("d");
}
$visitdate = "$SrchYear$SrchMonth$SrchDay";


echo "$category;$username;$n_days;$start_d;$end_d;$contents;$q_no;;<br>";


//exit;

//입력데이터 로드

//1. 체크인 , 방문목적
$time_2 = date("Ymd"); // 현재시간 저장

//$visitdate = "$time_2";

echo ($visitdate);

$d_count=1;
//$brand = "해즈브로";
//$store = "이마트 성수점";
//$store = "s100001";


$brand = $uBrand;
$user_id = $uID;

$username = $user_names[$uID];
$phone = $user_phonenums[$uID];

$input_value = " '','$category','$username','$userjumin','$phone','$SrchYear','$SrchMonth','$SrchDay','$visitdate','$n_days','$start_d','$end_d','$requestdate','$brand','$user_id','$types','$contents','$mgr','$sign','$complete'";

$update_value = "  $date='$n_days' , start ='$start_d'  , end ='$end_d'  , types ='$types'  , contents ='$contents'  , sign ='$sign'  , complete ='$complete' , requestdate='$requestdate' ";


if(!$q_no){
   $query = "INSERT INTO annual (no,category,name,jumin,phone,year,month,day,visitdate,date,start,end,requestdate,brand,user_id,types,contents,mgr,sign,complete) VALUES ($input_value)";

}else{ //update
   $query = "update annual set  $update_value   where no='$q_no' ";
}


echo "$query;<br>;";
//exit;

   if(!mysqli_query($connection, $query)) echo("<p>Error adding employee data.</p>");



/*
$result = mysqli_query($connection, "SELECT * FROM daily where visitdate = '$visitdate' order by no ");
while($rows = mysqli_fetch_array($result)) {
	$no = $rows['no'];

	$q_no = $no;
}
*/




//exit;


?>



</table>

		<META HTTP-EQUIV="Refresh" CONTENT="1;URL=../work/annual.html?k_no=<?=$k_no?>&store=<?=$store?>&SrchYear=<?=$SrchYear?>&SrchMonth=<?=$SrchMonth?>&SrchDay=<?=$SrchDay?>">


<!-- Clean up. -->

<?php

  mysqli_free_result($result);

  mysqli_close($connection);

?>

</body>

</html>

<?php

/* Add an employee to the table. */

function AddEmployee($connection, $name, $address) {

   $n = mysqli_real_escape_string($connection, $name);

   $a = mysqli_real_escape_string($connection, $address);

   $query = "INSERT INTO `Employees`(`Name`, `Address`) VALUES('$n', '$a');";

   if(!mysqli_query($connection, $query)) echo("<p>Error adding employee data.</p>");

}

/* Check whether the table exists and, if not, create it. */

function VerifyEmployeesTable($connection, $dbName) {

  if(!TableExists("Employees", $connection, $dbName))

  {

     $query = "CREATE TABLE `Employees`(

         `ID` int(11) NOT NULL AUTO_INCREMENT,

         `Name` varchar(45) DEFAULT NULL,

         `Address` varchar(90) DEFAULT NULL,

         PRIMARY KEY(`ID`),

         UNIQUE KEY `ID_UNIQUE`(`ID`)

      ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";

     if(!mysqli_query($connection, $query)) echo("<p>Error creating table.</p>");

  }

}

/* Check for the existence of a table. */

function TableExists($tableName, $connection, $dbName) {

  $t = mysqli_real_escape_string($connection, $tableName);

  $d = mysqli_real_escape_string($connection, $dbName);

 

  $checktable = mysqli_query($connection,

      "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'");

  if(mysqli_num_rows($checktable)> 0) return true;

  return false;

}

?>