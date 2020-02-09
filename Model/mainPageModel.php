<?php

function extractUserCorrs($uID) {
    require '../Model/dbConfig.php';
    $stmt = $connection->prepare("SELECT * FROM Correspondences JOIN CorrUsers ON Correspondences.corrID=CorrUsers.corrID WHERE CorrUsers.uid=? ORDER BY Correspondences.datetimeLast DESC");
    $stmt->execute([$uID]);

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function extractCorrEmails($corrID, $uID) {
    require '../Model/dbConfig.php';
    $stmt = $connection->prepare("SELECT * FROM Emails e JOIN CorrUsers c ON e.corrID=c.corrID AND c.corrID =? WHERE c.uID=?  AND e.emailID NOT IN (SELECT emailID FROM ReadEmails as re WHERE re.corrID=e.corrID AND re.uID=?);");
    $stmt->execute([$corrID, $uID, $uID]);

    $toBeRead = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($toBeRead as $email){
        $stmt = $connection->prepare("INSERT INTO ReadEmails(corrID, emailID, uID) VALUES(?, ?, ?)");
        $stmt->execute([$corrID, $email['emailID'], $uID]);
    }

    $stmt = $connection->prepare("SELECT * FROM Emails as e 
        JOIN Users as u ON e.fromUID=u.uID 
        JOIN CorrUsers as cu on e.fromUID=cu.uID AND cu.corrID=e.corrID
        WHERE e.corrID=? ORDER BY e.emailID DESC");
    $stmt->execute([$corrID]);

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function insertEmail($corrID, $fromUID, $subject, $content) {
    require '../Model/dbConfig.php';
    $stmt = $connection->prepare("INSERT INTO Emails(corrID, fromUID, subject, content) VALUES(?,?,?,?)");
    $stmt->execute([$corrID, $fromUID, $subject, $content]);
    $stmt = $connection->prepare("UPDATE Correspondences SET datetimeLast=NOW() WHERE corrID=?");
    $stmt->execute([$corrID]);
    $stmt = $connection->prepare("SELECT max(emailID) as m FROM Emails WHERE subject=? AND fromUID=? AND corrID=?");
    $stmt->execute([$subject, $fromUID, $corrID]);
    $lastEmail = $stmt->fetch(PDO::FETCH_ASSOC);
    return $lastEmail['m'];
}

function extractUnread($uID) {
    require '../Model/dbConfig.php';
    $stmt = $connection->prepare("SELECT * FROM Emails e JOIN CorrUsers c ON e.corrID=c.corrID WHERE c.uID=?  AND e.emailID NOT IN (SELECT emailID FROM ReadEmails as re WHERE re.corrID=e.corrID AND re.uID=?);");
    $stmt->execute([$uID, $uID]);

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

function belongsUserCorr($uID, $corrID) {
    require '../Model/dbConfig.php';
    $stmt = $connection->prepare("SELECT COUNT(*) as c FROM CorrUsers WHERE corrID=? AND uID=?");
    $stmt->execute([$corrID, $uID]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result["c"];
}

function getUserIdsByUsernames($usernames) {
    require '../Model/dbConfig.php';
    $usernames = explode(',', $usernames);
    $names = "";
    foreach ($usernames as $username) {
        $names = $names ."'" . trim($username) . "'" .  ',';
    }
    $names = substr($names, 0, -1);

    $stmt = $connection->prepare("SELECT uid FROM Users WHERE username IN ($names);");
    $stmt->execute();
    $ids = [];
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($results as $result) {
        array_push($ids, $result['uid']);
    }
    return $ids;
}
?>