<?php
include_once "..\\..\\Classes\\DBContext.php";
session_start();
$db = new DBContext();
if(strpos($_SESSION["UserID"], 'P') !== false) echo json_encode($db->getParentsAppointmentData(ltrim($_SESSION["UserID"],'P')));
else echo json_encode($db->getChildsAppointmentInfo(ltrim($_SESSION["UserID"],'C')));
