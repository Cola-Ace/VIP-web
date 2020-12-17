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
    $sql = "SELECT * FROM vipCode";
    $result = $conn->query($sql);
    $sel_result = $result->num_rows;
    $sql = "DELETE FROM vipCode WHERE VIPKEY='". $key ."'";
    $result = $conn->query($sql);
    $sql = "SELECT * FROM vipCode";
    $result = $conn->query($sql);
    $del_result = $result->num_rows;
    if ($del_result < $sel_result){
        echo "success";
        $conn->close();
        return;
    }
    echo "error";
    $conn->close();
?>