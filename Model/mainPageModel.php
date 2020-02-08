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
    require '../Model/dbConfig.php';
    $stmt = $connection->prepare("SELECT * FROM Emails e JOIN CorrUsers c ON e.corrID=c.corrID WHERE c.uID=?  AND (e.emailID NOT IN (SELECT emailID FROM ReadEmails) OR e.corrID NOT IN (SELECT corrID FROM ReadEmails));");
    $stmt->execute([$uID]);

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

# $users is array of uIDs including the creator
function insertCorr($users, $title) {
    require '../Model/dbConfig.php';
    $stmt = $connection->prepare("INSERT INTO Correspondences(title) VALUES(?)");
    $stmt->execute([$title]);
    $stmt = $connection->prepare("SELECT MAX(corrID) as max FROM Correspondences WHERE title=?");
    $stmt->execute([$title]);
    $corrID = $stmt->fetch(PDO::FETCH_ASSOC)['max'];
    foreach ($users as $uID) {
        $stmt = $connection->prepare("INSERT INTO CorrUsers(corrID, uID) VALUES(?, ?)");
        $stmt->execute([$corrID, $uID]);
    }
}

function belongsUserCorr($uID, $corrID) { //dali user prinadleji na koresp
    require '../Model/dbConfig.php';
    $stmt = $connection->prepare("SELECT COUNT(*) as c FROM CorrUsers WHERE corrID=? AND uID=?");
    $stmt->execute([$corrID, $uID]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result["c"];
}

// print_r(extractUserCorrs(2));
// print_r(extractCorrEmails(1));
// insertEmail(1, 1, "Блокиран", "Вече си блокиран");
// insertCorr([1,2,3], 'NewCorr');
// print_r(extractUnread(3));
?>