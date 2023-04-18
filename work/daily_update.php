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

<h1>daily update</h1>

<?php

 /* Connect to MySQL and select the database. */

  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

  if(mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

   $database = mysqli_select_db($connection, DB_DATABASE);

  /* Ensure that the Employees table exists. */

  VerifyEmployeesTable($connection, DB_DATABASE);

  /* If input fields are populated, add a row to the Employees table. */

  $employee_name = htmlentities($_POST['Name']);

  $employee_address = htmlentities($_POST['Address']);

  $checklist_total = htmlentities($_POST['checklist_total']);

  $checklist_type_data = ($_POST['checklist_type']);


//  echo "$checklist_total;<br>";
 // echo "$checklist_type_data[0];<br>";
 // echo "$checklist_type_data[1];<br>";

//checkvalue1-5
 $chk_checkvalue1 = ($_POST['checkvalue1']);
 $chk_checkvalue2 = ($_POST['checkvalue2']);
 $chk_checkvalue3 = ($_POST['checkvalue3']);
 $chk_checkvalue4 = ($_POST['checkvalue4']);
 $chk_checkvalue5 = ($_POST['checkvalue5']);
//rangevalue
 $chk_rangevalue = ($_POST['rangevalue']);
//textvalue	
 $chk_textvalue = ($_POST['textvalue']);


 $SrchYear = ($_POST['SrchYear']);
 $SrchMonth = ($_POST['SrchMonth']);
 $SrchDay = ($_POST['SrchDay']);



 $store = ($_POST['store']);

 $purpose = ($_POST['purpose']);

 $time_in = ($_POST['time_in']);
 $time_in2 = ($_POST['time_in2']);

 $modi_no = ($_POST['modi_no']);

 $gps_lat = ($_POST['gps_lat']);
 $gps_lng = ($_POST['gps_lng']);

 $issue = ($_POST['issue']);

 $q_no = $modi_no;



echo "$purpose;$store;$time_in;$time_in2;$modi_no;$gps_lat;$gps_lng;";
//exit;
//입력데이터 로드

if(!$SrchYear){
	$SrchYear = date("Y");
}
if(!$SrchMonth){
	$SrchMonth = date("m");
}
if(!$SrchDay){
	$SrchDay = date("d");
}

//1. 체크인 , 방문목적
$time_2 = date("Ymd"); // 현재시간 저장

$visitdate = "$time_2";

echo ($visitdate);

$d_count=1;
//$brand = "해즈브로";
//$store = "이마트 성수점";
//$store = "s100001";
$store = ($_POST['store']);
$brand = $uBrand;
$c_no = 1;



if($q_no){
//update query
   $query = "update daily set  purpose='$purpose' , lat='$gps_lat' , lng='$gps_lng'  , issue='$issue' where no='$q_no' ";

   if(!mysqli_query($connection, $query)) echo("<p>Error daily update</p>");

}else{

	$input_value = " '' , '$c_no', '$d_count' , '$SrchYear','$SrchMonth','$SrchDay','$visitdate','$location','$gps_lat','$gps_lng','$time_in','$issue','$purpose','$brand','$channel','$store','$mgr','$uID','' ";

   $query = "INSERT INTO daily (no,d_no,d_count,year,month,day,visitdate,location,lat,lng,time_in,issue,purpose,brand,channel,store,mgr,input_user,chk_no) VALUES ($input_value)";

	echo "$query;";
	//exit;

   if(!mysqli_query($connection, $query)) echo("<p>Error daily input data.</p>");



	$result = mysqli_query($connection, "SELECT * FROM daily where visitdate = '$visitdate' order by no ");
	while($rows = mysqli_fetch_array($result)) {
		$no = $rows['no'];

		$q_no = $no;
	}
}


?>



</table>

		<META HTTP-EQUIV="Refresh" CONTENT="0;URL=./daily_list.html?k_no=<?=$k_no?>&store=<?=$store?>&SrchYear=<?=$SrchYear?>&SrchMonth=<?=$SrchMonth?>&SrchDay=<?=$SrchDay?>">


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