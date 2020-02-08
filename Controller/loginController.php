<?php

function autenticate($username, $password) {
    require("../Model/loginModel.php");
    if (hasUser($username)) {
        $userHash = extractUserHash($username);
        if (hash("sha256", $password) === $userHash) {
            return TRUE;
        }
    }   
    return FALSE;
}
?>