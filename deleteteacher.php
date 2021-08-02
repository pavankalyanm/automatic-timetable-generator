<?php
/**
 * Created by PhpStorm.
 * User: MSaqib
 * Date: 30-09-2016
 * Time: 22:44
 */
include 'connection.php';
$id = $_GET['name'];
$q = mysqli_query(mysqli_connect("eu-cdbr-west-01.cleardb.com", "b315615e71a772", "0a9c415c", "heroku_b211df1ac2bee44"),
    "DELETE FROM teachers WHERE faculty_number = '$id' ");
$drop = "DROP TABLE " . $id;

$q = mysqli_query(mysqli_connect("eu-cdbr-west-01.cleardb.com", "b315615e71a772", "0a9c415c", "heroku_b211df1ac2bee44"), $drop);
if ($drop) {

    header("Location:addteachers.php");

} else {
    echo 'Error';
}
?>

