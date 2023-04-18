<?php

//id list

$id_count = 0;

$result = mysqli_query($connection, "SELECT * FROM id where 1 ");
while($rows = mysqli_fetch_array($result)) {

		$userID		 = $rows['id'];
		$userName		 = $rows['name'];
		$userPhone		 = $rows['phone'];
		$userPass		 = $rows['pass'];
		$userLevel		 = $rows['level'];

		$uBrand		 = $rows['brand'];

		$user_names[$userID] = $userName;
		$user_phonenums[$userID] = $userPhone;
		$user_levels[$userID] = $userPass;
		$user_brands[$userID] = $userLevel;


$id_count++;

//echo "$count;<br>";

}

$result = mysqli_query($connection, "SELECT * FROM store where 1 ");

while($rows = mysqli_fetch_array($result)) {

	$no = $rows['no'];
	$scode = $rows['scode'];
	$s_account[$scode] = $rows['account'];
	$s_store[$scode] = $rows['store'];

	$store_name[$scode] = "$s_account[$scode] $s_store[$scode]";


//echo "$no;$uid;$uscode;$ucycle;;<br>";

}



?>
