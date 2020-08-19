<?php
include_once "..\\..\\Classes\\DBContext.php";
session_start();
var_dump($_POST);
$db = new DBContext();
$data = $db->getLoginData($_POST["loginUserID"]);
var_dump($data);
if($data != null) {
    var_dump($data);
    $_SESSION["UserID"] = $_POST["loginUserID"];
    $_SESSION["FirstName"] = $data["FirstName"];
    $_SESSION["LastName"] = $data["LastName"];
    header("Location: ..\\AppointmentsAndDeadlines.php");
} else {
echo "<script> window.onload = function () {window.alert(\"Your ID is incorrect\")} </script>";
    header("..\\Location: LogIn.php");
}
return;
