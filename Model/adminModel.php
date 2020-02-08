<?php

function extractUsers() {
    require("dbConfig.php");
    $stmt = $connection->prepare("SELECT uid, username, facID, admin, isDeleted FROM Users;");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function deleteUser($uID) {
    require("dbConfig.php");
    $stmt = $connection->prepare("UPDATE Users SET isDeleted = 1 WHERE uid = :uid;");
    $stmt->bindParam(':uid', $uID);
    $stmt->execute();
}

function updatePassword($uID, $hash) {
    require("dbConfig.php");
    $stmt = $connection->prepare("UPDATE Users SET password = :pass WHERE uid = :uid;");
    $stmt->bindParam(':uid', $uID);
    $stmt->bindParam(':pass', $hash);
    $stmt->execute();
}

function extractUsername($uID) {
    require("dbConfig.php");
    $stmt = $connection->prepare("SELECT username FROM  Users WHERE uid = :uid;");
    $stmt->bindParam(':uid', $uID);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['username'];
}


?>