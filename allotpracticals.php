/**
* Created by PhpStorm.
* User: MSaqib
* Date: 17-11-2016
* Time: 18:33
*/
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/html">
<head>                                              <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>TimeTable Management System</title>
    <!-- BOOTSTRAP CORE STYLE CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet"/>
    <!-- FONT AWESOME CSS -->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet"/>
    <!-- FLEXSLIDER CSS -->
    <link href="assets/css/flexslider.css" rel="stylesheet"/>
    <!-- CUSTOM STYLE CSS -->
    <link href="assets/css/style.css" rel="stylesheet"/>
    <!-- Google	Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css'/>
</head>
<body>

<div class="navbar navbar-inverse navbar-fixed-top " id="menu">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

        </div>
        <div class="navbar-collapse collapse move-me">
            <ul class="nav navbar-nav navbar-left">
                <li><a href="addteachers.php">ADD TEACHERS</a></li>
                <li><a href="addsubjects.php">ADD SUBJECTS</a></li>
                <li><a href="addclassrooms.php">ADD CLASSROOMS</a></li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">ALLOTMENT
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href=allotsubjects.php>THEORY COURSES</a>
                        </li>
                        <li>
                            <a href=allotpracticals.php>PRACTICAL COURSES</a>
                        </li>
                        <li>
                            <a href=allotclasses.php>CLASSROOMS</a>
                        </li>
                    </ul>
                </li>
                <li><a href="generatetimetable.php">GENERATE TIMETABLE</a></li>

            </ul>
             <ul class="nav navbar-nav navbar-left">
                <li><a href="index.php">LOGOUT</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
       <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count" style="border-radius:10px;"></span> <span class="glyphicon glyphicon-bell" style="font-size:18px;"></span></a>
       <ul class="dropdown-menu"></ul>
      </li>
     </ul>

        </div>
    </div>
</div>
<!--NAVBAR SECTION END-->
<br>
<form action="allotmentpracticalFormvalidation.php" method="post" style="margin-top: 100px">
    <div align="center">
        <select name="tobealloted" class="list-group-item">
            <?php
            include 'connection.php';
            $q = mysqli_query(mysqli_connect("localhost", "root", "", "ttms"),
                "SELECT * FROM subjects WHERE course_type = 'LAB'");
            $row_count = mysqli_num_rows($q);
            if ($row_count) {
                $mystring = '
         <option selected disabled>Select Subject</option>';
                while ($row = mysqli_fetch_assoc($q)) {
                    if ($row['isAlloted'] == 1)
                        continue;
                    $mystring .= '<option value="' . $row['subject_code'] . '">' . $row['subject_name'] . '</option>';
                }

                echo $mystring;
            }
            ?>
        </select>
    </div>
    <div align="center" style="margin-top: 5px">
        <select name="toalloted" class="list-group-item">
            <?php
            include 'connection.php';

            $q = mysqli_query(mysqli_connect("localhost", "root", "", "ttms"),
                "SELECT * FROM teachers ");
            $row_count = mysqli_num_rows($q);
            if ($row_count) {
                $mystring = '
         <option selected disabled>Select Teacher</option>';
                while ($row = mysqli_fetch_assoc($q)) {
                    $mystring .= '<option value="' . $row['faculty_number'] . '">' . $row['name'] . '</option>';
                }

                echo $mystring;
            }
            ?>
        </select>
    </div>
    <div align="center" style="margin-top: 5px">
        <select name="toalloted2" class="list-group-item">
            <?php
            include 'connection.php';

            $q = mysqli_query(mysqli_connect("localhost", "root", "", "ttms"),
                "SELECT * FROM teachers ");
            $row_count = mysqli_num_rows($q);
            if ($row_count) {
                $mystring = '
         <option selected disabled>Select Teacher</option>';
                while ($row = mysqli_fetch_assoc($q)) {
                    $mystring .= '<option value="' . $row['faculty_number'] . '">' . $row['name'] . '</option>';
                }

                echo $mystring;
            }
            ?>
        </select>
    </div>
    <div align="center" style="margin-top: 5px">
        <select name="toalloted3" class="list-group-item">
            <?php
            include 'connection.php';

            $q = mysqli_query(mysqli_connect("localhost", "root", "", "ttms"),
                "SELECT * FROM teachers ");
            $row_count = mysqli_num_rows($q);
            if ($row_count) {
                $mystring = '
         <option selected disabled>Select Teacher</option>';
                while ($row = mysqli_fetch_assoc($q)) {
                    $mystring .= '<option value="' . $row['faculty_number'] . '">' . $row['name'] . '</option>';
                }

                echo $mystring;
            }
            ?>
        </select>
    </div>

    </div>
    <div align="center" style="margin-top: 10px">
        <button type="submit" class="btn btn-success btn-lg">Allot</button>
    </div>
</form>
<?php
/**
 * Created by PhpStorm.
 * User: MSaqib
 * Date: 16-11-2016
 * Time: 14:13
 */
include 'connection.php';
if (isset($_GET['name'])) {
    $id = $_GET['name'];
    $q = mysqli_query(mysqli_connect("localhost", "root", "", "ttms"),
        "UPDATE subjects  SET isAlloted = '0' , allotedto = '',allotedto2 = '',allotedto3 = '' WHERE subject_code = '$id' ");

}


?>
<script>
    function deleteHandlersForPractical() {
        var table = document.getElementById("allotedpracticalstable");
        var rows = table.getElementsByTagName("tr");
        for (i = 0; i < rows.length; i++) {
            var currentRow = table.rows[i];
            //var b = currentRow.getElementsByTagName("td")[0];
            var createDeleteHandler =
                function (row) {
                    return function () {
                        var cell = row.getElementsByTagName("td")[0];
                        var id = cell.innerHTML;
                        var x;
                        if (confirm("Are You Sure?") == true) {
                            // window.location.href = "deletepracticalallotment.php?name=" + id;
                            window.location.href = "allotpracticals.php?name=" + id;
                        }

                    };
                };

            currentRow.cells[8].onclick = createDeleteHandler(currentRow);
        }
    }
</script>
<style>
    table {
        margin-top: 70px;
        margin-bottom: 50px;
        font-family: arial, sans-serif;
        border-collapse: collapse;
        margin-left: 80px;
        width: 90%;
    }

    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>

<table id=allotedpracticalstable>
    <caption><strong>PRACTICAL COURSES ALLOTMENT</strong></caption>
    <tr>
        <th width="130">Subject Code</th>
        <th width=200>Subject Title</th>
        <th width="120">Faculty No</th>
        <th width="300">Teacher's Name</th>
        <th width="120">Faculty No</th>
        <th width="300">Teacher's Name</th>
        <th width="120">Faculty No</th>
        <th width="300">Teacher's Name</th>
        <th width="40">Action</th>
    </tr>
    <tbody>
    <?php
    include 'connection.php';
    $q = mysqli_query(mysqli_connect("localhost", "root", "", "ttms"),
        "SELECT * FROM subjects");

    while ($row = mysqli_fetch_assoc($q)) {
        if ($row['isAlloted'] == 0)
            continue;
        if (!($row['course_type'] == "LAB"))
            continue;
        $teacher_id1 = $row['allotedto'];
        $teacher_id2 = $row['allotedto2'];
        $teacher_id3 = $row['allotedto3'];
        $t1 = mysqli_query(mysqli_connect("localhost", "root", "", "ttms"),
            "SELECT name FROM teachers WHERE faculty_number = '$teacher_id1'");
        $trow1 = mysqli_fetch_assoc($t1);
        $t2 = mysqli_query(mysqli_connect("localhost", "root", "", "ttms"),
            "SELECT name FROM teachers WHERE faculty_number = '$teacher_id2'");
        $trow2 = mysqli_fetch_assoc($t2);
        $t3 = mysqli_query(mysqli_connect("localhost", "root", "", "ttms"),
            "SELECT name FROM teachers WHERE faculty_number = '$teacher_id3'");
        $trow3 = mysqli_fetch_assoc($t3);
        echo "<tr><td>{$row['subject_code']}</td>
                    <td>{$row['subject_name']}</td>
                    <td>{$row['allotedto']}</td>
                    <td>{$trow1['name']}</td>
                    <td>{$row['allotedto2']}</td>
                    <td>{$trow2['name']}</td>
                    <td>{$row['allotedto3']}</td>
                    <td>{$trow3['name']}</td>
                   <td>
                    <button>Delete</button></td>
                    </tr>\n";
    }
    echo "<script>deleteHandlersForPractical();</script>";
    ?>
    </tbody>
</table>

<!--HOME SECTION END-->

<!--<div id="footer">
    <!--  &copy 2014 yourdomain.com | All Rights Reserved |  <a href="http://binarytheme.com" style="color: #fff" target="_blank">Design by : binarytheme.com</a>
-->
 <!-- FOOTER SECTION END-->

<script>
$(document).ready(function(){
 
 function load_unseen_notification(view = '')
 {
  $.ajax({
   url:"fetch.php",
   method:"POST",
   data:{view:view},
   dataType:"json",
   success:function(data)
   {
    $('.dropdown-menu').html(data.notification);
    if(data.unseen_notification > 0)
    {
     $('.count').html(data.unseen_notification);
    }
   }
  });
 }
 
 load_unseen_notification();
 
 $('#comment_form').on('submit', function(event){
  event.preventDefault();
  if($('#subject').val() != '' && $('#comment').val() != '')
  {
   var form_data = $(this).serialize();
   $.ajax({
    url:"insert.php",
    method:"POST",
    data:form_data,
    success:function(data)
    {
     $('#comment_form')[0].reset();
     load_unseen_notification();
    }
   });
  }
  else
  {
   alert("Both Fields are Required");
  }
 });
 
 $(document).on('click', '.dropdown-toggle', function(){
  $('.count').html('');
  load_unseen_notification('yes');
 });
 
 setInterval(function(){ 
  load_unseen_notification();; 
 }, 5000);
 
});
</script>

 
</body>
</html>
