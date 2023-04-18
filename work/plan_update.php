<? 

header("Pragma: no-cache"); 

header("Cache-Control: no-cache,must-revalidate"); 

?>
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

<!DOCTYPE html>
 <html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>marketpro</title>


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


 $SrchYear = ($_POST['SrchYear']);
 $SrchMonth = ($_POST['SrchMonth']);
 $SrchDay = ($_POST['SrchDay']);


  $closed_d_arr = ($_POST['closed_d']);
  $closed_type_arr = ($_POST['closed_type']);

  $workingday_arr = ($_POST['workingday']);



echo "$purpose;$store;$time_in;$time_in2;$modi_no;$SrchYear;$SrchMonth;";
echo "<br>$closed_d_arr[0]";
echo "<br>$closed_type_arr[0]";
//입력데이터 로드

$time = date("Y-m-d H:i:s"); // 현재시간 저장

?>

<?php
//---- 오늘 날짜
$thisyear = date('Y'); // 4자리 연도
$thismonth = date('n'); // 0을 포함하지 않는 월
$today = date('j'); // 0을 포함하지 않는 일

//------ $year, $month 값이 없으면 현재 날짜
$year = isset($_POST['year']) ? $_POST['year'] : $thisyear;
$month = isset($_POST['month']) ? $_POST['month'] : $thismonth;
$day = isset($_POST['day']) ? $_POST['day'] : $today;

$prev_month = $month - 1;
$next_month = $month + 1;
$prev_year = $next_year = $year;
if ($month == 1) {
    $prev_month = 12;
    $prev_year = $year - 1;
} else if ($month == 12) {
    $next_month = 1;
    $next_year = $year + 1;
}
$preyear = $year - 1;
$nextyear = $year + 1;

$predate = date("Y-m-d", mktime(0, 0, 0, $month - 1, 1, $year));
$nextdate = date("Y-m-d", mktime(0, 0, 0, $month + 1, 1, $year));

// 1. 총일수 구하기
$max_day = date('t', mktime(0, 0, 0, $month, 1, $year)); // 해당월의 마지막 날짜
//echo '총요일수'.$max_day.'<br />';

// 2. 시작요일 구하기
$start_week = date("w", mktime(0, 0, 0, $month, 1, $year)); // 일요일 0, 토요일 6

// 3. 총 몇 주인지 구하기
$total_week = ceil(($max_day + $start_week) / 7);

// 4. 마지막 요일 구하기
$last_week = date('w', mktime(0, 0, 0, $month, $max_day, $year));
?>



  <?php
    // 5. 화면에 표시할 화면의 초기값을 1로 설정
    $day=1;

    // 6. 총 주 수에 맞춰서 세로줄 만들기
    for($i=1; $i <= $total_week; $i++){


    // 7. 총 가로칸 만들기
    for ($j = 0; $j < 7; $j++) {
        // 8. 첫번째 주이고 시작요일보다 $j가 작거나 마지막주이고 $j가 마지막 요일보다 크면 표시하지 않음

        if (!(($i == 1 && $j < $start_week) || ($i == $total_week && $j > $last_week))) {



//연월일 값 추가적용
if($month<10){
	$t_month = "0".$month;
}else{
	$t_month = $t_month;
}
if($day<10){
	$t_day = "0".$day;
}else{
	$t_day = $day;
}

$workingday_post = "$year$t_month$t_day";
$workingday_data = $workingday_arr[$workingday_post];

            if ($j == 0) {
                // 9. $j가 0이면 일요일이므로 빨간색
                $style = "holy";
            } else if ($j == 6) {
                // 10. $j가 0이면 토요일이므로 파란색
                $style = "blue";
            } else {
                // 11. 그외는 평일이므로 검정색
                $style = "black";
            }

            // 12. 오늘 날짜면 굵은 글씨
if($workingday_data>0){
echo "$i;$j;$workingday_data;$year;$t_month;$t_day;$day;<br>";
}
			// 14. 날짜 증가
            $day++;
        }

    }

}
//exit;

 ?>

<?php

//make plan type : plan 계획

//1.year month
//$year
//$t_month
$q_no = "";

$query = "select * from plan where year='$year' and month='$t_month' and input_user='$uID' and types='plan' ";

$result = mysqli_query($connection, $query );
while($rows = mysqli_fetch_array($result)) {
	$no = $rows['no'];

	$q_no = $no;
}

$insert_query_1 = "insert into plan () values ('','$year','$t_month','$uID','plan' ";
$update_query_1 = "update plan set mgr='' ";

//2.daily data

for($dd=1;$dd<=31;$dd++){

	if($dd<10){
		$dd2 = "0".$dd;
		$dd3 = "d0".$dd;
	}else{
		$dd2 = $dd;
		$dd3 = "d".$dd;
	}
	$workingday_post = "$year$t_month$dd2";
	$d_data = $workingday_arr[$workingday_post];

	$insert_data_1 .= ",'$d_data'";
	$update_data_1 .= " , $dd3='$d_data'";
}

	$insert_data_2 = ",'','$time','' )";
	$update_data_2 = " , modidate='$time' ";
	$update_data_2 .= "  where no='$q_no'";


if(!$q_no){//insert
	$query = "$insert_query_1 $insert_data_1 $insert_data_2";
}else{		//update
	$query = "$update_query_1 $update_data_1 $update_data_2";
}

echo "<br>$query;";
//echo "<br>$insert_query_1;";
//echo "<br>$insert_data_1;";
//echo "<br>$insert_data_2;";
//exit;
    if(!mysqli_query($connection, $query)) echo("<p>Error plan input.</p>");


//echo "<br>$insert_query_1;";
//echo "<br>$insert_data_1;";
//echo "<br>$insert_data_2;";
//exit;






//make plan type : closed 휴무

//초기화
$q_no = "";
$insert_query_1 = "";
$insert_data_1 = "";
$insert_data_2 = "";
$update_query_1 = "";
$update_data_1 = "";
$update_data_2 = "";

	for($count=0;$count<5;$count++){

		$closed_d = $closed_d_arr[$count];
		$closed_type = $closed_type_arr[$count];

		$closed_data[$closed_d] = $closed_type;

	}

$query = "select * from plan where year='$year' and month='$t_month' and input_user='$uID' and types='closed' ";

$result = mysqli_query($connection, $query );
while($rows = mysqli_fetch_array($result)) {
	$no = $rows['no'];

	$q_no = $no;
}

$insert_query_1 = "insert into plan () values ('','$year','$t_month','$uID','closed' ";
$update_query_1 = "update plan set mgr='' ";

//2.daily data

for($dd=1;$dd<=31;$dd++){

	if($dd<10){
		$dd2 = "0".$dd;
		$dd3 = "d0".$dd;
	}else{
		$dd2 = $dd;
		$dd3 = "d".$dd;
	}


	$workingday_post = "$year$t_month$dd2";
	//$d_data = $workingday_arr[$workingday_post];
	$d_data = $closed_data[$workingday_post];

echo "<br>;$workingday_post;$d_data;";

	$insert_data_1 .= ",'$d_data'";
	$update_data_1 .= " , $dd3='$d_data'";
}

	$insert_data_2 = ",'','$time','' )";
	$update_data_2 = " , modidate='$time' ";
	$update_data_2 .= "  where no='$q_no'";


if(!$q_no){//insert
	$query = "$insert_query_1 $insert_data_1 $insert_data_2";
}else{		//update
	$query = "$update_query_1 $update_data_1 $update_data_2";
}

echo "<br>$query;";
//echo "<br>$insert_query_1;";
//echo "<br>$insert_data_1;";
//echo "<br>$insert_data_2;";
//exit;
    if(!mysqli_query($connection, $query)) echo("<p>Error plan input.</p>");


?>


		<META HTTP-EQUIV="Refresh" CONTENT="0;URL=../work/plan.html?year=<?=$year?>&month=<?=$month?>">




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