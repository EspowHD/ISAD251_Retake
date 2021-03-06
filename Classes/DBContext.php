<?php

class DBContext
{
    private string $servername = "socem1.uopnet.plymouth.ac.uk";
    private string $username = "FDavies";
    private string $password = "ISAD251_22215869";
    private string $dbname = "ISAD251_FDavies";

    private $connection;

    public function __construct()
    {
        $connectionInfo = array( "Database"=>$this->dbname, "UID"=>$this->username, "PWD"=>$this->password);
        $this->connection = sqlsrv_connect( $this->servername, $connectionInfo);

        if( !($this->connection) ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }

    public function getParentsDeadLineData($ParentID)//Done
    {
        $result = sqlsrv_query($this->connection,
            "EXECUTE [dbo].[get_Parents_Child_Info] @ParentIDIn = ?",
            array($ParentID));
        if ($result === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        $output = array();
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $output[] = array(
                'id' => "D" . $row["ID"],
                'title' => $row["Title"],
                'child' => $row["Child"],
                'time' => date_format($row["Time"], "Y-m-d H:i:s"),
                'description' => $row["Description"],
                'completed' => $row["Completed"]
            );
        }
        return $output;
    }
    public function getParentsAppointmentData($ParentID)//Done
    {
        $result=sqlsrv_query($this->connection,
            "EXECUTE [dbo].[get_Parent_Appointment_Info] @ParentIDIn = ?",
            array($ParentID));
        if($result === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        $output = array();
        while($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC))
        {
            $output[] = array(
                'id' => "A".$row["ID"],
                'title' => $row["Title"],
                'time' => date_format($row["Time"],"Y-m-d H:i:s"),
                'location' => $row["Location"],
                'notes' => $row["Notes"],
            );
        }
        return $output;
    }

    public function getChildsAppointmentInfo($ChildID)//Done
    {
        $result=sqlsrv_query($this->connection,
            "EXECUTE [dbo].[get_Childs_Parent_Info] @ChildIDIn = ?",
            array($ChildID));
        if($result === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        $output = array();
        while($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC))
        {
            $output[] = array(
                'id' => "A".$row["ID"],
                'title' => $row["Title"],
                'time' => date_format($row["Time"],"Y-m-d H:i:s"),
                'location' => $row["Location"],
                'notes' => $row["Notes"],
            );
        }
        return $output;
    }

    public function getChildsDeadlineInfo($ChildID)//Done
    {
        $result=sqlsrv_query($this->connection,
            "EXECUTE [dbo].[get_Childs_Deadline_Info] @ChildIDIn = ?",
            array($ChildID));
        if($result === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        $output = array();
        while($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC))
        {
            $output[] = array(
                'id' => "D" . $row["ID"],
                'title' => $row["Title"],
                'time' => date_format($row["Time"], "Y-m-d H:i:s"),
                'description' => $row["Description"],
                'completed' => $row["Completed"]
            );
        }
        return $output;
    }

    public function insertNewAppointment($ParentID,$Time,$Location,$Notes,$Title)
    {
        $stmt = sqlsrv_prepare($this->connection,
            "EXECUTE  [dbo].[insert_Appointment] 
                @ParentIDIn = ?
                ,@AppointmentTimeIn = ?
                ,@AppointmentLocationIn = ?
                ,@NotesIn = ?
                ,@AppointmentTitleIn = ?",
            array($ParentID,$Time,$Location,$Notes,$Title));
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }
    public function insertNewDeadline($ChildID,$Title,$Time,$Description,$Completed){
        $stmt = sqlsrv_prepare($this->connection,
            "EXECUTE [dbo].[insert_Deadline] 
               @ChildIDIn = ?
              ,@DeadlineTitleIn = ?
              ,@DeadlineTimeIn = ?
              ,@DeadlineDescriptionIn = ?
              ,@DeadlineCompletedIn = ?",
            array($ChildID,$Title,$Time,$Description,$Completed));
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }

    public function editAppointment($AppointmentID,$Time,$Location,$Notes,$Title){
        $stmt = sqlsrv_prepare($this->connection,
            "EXECUTE [dbo].[edit_Appointment] 
               @AppointmentIDIn = ?
              ,@AppointmentTitleIn = ?
              ,@AppointmentTimeIn = ?
              ,@AppointmentLocationIn = ?
              ,@NotesIn = ?",
            array($AppointmentID,$Title,$Time,$Location,$Notes));
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }

    public function editDeadline($DeadlineID,$Title,$Time,$Description,$Completed){
        $stmt = sqlsrv_prepare($this->connection,
            "EXECUTE [dbo].[edit_Deadline] 
               @DeadlineIDIn = ?
              ,@DeadlineTitleIn = ?
              ,@DeadlineTimeIn = ?
              ,@DeadlineDescriptionIn = ?
              ,@DeadlineCompletedIn = ?",
            array($DeadlineID,$Title,$Time,$Description,$Completed));
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }

    public function deleteAppointment($AppointmentID){
        $stmt = sqlsrv_prepare($this->connection,
            "EXECUTE [dbo].[delete_Appointment] 
               @AppointmentIDIn = ?",
            array($AppointmentID));
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }

    public function deleteDeadline($DeadlineID){
        $stmt = sqlsrv_prepare($this->connection,
            "EXECUTE [dbo].[delete_Deadline] 
               @DeadlineIDIn = ?",
            array($DeadlineID));
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }

    public function getLoginData($ID){
        if(strpos($ID, "P") !== false){
            $stmt = sqlsrv_query($this->connection,
                "EXECUTE [dbo].[get_Parent_Login] 
               @ParentIDIn = ?",
                array(ltrim($ID, 'P')));
        } else{
            $stmt = sqlsrv_query($this->connection,
                "EXECUTE [dbo].[get_Child_Login] 
               @ChildIDIn = ?",
                array(ltrim($ID, 'C')));
        }
        if($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        return sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC);
    }

    public function insertParentToChild($ParentID,$ChildID){
        $stmt = sqlsrv_prepare($this->connection,
            "EXECUTE [dbo].[insert_Parent_To_Child] 
               @ParentIDIn = ?,
               @ChildIDIn = ?",
                array($ParentID,$ChildID));
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }
    public function lastParentId() {
        $stmt = sqlsrv_query($this->connection,"EXECUTE [dbo].[get_last_ParentID]");
        if($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        return sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC);
    }

    public function lastChildId() {
        $stmt = sqlsrv_query($this->connection,"EXECUTE [dbo].[get_last_ChildID]");
        if($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        return sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC);
    }

    public function insertNewParent($PFname,$PLname){
        $stmt = sqlsrv_prepare($this->connection,
            "EXECUTE [dbo].[insert_Parent] 
                @FirstNameIn = ?,
                @LastNameIn = ?",
            array($PFname,$PLname));
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }

    public function insertNewChild($CFname,$CLname){
        $stmt = sqlsrv_prepare($this->connection,
            "EXECUTE [dbo].[insert_Child] 
                @FirstNameIn = ?,
                @LastNameIn = ?",
            array($CFname,$CLname));
        if( sqlsrv_execute( $stmt ) === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }
}