<?php 
	$link = mysqli_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PASS,MYSQL_DB_BEANSTALKFP);
    if(mysqli_connect_error()){
        die("ERROR: UNABLE TO CONNECT: ".mysqli_connect_error());
    }
    if (isset($_GET['business'])) {
    	$bsns =  $_POST['value'];
    	$sql = "SELECT DISTINCT(PROGRAM) FROM FRP_TB_ANNEXURE_PROGRAM WHERE BUSINESS_VERTICAL = '$bsns'";
			$result = mysqli_query($link,$sql);
			
			 if(mysqli_num_rows($result)>0){
			 	while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
			 		# code...
			 		$program = $row["PROGRAM"];
	                echo "<option value='". $program ."'>" .$program ."</option>" ;
                
			 	}
               
            }
    }

	

 ?>