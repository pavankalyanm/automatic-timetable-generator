<?php
/**
 * Created by PhpStorm.
 * User: MSaqib
 * Date: 02-09-2016
 * Time: 23:28
 */

include 'connection.php';
if (isset($_POST['UN']) && isset($_POST['PASS'])) {
    $id = $_POST['UN'];
    $password = $_POST['PASS'];
} else {
    die();
}
$q = mysqli_query(mysqli_connect("eu-cdbr-west-01.cleardb.com", "b315615e71a772", "0a9c415c", "heroku_b211df1ac2bee44"), "SELECT name FROM admin WHERE name = '$id' and password = '$password' ");
if (mysqli_num_rows($q) == 1) {
    header("Location:addteachers.php");
} else {
    $message = "Username and/or Password incorrect.\\nTry again.";
    echo "<script type='text/javascript'>alert('$message');</script>";

}
?>