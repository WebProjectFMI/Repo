<?php
require '../Controller/adminController.php';
session_start();
if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header("Location: ./login.php");
}

$users = getUsers();

print <<< HTML
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
            content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Форма</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<main>
    <h1>Admin panel</h1>
HTML;
foreach ($users as $user) {
    $username = $user['username'];
    $facID = $user['facID'];
    $uID = $user['uid'];
    $disabled = '';
    if ($user['isDeleted'] == 1) {
        $disabled = 'disabled';
    }
    $adminStyle = '';
    if ($user['admin']) {
        $adminStyle = 'style="color:#7acf05"';
    }

    echo "<div class='userLine'>
            <div $adminStyle>${username} ${facID}</div>
            <div>
                <form action='./processDelete.php' method='post'>
                <input type='hidden' name='id' value=${uID} />
                <button type='submit' $disabled>Delete</button>
                </form>

                <form action='./processReset.php' method='post'>
                <input type='hidden' name='id' value=${uID} />
                <button $disabled>Reset password</button>
                </form>
            </div>
        </div>";
}

print <<< HTML
</main>
</body>
</html>
    
HTML;

?>