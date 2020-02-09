<?php
require '../Model/mainPageModel.php';

function getUserCorrs($uID) {
    return extractUserCorrs($uID);
}

function getCorrEmails($corrID, $uID) {
    if (belongsUserCorr($uID, $corrID)) {
        return extractCorrEmails($corrID, $uID);
    }
    return [];
}

function sendEmail($corrID, $fromUID, $subject, $content) {
    if ((is_int($corrID) || ctype_digit($corrID)) && belongsUserCorr($fromUID, $corrID)) {
        insertEmail($corrID, $fromUID, $subject, $content);
    }
}
function getUnread($uID) {
    return extractUnread($uID);
}

function createCorr($title, $usernames) {
    $ids = getUserIdsByUsernames($usernames);
    insertCorr($ids, $title);
}
?>