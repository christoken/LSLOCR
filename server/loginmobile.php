<?php
//include("auth.php");
include("db_logConfig.php");
//$con = mysqli_connect('localhost','root','Threemodern789','db_0722977672_dairy');
if (mysqli_connect_errno()) {
  echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
  } 
 	$username=$_POST['username'];
	$password=$_POST['password'];
	//$username="chris";
	//$password="chep";
	
//$json_data_array = array();
$json_data_array = "";

  $sqry="SELECT * FROM tbl_locationlog_user
  WHERE
	username='$username' 
	AND password='".md5($password)."'";

  $result=mysqli_query($con,$sqry);
  //echo($result);
  // Return the number of rows in result set
  $surname='';$othernames=''; $telNo='';$pwdChange='';
  $rowcount=mysqli_num_rows($result);  
  while($row = $result->fetch_assoc()){ 
		$surname = $row['surname'];
		$othernames = $row['othernames'];
		$telNo = $row['telNo'];	
		$pwdChange = $row['passwordchange'];	
		
  }
  if($rowcount>0){
  $json_data_array="success";
  if(!isset($_SESSION)) { // if the session is not started, start it
        session_start(); 
    }
    else{ // otherwise destroy and restart
        session_destroy();
        session_start(); 
    }
	 
	$_SESSION["names"]=$surname ."  ".$othernames;
	$_SESSION["username"] = $username;
	$_SESSION["login"] = $username;
	$json_data_array=$_SESSION["login"]."_".$_SESSION["names"]."_".$telNo."_".$pwdChange;
	//echo $_SESSION['a'];
  }
  else{
	 if(!isset($_SESSION)) { 
		session_start(); 
	 }
	  //  $json_data_array="Failer";
		$_SESSION["login"] = "";		
		$json_data_array=$_SESSION["login"];
		}
 
   mysqli_free_result($result);
  echo json_encode($json_data_array);
?>

