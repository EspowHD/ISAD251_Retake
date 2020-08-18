<?php
include_once "..\\..\\Classes\\DBContext.php";
session_start();
$db = new DBContext();
if(strpos($_SESSION["UserID"], 'P') !== false) echo json_encode($db->getParentsDeadLineData(ltrim($_SESSION["UserID"],'P')));
else echo json_encode($db->getChildsDeadlineInfo(ltrim($_SESSION["UserID"],'C')));