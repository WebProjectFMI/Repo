<?php
require '../Controller/mainPageController.php';
session_start();
$uid = $_SESSION['uid'];

if (isset($_FILES['file']['size']) && $_FILES['file']['size'] > 0) {
    // $targetdir = '../attachments/';   
    // mkdir('path/to/directory', 0775, true);
    // // name of the directory where the files should be stored
    // $targetfile = $targetdir.$_FILES['file']['name'];

    // if (move_uploaded_file($_FILES['file']['tmp_name'], $targetfile))
}

sendEmail($_POST['corrID'], $uid, $_POST['subject'], $_POST['content']);
header("Location: ./main.php");
?>