<?php
include_once "..\\..\\Classes\\DBContext.php";

    $db = new DBContext();
    echo json_encode($db->getParentsAppointmentData(1));
