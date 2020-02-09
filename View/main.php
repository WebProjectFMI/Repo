<?php
require '../Controller/mainPageController.php';

session_start();
if (!isset($_SESSION['uid'])) {
    header("Location: ./login.php");
}
$uID = $_SESSION['uid'];
$username = $_SESSION['username'];
$unreadEmails = getUnread($uID);
$numUnreadEmails = count($unreadEmails);

$unreadCorrs = [];
foreach ($unreadEmails as $unreadEmail) {
    if (!in_array($unreadEmail['corrID'], $unreadCorrs)) {
        array_push($unreadCorrs, $unreadEmail['corrID']);
    }
}

$corrs = getUserCorrs($uID);

print <<< HTML
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>MILfin ($numUnreadEmails)</title>

    <script src="main.js"></script>
</head>
<body>
    <header class="header">
        <div>$username</div>
HTML;

if (isset($_SESSION['admin']) && $_SESSION['admin']) {
    echo "<form action='./admin.php' method='post'>
    <button>Администрирай</button>
    </form>";
}

print <<< HTML
    <form action='./processLogout.php' method='post'>
        <button>Излез</button>
    </form>
    </header>
    <div id="addCorr">
        <button type="button" onclick="alert('Нова кореспонденция')">Нова кореспонденция</button>
    </div>
    <div id='navMain'>
    <nav>
        <ul>
HTML;

foreach ($corrs as $corr) {
    $corrID = $corr['corrID'];
    $corrTitle = $corr['title'];
    $isUnread = '';
    if (in_array($corrID, $unreadCorrs)) {
        $isUnread = 'unread';
    }
    echo "<li class='corr $isUnread' id='$corrID'>
            <form id='form$corrID' method='post' action='./main.php'>
            <input type='hidden' name='corrID' value='$corrID'>
            <input type='hidden' name='title' value='$corrTitle'>
            </form>
            <div onclick=\"document.getElementById('form$corrID').submit();\">$corrTitle</div>
        </li>";
}

$corrID = 0;
$corrTitle = '';
if (!isset($_POST['corrID'])) {
    if (count($corrs) > 0) {
        $corrID = $corrs[0]['corrID'];
        $corrTitle = $corrs[0]['title'];
    }
}
else {
    $corrID = $_POST['corrID'];
    $corrTitle = $_POST['title'];
}

$emails = [];
if ($corrID) {
    $emails = getCorrEmails($corrID, $uID);
}

print <<< HTML
        </ul>
    </nav>
    <main>
        <h2>$corrTitle</h2>
HTML;

if ($corrID) {
    echo "<div class='email sent'>
            <form method='post' enctype='multipart/form-data' action='./processSendEmail.php'>
                <input type='hidden' name='corrID' value='${corrID}'>
                <input type='text' name='subject' placeholder='Тема' class='formSubject' required/>
                <textarea rows='17' name='content' cols='60' placeholder='Съдържание'></textarea>
                <div>
                    <input type='file' name='file'/>
                    <input type='submit' value='Изпрати'/>
                </div>
            <form>
        </div>";
}

foreach($emails as $email) {
    $emailSubject = $email['subject'];
    $emailContent = $email['content'];
    $emailDatetime = $email['datetime'];
    $from = $email['username'];
    if($email['fromUID'] == $uID) {
        echo "<div class=\"email sent\">
                <pre class='subject'>$emailSubject</pre>
                <pre class='content'>$emailContent</pre>
                <div class='emailSmallInfo'>
                    <div>$emailDatetime</div>
                    <div>$from</div>
                </div>
            </div>";
    }
    else {
        if ($email['isAnonymous']) {
            $from = 'Anonymous';
        }
        echo "<div class=\"email received\">
                <pre class='subject'>$emailSubject</pre>
                <pre class='content'>$emailContent</pre>
                <div class='emailSmallInfo'>
                    <div>$emailDatetime</div>
                    <div>$from</div>
                </div>
            </div>";
    }
}

print <<< HTML
    </main>
    </div>
</body>
</html>
HTML;
?>