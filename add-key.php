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
    $days = $_POST["day"];
    $sql = "SELECT * FROM vipCode";
    $result = $conn->query($sql);
    $sel_count = $result->num_rows;
    $key = md5(uniqid("", true));
    $sql = "INSERT INTO vipCode (VIPKEY, DAYS) VALUES ('". $key ."', '". $days ."')";
    $conn->query($sql);
    $sql = "SELECT * FROM vipCode";
    $result = $conn->query($sql);
    $ins_count = $result->num_rows;
    if ($ins_count <= $sel_count){
        echo "error";
        return;
    }
    echo "[Status]success[StatusEnd][Data]". $key ."[DataEnd][Day]". $days ."[DayEnd]";
    $conn->close();
?>