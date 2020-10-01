<?php
$link = new mysqli(MYSQL_HOST,MYSQL_USER,MYSQL_PASS,MYSQL_DB);
$link->set_charset("utf8");
if(mysqli_connect_error()){
    die("ERROR: UNABLE TO CONNECT: ".mysqli_connect_error());
}
// $link2 = new mysqli(MYSQL_HOST,MYSQL_USER_TRANSACTION,MYSQL_PASS_TRANSACTION,MYSQL_DB_TRANSACTION);
// if(mysqli_connect_error()){
//     die("ERROR: UNABLE TO CONNECT: ".mysqli_connect_error());
// }
function httpPost($url,$params)
{
	$postData = '';
	 //create name value pairs seperated by &
	foreach($params as $k => $v) 
	{ 
	  $postData .= $k . '='.$v.'&'; 
	}
	$postData = rtrim($postData, '&');

	$ch = curl_init();  

	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch,CURLOPT_HEADER, false); 
	curl_setopt($ch, CURLOPT_POST, count($postData));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    

	$output=curl_exec($ch);

	curl_close($ch);
	return $output;

}



// --------- GET ALL THE SPARSH USERS -----------------------
if (isset($_GET['allStudents'])) {
      // Data Sanitazitation and details in json
	$partnerId = $_SESSION["userId"];

	 $sql = "SELECT * FROM ATHENEUM_STUDENT WHERE PARTNER_ID = '$partnerId' ORDER BY ID ASC";
	 $result = mysqli_query($link,$sql);
	 $tempArray = [];
	 if ($result) {
	    if(mysqli_num_rows($result)>0){
	    	$i = 1;
	      while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) { 
	      	$paid = $row['PAID'];
	      	if ($paid == 0) {
	      		$status = '<span style="background-color:#FAD02E; font-weight:bold; padding:5px; cursor:pointer;" title="Payment not confirmed!">Registered</span>';
	      	}elseif ($paid > 0) {
	      		$status = '<span style="background-color:#45CE30; font-weight:bold; padding:5px; cursor:pointer; " title="Successfully Enrolled!">Enrolled</span>';
	      	}
	      	?>
	      	<tr>
	            <td><?php echo $i; ?></td>
	            <td><?php echo $row['NAME']; ?></td>
	            <td><?php echo $row['EMAIL']; ?></td>
	            <td><?php echo $row['PHONE']; ?></td>
	            <td><?php echo $row['PROGRAM_TYPE']; ?></td>
	            <td><?php echo $row['ENROLL_DATE']; ?></td>
	            <td><?php echo $status; ?></td>
	            <td>
	            	<div class="btn-group"> 
		            	<button class="btn btn-sm btn-primary" onclick="fetchSingleStudent(`<?php echo $row['UNI_ID']; ?>`)" data-toggle="modal" data-target="#exampleModal">Edit</button>
		            	<button class="btn btn-sm btn-danger" onclick="deleteStudent(`<?php echo $row['UNI_ID']; ?>`)">Delete</button>
	            	</div>
	        	</td>
	        </tr>
	        

	     <?php $i++; }
	    }else{
	      // $errorm = "No blog avaliable. Please create one!";
	      // $errorm =json_encode($errorm);
	      $data = null;
	      // $data = json_encode($data);
	    }
	  }else{
	    $errorm = mysqli_error($link);
	  }

}

if (isset($_POST['formName']) && $_POST['formName']=="enrollStudent"){
   	$programType =  $_POST['programType'];
   	$programName =  $_POST['programName'];
   	$name =  $_POST['name'];
   	$phone =  $_POST['phone'];
   	$email =  $_POST['email'];
   	$country =  $_POST['country'];
   	$state =  $_POST['state'];
   	$city =  $_POST['city'];
   	$postal =  $_POST['pin']; 
   	$partnerId = $_SESSION["userId"];
   	$today = date("Y-m-d");

   	$uniqueUserId = D_create_UserId();

   	$password = $_POST['password'];
   	$hashedPassword = md5($password);

   	$details = array("country" => $country, "state" => $state, "city" => $city, "postal" => $postal);
   	$details =  json_encode($details);

	$sql = "SELECT * FROM ATHENEUM_STUDENT WHERE EMAIL = '$email' OR PHONE = '$phone'";
	$result = mysqli_query($link, $sql);
	if ($result) {
		// $data = "success";
		if(mysqli_num_rows($result)>0){
			$errorm = "The Student is already registered!";
		}else{
			// $data = "Success";
			$stmt = $link->prepare("INSERT INTO ATHENEUM_STUDENT (`UNI_ID`, `PROGRAM_TYPE`, `PROGRAM_NAME`, `NAME`, `PHONE`, `EMAIL`, `PASSWORD`, `STATUS`, `DETAILS`, `PARTNER_ID`, `ENROLL_DATE`) VALUES (?, ?, ?, ?, ?, ?, ?,'ENROLLED IN COURSE', ?, ?, ?)");
      		$stmt->bind_param("ssssssssss", $uniqueUserId, $programType, $programName, $name, $phone, $email, $hashedPassword, $details, $partnerId, $today);
      		if ($stmt->execute()) {        
		        $data = "Successfully Enrolled The Student";
		    
		    }else{
		    	$errorm = "Failed-> ".mysqli_error($link);
		    }
		}
		
	}
	$myObj = new stdClass();
	$myObj->data = $data;
	$myObj->errorm = $errorm;
	$myJSON = json_encode($myObj);
	echo $myJSON;
}



   if (isset($_POST['formName']) && $_POST['formName']=="updateStudent"){

   	// $data = "Hello";
	   	$studentId =  $_POST['studentId'];
	   	$programType =  $_POST['programType'];
	   	$programName =  $_POST['programName'];
	   	$name =  $_POST['name'];
	   	$phone =  $_POST['phone'];
	   	$email =  $_POST['email'];
	   	$country =  $_POST['country'];
	   	$state =  $_POST['state'];
	   	$city =  $_POST['city'];
	   	$postal =  $_POST['pin']; 
	   	$partnerId = $_SESSION["userId"];

	   	$details = array("country" => $country, "state" => $state, "city" => $city, "postal" => $postal);
	   	$details =  json_encode($details);

		$sql = "SELECT * FROM ATHENEUM_STUDENT WHERE EMAIL = '$email' OR PHONE = '$phone'";
		$result = mysqli_query($link, $sql);
		if ($result) {
			// $data = "success";
			if(mysqli_num_rows($result)>0){
				$stmt = $link->prepare("UPDATE ATHENEUM_STUDENT SET `PROGRAM_TYPE` = ?, `PROGRAM_NAME` = ?, `NAME` = ?, `PHONE` = ?, `EMAIL` = ?, `STATUS` = 'ENROLLED IN COURSE', `DETAILS` = ? WHERE `EMAIL` = '$email' AND `UNI_ID` = '$studentId'");
				$stmt->bind_param("ssssss", $programType, $programName, $name, $phone, $email, $details);
				if ($stmt->execute()) {        
			        $data = "Successfully updated data";
			       
			    }else{
			    	$errorm = "Failed-> ".mysqli_error($link);
			    }
			}else{
				// $data = "Success";
				$errorm = "Error";
			}
			
		}
		$myObj = new stdClass();
		$myObj->data = $data;
		$myObj->errorm = $errorm;
		$myJSON = json_encode($myObj);
		echo $myJSON;
		

   }




if (isset($_GET['fetchSingleStudent'])){
  $id = $_GET['id'];
  $sql = "SELECT * FROM ATHENEUM_STUDENT WHERE `UNI_ID`= '$id'";
  $result = mysqli_query($link, $sql);
  if ($result) {
    if(mysqli_num_rows($result)>0){
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      // $data = json_encode($row);
      $data = $row;
      $errorm = null;
    }
  }else{
    $data = null;
    $errorm = "Try AGain!";
  }
  $myObj = new stdClass();
	$myObj->data = $data;
	$myObj->errorm = $errorm;
	$myJSON = json_encode($myObj);
	echo $myJSON;
}



if (isset($_POST['formName']) && $_POST['formName']=="deleteStudent"){
 	// $data = "Hello";
    $studentId =  $_POST['studentId'];
    
    // $data = $sessionDate;
   
   	$sql = "DELETE FROM ATHENEUM_STUDENT WHERE UNI_ID='$studentId'";
   	
   	$result = mysqli_query($link, $sql);
	
	if ($result) {

		$errorm = null;
	    $data = $userId;
	}else{
		$errorm = "Failed-> ".mysqli_error($link);
	}

   	// $data = $password;
   	
$myObj = new stdClass();
$myObj->data = $data;
$myObj->errorm = $errorm;
$myJSON = json_encode($myObj);
echo $myJSON;

}





?>