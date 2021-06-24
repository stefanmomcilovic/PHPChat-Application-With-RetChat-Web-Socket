<?php
ob_start(); // Turn on output buffering
session_start(); // Session start
date_default_timezone_set("Europe/Belgrade"); // Set Default Time Zone For Website

class DB{
    public $error_array = array();
    public $con;

    private $dbname = "chat_websockets_learning"; // Database Name
    private $host = "localhost"; // Host
    private $username = "root"; // Database Login username
    private $password = ""; // Database Login Password

    function __construct()
    {
        // Connection with PDO
        try {
            $this->con = new PDO("mysql:dbname=" . $this->dbname . ";host=" . $this->host . ";", $this->username, $this->password);
            $this->con->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->con;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}