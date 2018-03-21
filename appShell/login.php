<?php

//login.php

require("config.php");
//print_r($_POST); exit();
// if empties
if(empty($_POST['username'])) die("Username or email required");
if(empty($_POST['password'])) die("Password required");	


// assign variables
$remember_token = $_POST['loginToken'];
$username = $_POST['username'];
$email = $_POST['username'];
$password = $_POST['password'];
$hash = md5($password);
$rememberMe = $_POST['rememberMe'];

// accept rember me flag and token



if (filter_var($email, FILTER_VALIDATE_EMAIL)!= false) {
    $query = "SELECT username FROM users WHERE email = :email AND password = :password";
    $query_params = array(':email' => $email, ':password' => $hash,);
} else {
    $query = "SELECT username FROM users WHERE username = :username AND password = :password";
    $query_params = array(':username' => $username, ':password' => $hash,);
}


//$query = "SELECT 1 FROM users WHERE username = :username AND password = :password";
//$query_params = array(':username' => $username, ':password' => $hash,);
//echo $query; exit();

//
try { 
    $stmt = $db->prepare($query); 
    $result = $stmt->execute($query_params); 
} catch(PDOException $ex){ 
    http_response_code(500);
    echo json_encode(array(
        'error' => array(	
        'msg' => 'Error on logging in: ' . $ex->getMessage(),
        'code' => $ex->getCode(),
        ),
    ));
    exit();
} 
//if ture update user by user ID SET the token
$row = $stmt->fetch(); 
if(!$row) { 
    //die("This username address is already registered"); 
    // setup reset password button and sent password via email
    //echo "0 .This username is already registered"; // for failure
    http_response_code(500);
    echo json_encode(array('error' => array('msg' => 'invalid credentials', ),));
    exit();
} 
$username = $row['username'];


//if remeber flag is true update token to database by username
//if true update user by user ID SET the token

if($rememberMe = true){

    $query = "UPDATE users SET remember_token = :login_token WHERE username = :username";
    $query_params = array('login_token' => $remember_token, 'username' => $username);


    try { 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
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
}


//return user
$query = "SELECT ID, username, name, email FROM users WHERE username = :username";
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