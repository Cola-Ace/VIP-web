<?php
    include 'db-config.php';
    $host = constant("db-host");
    $port = constant("db-port");
    $conn = new mysqli("{$host}:{$port}", constant("db-user"), constant("db-pass"), constant("db-dbname"));
    if ($conn->connect_error){
        echo "error";
        return;
    }
    $user = $_POST["user"];
    $pass = md5($_POST["pass"]);
    $sql = "SELECT * FROM vip_web_user WHERE user = '". $user ."'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $sql_pass = $row["pass"];
        if ($sql_pass == $pass){
            setcookie("user", $user);
            setcookie("pass", $pass);
            echo "success";
            return;
        } else {
            echo "error";
            return;
        }
    } else {
        echo "error";
        return;
    }
?>