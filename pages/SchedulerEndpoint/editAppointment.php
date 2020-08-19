<?php
include_once "..\\..\\Classes\\DBContext.php";
session_start();
var_dump($_POST);
$db = new DBContext();
if( isset($_POST["EdittedAppointmentTitle"]) && isset($_POST["EdittedAppointmentTime"])) {
    $id = $_POST["EdittedAppointmentID"];
    $title = $_POST["EdittedAppointmentTitle"];
    $time = str_replace("T"," ",$_POST["EdittedAppointmentTime"]);
    $location = "";
    $notes = "";
    if(isset($_POST["EdittedAppointmentLocation"])) $location =  $_POST["EdittedAppointmentLocation"];
    if(isset($_POST["EdittedAppointmentNotes"])) $notes = $_POST["EdittedAppointmentNotes"];
    echo $notes;
    $db->editAppointment(ltrim($id,'A'),$time,$location,$notes,$title);
}
header("Location: ..\\AppointmentsAndDeadlines.php");
return;