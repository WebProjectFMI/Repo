<?php
session_start();
require("../Controller/adminController.php");


$uID = $_POST["id"];
resetPassword($uID);

header("Location: ./admin.php");
?>