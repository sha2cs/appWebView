<?php

include("connection.php");
$con = connection();

$id=$_POST["ID"];
$name = $_POST['Name'];
$lastname = $_POST['Lastname'];
$username = $_POST['Username'];
$password = $_POST['password'];
$email = $_POST['email'];

$sql="UPDATE users SET name='$name', lastname='$lastname', username='$username', password='$password', email='$email' WHERE id='$id'";
$query = mysqli_query($con, $sql);

if($query){
    Header("Location: index.php");
}else{

}

?>