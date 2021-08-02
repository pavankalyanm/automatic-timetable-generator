<?php
/**
 * Created by PhpStorm.
 * User: MSaqib
 * Date: 16-11-2016
 * Time: 14:13
 */
include 'connection.php';
$id = $_GET['name'];
$q = mysqli_query(mysqli_connect("eu-cdbr-west-01.cleardb.com", "b315615e71a772", "0a9c415c", "heroku_b211df1ac2bee44"),
    "UPDATE subjects  SET isAlloted = '0' , allotedto = '',allotedto2 = '',allotedto3 = '' WHERE subject_code = '$id' ");
if ($q) {

    header("Location:allotsubjects.php");

} else {
    echo 'Error';
}