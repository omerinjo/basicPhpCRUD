<?php
session_start();
$name = '';
$lastName = '';
$email = '';
$update = false;
$id=0;
require_once('config.php');

$mysqli = new mysqli($host, $user, $password, $database) or die(mysqli_error($mysqli));

if ($result = $mysqli->query("SHOW TABLES LIKE '".$database."'")) {
    if($result->num_rows == 0) {
        $mysqli->query("CREATE TABLE data (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(30),
            last_name  VARCHAR(30),
            email VARCHAR(50)
        )");
    }
}

  

if(isset($_POST['save'])){
    $name = $_POST['name'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];

    if($name !='' && $lastName !='' && $email !=''){
        $mysqli -> query("INSERT INTO data (name, last_name, email ) VALUES('$name', '$lastName','$email')") or
        die($mysqli -> error);
        $_SESSION['message']="Record has been saved!";
        $_SESSION['msg_type']='success';
    
        header("location: index.php");
    }else{
        $_SESSION['message']="Fields cannot be empty!";
        $_SESSION['msg_type']='danger';
    
        header("location: index.php"); 
    }
}

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM data WHERE id=$id") or die(mysqli_error());

    $_SESSION['message']="Record has been delited!";
    $_SESSION['msg_type']='danger';

    header("location: index.php");
}

if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    $update = true;
    $resoult = $mysqli -> query("SELECT * FROM data WHERE id=$id") or die(mysqli_error());
    if(count($resoult)==1){
        $row = $resoult->fetch_array();
        $name = $row['name'];
        $lastName = $row['last_name'];
        $email = $row['email'];
    }
}

if(isset($_POST['update'])){
    $id= $_POST['id'];
    $name =$_POST['name'];
    $lastName=$_POST['lastName'];
    $email =$_POST['email'];

    $mysqli -> query("UPDATE `data` SET `name`='$name', `last_name`='$lastName', `email`='$email' WHERE `id`='$id'") or die(mysqli_error($mysqli));

    $_SESSION['message'] = "Records has been updated!";
    $_SESSION['msg_type'] = "warning";

    header('location: index.php');
}
