<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
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

<div align="center" style="margin-top:80px">
    <form name="import" method="post" enctype="multipart/form-data">
        <input type="file" name="file"/>
        <input type="submit" name="teacherexcel" id="teacherexcel" class="btn btn-info btn-lg" value="IMPORT EXCEL"/>
    </form>
    <?php
    if (isset($_POST['teacherexcel'])) {
        if (empty($_FILES['file']['tmp_name'])) {
            echo '<script>alert("Select a file first! ");</script>';
        } else {
            $file = $_FILES['file']['tmp_name'];
            $handle = fopen($file, 'r');
            $headings = true;
            while (!feof($handle)) {
                $filesop = fgetcsv($handle, 1000);

                $facno = $filesop[0];
                $name = $filesop[1];
                $alias = $filesop[2];
                $designation = $filesop[3];
                $contact = $filesop[4];
                $email = $filesop[5];
                if ($facno == "" || $facno == "Faculty No.") {
                    continue;
                }
                $q = mysqli_query(mysqli_connect("eu-cdbr-west-01.cleardb.com", "b315615e71a772", "0a9c415c", "heroku_b211df1ac2bee44"),
                    "INSERT INTO teachers VALUES ('$facno','$name','$alias','$designation','$contact','$email')");
                if ($q) {
                    $sql = "CREATE TABLE " . $facno . " (
                day VARCHAR(10) PRIMARY KEY, 
                period1 VARCHAR(30),
                period2 VARCHAR(30),
                period3 VARCHAR(30),
                period4 VARCHAR(30),
                period5 VARCHAR(30),
                period6 VARCHAR(30)
                )";
                    mysqli_query(mysqli_connect("eu-cdbr-west-01.cleardb.com", "b315615e71a772", "0a9c415c", "heroku_b211df1ac2bee44"), $sql);
                    $days = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday');
                    for ($i = 0; $i < 6; $i++) {
                        $day = $days[$i];
                        $sql = "INSERT into " . $facno . " VALUES('$day','','','','','','')";
                        mysqli_query(mysqli_connect("eu-cdbr-west-01.cleardb.com", "b315615e71a772", "0a9c415c", "heroku_b211df1ac2bee44"), $sql);
                    }
                }
            }
        }
    }
    ?>
</div>
<div align="center" style="margin-top:20px">
    <button id="teachermanual" class="btn btn-success btn-lg">ADD TEACHER</button>
</div>

<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content" style="margin-top: -60px">
        <div class="modal-header">
            <span class="close">&times</span>
            <h2 id="popupHead">Add Teacher</h2>
        </div>
        <div class="modal-body" id="EnterTeacher">
            <!--Admin Login Form-->
            <div style="display:none" id="addTeacherForm">
                <form action="addteacherFormValidation.php" method="POST">
                    <div class="form-group">
                        <label for="teachername">Teacher's Name</label>
                        <input type="text" class="form-control" id="teachername" name="TN"
                               placeholder="Teacher's Name ...">
                    </div>
                    <div class="form-group">
                        <label for="TF">Faculty No</label>
                        <input type="text" class="form-control" id="facultyno" name="TF" placeholder="Faculty No ...">
                    </div>
                    <div class="form-group">
                        <label for="TF">Alias</label>
                        <input type="text" class="form-control" id="alias_name" name="AL" placeholder="Alias..">
                    </div>
                    <div class="form-group">
                        <label for="designation">Designation</label>

                        <select class="form-control" id="designation" name="TD">
                            <option selected disabled>Select</option>
                            <option value="Professor">Professor</option>
                            <option value="Assistant Professor">Assistant Professor</option>
                            <option value="Associate Professor">Associate Professor</option>
                            <option value="Guest Faculty">Guest Faculty</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="teachercontactnumber">Contact No.</label>
                        <input type="text" class="form-control" id="teachercontactnumber" name="TP"
                               placeholder="+91 ...">
                    </div>

                    <div class="form-group">
                        <label for="teacheremailid">Email-ID</label>
                        <input type="text" class="form-control" id="teacheremailid" name="TE"
                               placeholder="abc@xyz.com ...">
                    </div>
                    <div align="right">
                        <input type="submit" class="btn btn-default" name="ADD" value="ADD">
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
        </div>
    </div>
</div>

<script>
    // Get the modal
    var modal = document.getElementById('myModal');

    // Get the button that opens the modal
    var addteacherBtn = document.getElementById("teachermanual");
    var heading = document.getElementById("popupHead");
    var facultyForm = document.getElementById("addTeacherForm");
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal

    addteacherBtn.onclick = function () {
        modal.style.display = "block";
        //heading.innerHTML = "Faculty Login";
        facultyForm.style.display = "block";
        //adminForm.style.display = "none";


    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
        //adminForm.style.display = "none";
        facultyForm.style.display = "none";

    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>


<div>
    <br>
    <style>
        table {
            margin-top: 10px;
            font-family: arial, sans-serif;
            border-collapse: collapse;
            margin-left: 30px;
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

    <script>
        function deleteHandlers() {
            var table = document.getElementById("teacherstable");
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
                                window.location.href = "deleteteacher.php?name=" + id;

                            }

                        };
                    };
                currentRow.cells[6].onclick = createDeleteHandler(currentRow);
            }
        }
    </script>

    <table id=teacherstable style="margin-left: 80px">
        <caption><strong>Teacher's Information </strong></caption>
        <tr>
            <th width="130">Faculty No</th>
            <th width=290>Name</th>
            <th width=50>Alias</th>
            <th width="190">Designation</th>
            <th width="190">Contact No.</th>
            <th width="290">Email ID</th>
            <th width="40">Action</th>
        </tr>
        <tbody>
        <?php
        include 'connection.php';
        $q = mysqli_query(mysqli_connect("eu-cdbr-west-01.cleardb.com", "b315615e71a772", "0a9c415c", "heroku_b211df1ac2bee44"),
            "SELECT * FROM teachers ORDER BY faculty_number ASC");

        while ($row = mysqli_fetch_assoc($q)) {
            echo "<tr><td>{$row['faculty_number']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['alias']}</td>
                    <td>{$row['designation']}</td>
                    <td>{$row['contact_number']}</td>
                    <td>{$row['emailid']}</td>
                   <td>
                    <button>Delete</button></td>
                    </tr>\n";
        }
        echo "<script>deleteHandlers();</script>";
        ?>
        </tbody>
    </table>

</div>
<!--HOME SECTION END-->

<!--<div id="footer">
     &copy 2014 yourdomain.com | All Rights Reserved |  <a href="http://binarytheme.com" style="color: #fff" target="_blank">Design by : binarytheme.com</a>
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





