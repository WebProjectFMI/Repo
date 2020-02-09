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
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<main>
    <header>
    <div>
        <form action="./main.php">
        <button type="submit"> Върни се </button>
        </form>
    </div>
    <h1>Администраторки панел</h1>
    </header>
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
                <button type='submit' $disabled>Изтрий</button>
                </form>

                <form action='./processReset.php' method='post'>
                <input type='hidden' name='id' value=${uID} />
                <button $disabled>Нулирай парола</button>
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