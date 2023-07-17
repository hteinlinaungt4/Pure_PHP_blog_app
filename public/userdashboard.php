<?php 
session_start();
if(!isset($_SESSION['userdata'])){
    header('location:login.php');
}else{
    if($_SESSION['userdata']['role'] !== 'user'){
        header('location:admindashboard.php');
 }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Userdashboard</title>
</head>
<body>
    <h1>Userdashboard</h1>
    
</body>
</html>