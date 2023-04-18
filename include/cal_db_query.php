<?php
	//mysql_query('set names utf8'); 
?>

<?php
//calendar pre month

$SrchYear_pre = $SrchYear;
$SrchMonth_pre = $SrchMonth-1;
if($SrchMonth_pre<10 and $SrchMonth_pre>0){
	$SrchMonth_pre = "0".$SrchMonth_pre;
}else if($SrchMonth_pre==0){
	$SrchMonth_pre = 12;
	$SrchYear_pre = $SrchYear_pre-1;
}


$SrchYear_2nd = $SrchYear;
$SrchMonth_2nd = $SrchMonth-2;
if($SrchMonth_2nd<10 and $SrchMonth_2nd>0){
	$SrchMonth_2nd = "0".$SrchMonth_2nd;
}else if($SrchMonth_pre==0){
	$SrchMonth_2nd = 12;
	$SrchYear_2nd = $SrchYear_2nd-1;
}else if($SrchMonth_pre==-1){
	$SrchMonth_2nd = 11;
	$SrchYear_2nd = $SrchYear_2nd-1;
}

	$cal_que_pre = "select * from week_cal where year ='$SrchYear_pre' and month='$SrchMonth_pre' order by no";
/*
	$cal_result_pre = @mysql_query($cal_que_pre);
	$cal_total_pre = @mysql_num_rows($cal_result_pre);

//echo "$cal_que_pre;$cal_total_pre;";
	for($count=0;$count<$cal_total_pre;$count++){
		$rows = @mysql_fetch_array($cal_result_pre);
*/

$cal_total_pre = 0;
$result = mysqli_query($connection, $cal_que_pre );
while($rows = mysqli_fetch_array($result)) {

		$counts = $rows['count'];
		$days = $rows['day'];

		$q_day_pre[$counts] = $days;
		$q_count_pre[$count] = $counts;

		$cal_total_pre++;

	}


?>
<?php
//calendar this_month

	$cal_que = "select * from week_cal where year ='$SrchYear' and month='$SrchMonth' order by no";
/*
	$cal_result = @mysql_query($cal_que);
	$cal_total = @mysql_num_rows($cal_result);

//echo "$cal_que;$cal_total;";
	for($count=0;$count<$cal_total;$count++){
		$rows = @mysql_fetch_array($cal_result);
*/
$cal_total = 0;
$result = mysqli_query($connection, $cal_que );
while($rows = mysqli_fetch_array($result)) {

		$counts = $rows['count'];
		$days = $rows['day'];

		$q_day[$counts] = $days;
		$q_count[$count] = $counts;

		$cal_total++;

	}
?>

<?php
//calendar next_month

$SrchYear_next = $SrchYear;
$SrchMonth_next = $SrchMonth+1;
if($SrchMonth_next<10){
	$SrchMonth_next = "0".$SrchMonth_next;
}else if($SrchMonth_next>12){
	$SrchMonth_next = "01";
	$SrchYear_next = $SrchYear_next+1;
}

	$cal_que_next = "select * from week_cal where year ='$SrchYear_next' and month='$SrchMonth_next' order by no";
/*
	$cal_result_next = @mysql_query($cal_que_next);
	$cal_total_next = @mysql_num_rows($cal_result_next);

//echo "$cal_que_next;$cal_total;";
	for($count=0;$count<$cal_total_next;$count++){
		$rows = @mysql_fetch_array($cal_result_next);
*/
$cal_total_next = 0;
$result = mysqli_query($connection, $cal_que_next );
while($rows = mysqli_fetch_array($result)) {

		$counts = $rows['count'];
		$days = $rows['day'];

		$q_day_next[$counts] = $days;
		$q_count_next[$count] = $counts;

		$cal_total_next++;

	}
?>
<?php
//calendar call plan week 2012-08-29

	$cal_que = "select * from week_cal where year ='$SrchYear' and month='$SrchMonth' order by no";
/*
	$cal_result = @mysql_query($cal_que);
	$cal_total_week = @mysql_num_rows($cal_result);

//echo "$cal_que;$cal_total;";

	$yearmonth="$SrchYear$SrchMonth";

	for($count=0;$count<$cal_total_week;$count++){
		$rows = @mysql_fetch_array($cal_result);
*/
$cal_total_week = 0; 
$result = mysqli_query($connection, $cal_que );
while($rows = mysqli_fetch_array($result)) {

		$days = $rows['day'];//1-31
		$w_visitdate = $rows['visitdate'];//201209
		$weeks = $rows['week'];//1-5
		$counts = $rows['count'];//1-7

		$w_day[$counts] = $days;
		if($yearmonth==$w_visitdate){
			$old_counts = $weeks;
		}else if($yearmonth>$w_visitdate){
			$weeks = 0;
		}else{
			$weeks = $old_counts+1;
		}

		$w_date[$weeks][$counts] = $days;//call plan에 쓸 일자 데이터

		//echo "$weeks;$counts;$days;<br>";

		if($weeks>$max_w_count)$max_w_count = $weeks;//업데이트 계속
		if($weeks<$min_w_count)$min_w_count = $weeks;//업데이트 계속

		$cal_total_week++;
		
	}
?>


<?php
//calendar call plan weeks this month 2012-11-12

	$cal_que = "select * from week_cal where visitdate ='$SrchYear$SrchMonth' order by no";
/*
	$cal_result = @mysql_query($cal_que);
	$cal_visitdate_week_ = @mysql_num_rows($cal_result);

//echo "$cal_que;$cal_total;";

	for($count=0;$count<$cal_visitdate_week_;$count++){
		$rows = @mysql_fetch_array($cal_result);
*/
$cal_visitdate_week_ = 0;
$result = mysqli_query($connection, $cal_que );
while($rows = mysqli_fetch_array($result)) {


		$w_no = $rows['no'];
		$cvw_no[$count] = $w_no;
		
		$days = $rows['day'];//1-31
		$months = $rows['month'];//01-12
		$years = $rows['year'];//2012
		$w_visitdate = $rows['visitdate'];//201209
		$week_visitdate[$count] = $w_visitdate;
		$weeks = $rows['week'];//1-5
		$counts = $rows['count'];//1-7

		$weeks_days[$weeks][$counts] = $days;
		$weeks_months[$weeks][$counts] = $months;
		$weeks_years[$weeks][$counts] = $years;

		$cvw_no_days[$w_no] = $days;
		$cvw_no_months[$w_no] = $months;
		$cvw_no_years[$w_no] = $years;
		$cvw_no_weeks[$w_no] = $weeks;

		$week_max = $weeks;//최종 week
		$week_list[$count] = $weeks;

		$cal_visitdate_week_++;

	}

?>


