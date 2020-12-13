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
    $steamid = $_POST["steamid"];
    $sql = "SELECT * FROM vipUsers";
    $result = $conn->query($sql);
    $sql = "DELETE FROM vipUsers WHERE authId='". $steamid ."'";
    $del_result = $conn->query($sql);
    $sql = "SELECT * FROM vipUsers";
    $sel_result = $conn->query($sql);
    $result_count = $result->num_rows;
    $sel_count = $sel_result->num_rows;
    if ($result_count > $sel_count){
        echo "success";
        return;
    }
    echo "error";
    $conn->close();
?>