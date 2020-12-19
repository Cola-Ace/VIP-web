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
    $user = $_POST["user"];
    $sql = "SELECT * FROM vip_web_user WHERE user = '". $user ."'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        echo "has same user";
        return;
    }
    $nickname = $_POST["nickname"];
    $sql = "SELECT * FROM vip_web_user WHERE nickname = '". $nickname ."'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        echo "has same nickname";
        return;
    }
    $pass = md5($_POST["pass"]);
    $sql = "SELECT * FROM vip_web_user";
    $result = $conn->query($sql);
    $sel_count = $result->num_rows;
    $sql = "INSERT INTO vip_web_user (user, pass, nickname) VALUES ('". $user ."', '". $pass ."', '". $nickname ."')";
    $result = $conn->query($sql);
    $sql = "SELECT * FROM vip_web_user";
    $result = $conn->query($sql);
    $ins_count = $result->num_rows;
    if ($ins_count <= $sel_count){
        echo "error";
        $conn->close();
        return;
    }
    echo "success";
    $conn->close();
?>