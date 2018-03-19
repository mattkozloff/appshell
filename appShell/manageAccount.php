<?php
  require("config.php");

//print_r($_POST); exit();
	
    $username = $_POST['username'];
	$email = $_POST['email'];
	$name = $_POST['name'];
	$id = $_POST['id'];
	
	
	
    $sql = "UPDATE users SET username = :username, name = :name, email = :email WHERE id = :id";
	$query_params = array(':username' => $username, ':name' => $name, ':email' => $email, ':id' => $id);

	//print_r ($query_params);
	//exit();

    try { 
		$stmt = $db->prepare($sql); 
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
	
	$query = "SELECT id, username, name, email FROM users WHERE username = :username";
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