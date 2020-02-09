<?php
session_start();
require("../Controller/mainPageController.php");

$subject = $_POST ["subjectCorr"];
$usernames = $_POST["usersCorr"];

$creatorUsername = $_SESSION['username'];
$usernames = $usernames . ', ' . $creatorUsername;

createCorr($subject, $usernames);
header("Location: ./main.php")




?>