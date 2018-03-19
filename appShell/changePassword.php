<?php
  require("config.php");

//print_r($_POST); exit();
	
	$password = $_POST['password'];
	$username = $_POST['username'];
	$oldPassword = $_POST['oldPassword'];

	$hash = md5($oldPassword);
	$newhash = md5($password);

	


	$query = "SELECT 1 FROM users WHERE password = :oldPassword";
	$query_params = array(':oldPassword' => $hash);

	try { 

		
		
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
    } catch(PDOException $ex){ 
		http_response_code(500);
		echo json_encode(array(
			'error' => array(	
			'msg' => 'Error on select checking for dupes: ' . $ex->getMessage(),
			'code' => $ex->getCode(),
			),
		));
		exit();
	} 


	$row = $stmt->fetch();

	if($row) { 

		$sql = "UPDATE users SET password = :password, raw_password = :raw_password WHERE username = :username";
		$query_params = array(':username' => $username, ':password' => $newhash, ':raw_password' => $password);
	
		try { 

		
		
			$stmt = $db->prepare($sql); 
			$result = $stmt->execute($query_params); 
		} catch(PDOException $ex){ 
			http_response_code(500);
			echo json_encode(array(
				'error' => array(	
				'msg' => 'Error on updating: ' . $ex->getMessage(),
				'code' => $ex->getCode(),
				),
			));
			exit();
		} 

    } else {

		http_response_code(500);
		echo json_encode(array(
			'error' => array(
			'msg' => 'This username is already registered: ' ,
			
			),
		));

        exit();

	} 
	
	//print_r ($query_params);
	//exit();

   
   	$query = "SELECT username, name, email FROM users WHERE username = :username";
    $query_params = array(':username' => $username);

    try { 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
		
		$outData = array();
		while($row = $stmt->fetch()) {
			$outData[] = $row;
		} 
		//echo json_encode($outData);
		echo '{"user":' . json_encode($outData) . '}'; 
		exit();
    } catch(PDOException $ex){ 
		http_response_code(500);
		echo json_encode(array(
			'error' => array(	
			'msg' => 'Error on select user: ' . $ex->getMessage(),
			'code' => $ex->getCode(),
			),
		));
		exit();
    } 

?>