<?php
session_start();
require("../Controller/adminController.php");


$uID = $_POST["id"];
removeUser($uID);

header("Location: ./admin.php");
?>