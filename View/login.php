<?php 
session_start();
$error = '';
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}
if (isset($_SESSION['uid'])) {
    header("Location: ./main.php");
}

print <<< HTML
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Форма</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
<main>
    <section id="formSection">
        <form id="registrationForm" action = "loginProcessing.php" method="POST">
            <h5>MILfin</h5>
            <fieldset>
                <input name="userName" id="userName" type="text" placeholder="Потребителско име"><br>
                <p id="errorUserName"></p>
                <input name="password" id="password" type="password" placeholder="Парола"><br>
                <p id="errorPassword"></p>
                <input type="submit" id="submit" value="ВЛЕЗ">
            </fieldset>
        </form>
HTML;

if ($error !== '') {
        echo "<p style='color:red'>" . $error . "</p>";
}

print <<< HTML
    </section>
</main>
</body>
</html>

HTML;
?>