<?php

function hasUser($username) {
    require("dbConfig.php");
    $stmt = $connection->prepare("SELECT COUNT(*) as c FROM users WHERE username = :username;");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['c'];
}

function extractUserHash($username) {
    require("dbConfig.php");
    $stmt = $connection->prepare("SELECT password FROM users WHERE username = :username;");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['password'];
}

?>

