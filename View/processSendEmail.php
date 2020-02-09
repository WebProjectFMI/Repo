<?php
require '../Controller/mainPageController.php';
session_start();
$uid = $_SESSION['uid'];

$emailID = sendEmail($_POST['corrID'], $uid, $_POST['subject'], $_POST['content']);
$corrID = $_POST['corrID'];
if (isset($_FILES['file']['size']) && $_FILES['file']['size'] > 0) {
    $targetdir = "../attachments/$corrID/" . $emailID;   
    mkdir($targetdir , 0775, true);
    $targetfile = $targetdir . '/' . $_FILES['file']['name'];
 
    move_uploaded_file($_FILES['file']['tmp_name'], $targetfile);
}

header("Location: ./main.php");
?>