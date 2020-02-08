<?php

function getUsers() {
    require("../Model/adminModel.php");
    $users = extractUsers();
    return $users;
}

function removeUser($uid) {
    require("../Model/adminModel.php");
    require("../Model/loginModel.php");
    if (hasUserById($uid)) {
        echo "asdsaasda";
        deleteUser($uid);
    }  
}

function resetPassword($uid) {
    require("../Model/adminModel.php");
    $username = extractUsername($uid);
    $hashedNewPassword = hash("sha256", $username);
    updatePassword($uid, $hashedNewPassword);
}

resetPassword(3);

?>