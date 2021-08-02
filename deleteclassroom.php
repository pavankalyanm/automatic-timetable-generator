<?php
/**
 * Created by PhpStorm.
 * User: MSaqib
 * Date: 16-11-2016
 * Time: 14:46
 */
include 'connection.php';
$id = $_GET['name'];
$q = mysqli_query(mysqli_connect("eu-cdbr-west-01.cleardb.com", "b315615e71a772", "0a9c415c", "heroku_b211df1ac2bee44"),
    "DELETE FROM classrooms WHERE name = '$id' ");
if ($q) {

    header("Location:addclassrooms.php");

} else {
    echo 'Error';
}