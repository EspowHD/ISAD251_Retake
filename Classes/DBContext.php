<?php

class DBContext
{
    private $servername = "socem1.uopnet.plymouth.ac.uk";
    private $username = "FDavies";
    private $password = "ISAD251_22215869";
    private $dbname = "ISAD251_FDavies";

    private $connection;

    public function __construct()
    {
        $this->connection=mssql_connect($this->servername,$this->username,$this->password,$this->dbname);

        if ($this->connection->connect_error) {
            die("Database connection failed: " . $this->connection->connect_error);
        }
    }
}