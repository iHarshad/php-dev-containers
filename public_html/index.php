<?php

$host = getenv('DB_HOST') ?: 'mysqldb';
$dbname = getenv('DB_NAME') ?: 'example_pass';
$user = getenv('DB_USER') ?: 'example_user';
$password = getenv('DB_PASS') ?: 'example_pass';

function testMySQLiConnection($host, $user, $password) {
    $mysqliResult = '';

    if (class_exists('mysqli')) {
        $mysqli = new mysqli($host, $user, $password);

        if ($mysqli->connect_error) {
            $mysqliResult = "MySQLi Connection Failed: " . $mysqli->connect_error;
        } else {
            $mysqliResult = "MySQLi Connection Successful!<br><br>";
            $databases = $mysqli->query("SHOW DATABASES");

            if ($databases->num_rows > 0) {
                $mysqliResult .= "Databases found with MySQLi:<br><ul>";
                while ($row = $databases->fetch_assoc()) {
                    $mysqliResult .= "<li>" . $row['Database'] . "</li>";
                }
                $mysqliResult .= "</ul>";
            } else {
                $mysqliResult .= "No databases found using MySQLi.";
            }
        }
    } else {
        $mysqliResult = "MySQLi extension not available.";
    }

    return $mysqliResult;
}

function testPDOConnection($host, $user, $password) {
    $pdoResult = '';

    try {
        $pdo = new PDO("mysql:host=$host;", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $pdoResult = "PDO Connection Successful!<br><br>";
        $databases = $pdo->query("SHOW DATABASES");

        if ($databases->rowCount() > 0) {
            $pdoResult .= "Databases found with PDO:<br><ul>";
            while ($row = $databases->fetch(PDO::FETCH_ASSOC)) {
                $pdoResult .= "<li>" . $row['Database'] . "</li>";
            }
            $pdoResult .= "</ul>";
        } else {
            $pdoResult .= "No databases found using PDO.";
        }
    } catch (PDOException $e) {
        $pdoResult = "PDO Connection Failed: " . $e->getMessage();
    }

    return $pdoResult;
}

$mysqliResult = testMySQLiConnection($host, $user, $password);
$pdoResult = testPDOConnection($host, $user, $password);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Database Connectivity Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 2%;
        }
    </style>
</head>
<body>
    <h1>Database Connectivity Test</h1>
    <h2>MySQLi</h2>
    <p><?php echo $mysqliResult; ?></p>
    <h2>PDO</h2>
    <p><?php echo $pdoResult; ?></p>
    <br>
    <?php phpinfo(); ?>
</body>
</html>
