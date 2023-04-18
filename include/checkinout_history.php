<?php

//id list

$total_count = 0;
$new_issue = "";

$search_query = " and input_user='$uID' ";
//$search_date = " and year='$SrchYear' and month='$SrchMonth' ";
$search_date = " and 1  ";

$result = mysqli_query($connection, "SELECT * FROM daily where 1 $search_query $search_date order by no desc");
while($rows = mysqli_fetch_array($result)) {

	$no = $rows['no'];
	$d_no = $rows['d_no'];
	$no_list[$total_count] = $no;
	$d_count = $rows['d_count'];
	$d_year[$no] = $rows['year'];
	$d_month[$no] = $rows['month'];
	$d_day[$no] = $rows['day'];
	$d_visitdate[$no] = $rows['visitdate'];
	$d_location[$no] = $rows['location'];
	$d_time_in[$no] = $rows['time_in'];
	$d_time_out[$no] = $rows['time_out'];
	$d_purpose[$no] = $rows['purpose'];
	$d_brand[$no] = $rows['brand'];
	$d_channel[$no] = $rows['channel'];
	$d_store[$no] = $rows['store'];
	$d_mgr[$no] = $rows['mgr'];
	$d_input_user[$no] = $rows['input_user'];
	$d_chk_no[$no] = $rows['chk_no'];

	$d_t_in[$no] = substr($d_time_in[$no],11,5);
	$d_t_out[$no] = substr($d_time_out[$no],11,5);

	$daily_no = $no;


	$d_issue[$no] = $rows['issue'];
	if(!$new_issue){
		$new_issue = $d_issue[$no];
		$new_issue_user = $d_input_user[$no];
		$new_issue_store = $d_store[$no];

	}


$total_count++;
}

$check_in_time = $d_time_in[$no];
$check_out_time = $d_time_out[$no];


if($check_in_time){
	$check_in_time = substr($check_in_time,11,5);
}else{
	$check_in_time = "입력전";
}
if($check_out_time){
	$check_out_time = substr($check_out_time,11,5);
}else{
	$check_out_time = "입력전";
}

?>
