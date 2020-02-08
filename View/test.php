<!DOCTYPE html>
<html>
<head>
<title>Example</title>
</head>
<body>

<?php

require '../model/dbConfig.php';
echo "<h2>Hi, I'm a PHP script!</h2>";

    $sql = "SELECT username FROM Users;";   
    echo "<br/>";
    $query = $connection->query($sql) or die("failed!");
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    echo $row['username'];
    echo "<br/>"; 
}
?>
</body>
</html>