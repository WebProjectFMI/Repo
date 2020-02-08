<?php
require("../Controller/loginController.php");
session_start();
$username = $_POST["userName"];
$password = $_POST["password"];
$auth = authenticate($username, $password);
if ($auth) {
    $uid = $auth;
    $_SESSION["username"] = $username;
    $_SESSION["uid"] = $uid;
    if (isAdmin($uid)) {
        $_SESSION["admin"] = TRUE;
    }
    header("Location: ./main.php");
} else {
    $_SESSION["error"] = 'Невалидно име или парола';
    header("Location: ./login.php");
}




?>