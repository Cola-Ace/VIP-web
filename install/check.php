<?php
    $host = $_POST["url"];
    $port = $_POST["port"];
    $user = $_POST["user"];
    $pass = $_POST["pass"];
    $db = $_POST["db"];
    $conn = new mysqli("{$host}:{$port}", $user, $pass, $db);
    if ($conn->connect_error){
        echo "error";
    } else {
        $file = fopen("../db-config.php", "w");
        $text = "<?php\n";
        fwrite($file, $text);
        $text = "define('db-host', '". $host ."');\n";
        fwrite($file, $text);
        $text = "define('db-port', '". $port ."');\n";
        fwrite($file, $text);
        $text = "define('db-user', '". $user ."');\n";
        fwrite($file, $text);
        $text = "define('db-pass', '". $pass ."');\n";
        fwrite($file, $text);
        $text = "define('db-dbname', '". $db ."');\n";
        fwrite($file, $text);
        $text = "?>";
        fwrite($file, $text);
        fclose($file);
        echo "success";
    }
?>