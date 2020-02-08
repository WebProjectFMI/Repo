<?php
require("../Model/loginModel.php");

function authenticate($username, $password) {
    if (hasUser($username)) {
        $userHash = extractUserHash($username);
        if (hash("sha256", $password) === $userHash) {
            return TRUE;
        }
    }   
    return FALSE;
}
?>