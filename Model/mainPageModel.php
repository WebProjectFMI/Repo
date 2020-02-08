<?php

function extractUserCorrs($uID) {
    require '../Model/dbConfig.php';
    $stmt = $connection->prepare("SELECT * FROM Correspondences JOIN CorrUsers ON Correspondences.corrID=CorrUsers.corrID WHERE CorrUsers.uid=?");
    $stmt->execute([$uID]);

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function extractCorrEmails($corrID) {
    require '../Model/dbConfig.php';
    $stmt = $connection->prepare("SELECT * FROM Emails WHERE corrID=?");
    $stmt->execute([$corrID]);

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function insertEmail($corrID, $fromUID, $subject, $content) {
    require '../Model/dbConfig.php';
    $stmt = $connection->prepare("INSERT INTO Emails(corrID, fromUID, subject, content) VALUES(?,?,?,?)");
    $stmt->execute([$corrID, $fromUID, $subject, $content]);
}

function extractUnread($uID) {
    
}

//  print_r(extractUserCorrs(2));
// print_r(extractCorrEmails(1));
//insertEmail(1, 1, "Блокиран", "Вече си блокиран");
?>