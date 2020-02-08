<?php
require("../Model/adminModel.php");
require("../Model/loginModel.php");

function getUsers() {
    $users = extractUsers();
    return $users;
}

function removeUser($uid) {
    if (hasUserById($uid)) {
        deleteUser($uid);
    }  
}

function resetPassword($uid) {
    $username = extractUsername($uid);
    $hashedNewPassword = hash("sha256", $username);
    updatePassword($uid, $hashedNewPassword);
}
?>