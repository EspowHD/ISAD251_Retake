<?php
include_once "header.php";
    if (!isset($_SESSION["UserID"]))
    {
        header("Location: LogIn.php");
        die();
    }
    if(strpos($_SESSION["UserID"],"C")){
        header("Location: AppointmentsAndDeadlines.php");
    }
?>
<head>
    <title>Add Child To Family</title>
</head>
<link rel="stylesheet" href="CSS/FormPopup.css">
<link rel="stylesheet" href="CSS/RoundedButton.css">
<body>
<?php include "Page Parts/TopBar.php"; ?>
<br>
<h1 align="center" class ="title">Add child to family</h1>
<div class="form-popup" id="addChildForm">
    <form class="form-container" method="POST" action="SchedulerEndpoint/addChild.php">
        <h1 class="title">Add Child</h1>

        <label for="LIId"><b>Child UserID</b></label>
        <input id="LIId" type="text" placeholder="Enter your child's UserID(e.g P9)" name="ChildID" required>

        <input class="btn input" name="Submit" type="submit" value="Add Child">
    </form>
    <script>
        document.getElementById("addChildForm").style.display = "block"
    </script>
</div>
