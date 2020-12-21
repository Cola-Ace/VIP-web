<?php
    if (!isset($_COOKIE["user"]) || !isset($_COOKIE["pass"])){
        echo "<script>window.location.href = 'login.html';</script>";
        return;
    }
    $user = $_COOKIE["user"];
    $pass = $_COOKIE["pass"];
    include 'db-config.php';
    $host = constant("db-host");
    $port = constant("db-port");
    $conn = new mysqli("{$host}:{$port}", constant("db-user"), constant("db-pass"), constant("db-dbname"));
    if ($conn->connect_error){
        echo "error";
        return;
    }   
    $sql = "SELECT * FROM vip_web_user WHERE user = '". $user ."' AND pass = '". $pass ."'";
    $result = $conn->query($sql);
    if ($result->num_rows <= 0){
        echo "error user";
        return;
    }
    $key = $_POST["key"];
    $day = $_POST["day"];
    $sql = "UPDATE vipCode SET DAYS = '". $day ."' WHERE VIPKEY = '". $key ."'";
    $result = $conn->query($sql);
    if ($result == 1){
        echo "success";
        $conn->close();
        return;
    }
?>