<!DOCTYPE HTML>
<html>
<head>
    <meta charset = "UTF-8">
    <title>VIP管理系统-主页</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.css">
    <link rel = "icon" href = "image/favicon.ico">
    <style>
        body {
            margin:0 auto;
            width:700px;
            height:700px;
        }
    </style>
</head>
<?php
    if (!file_exists("db-config.php")){
        echo "<script>window.location.href = 'install/index.html';</script>";
        return;
    }
    if (file_exists("install")){
        echo "请先将目录下的install文件重命名后再访问网页";
        return;
    }
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
?>
<body>
    <button onclick = "window.location.href='key.php'" class = "btn btn-primary btn-lg btn-block">卡密管理</button><br>
    <button onclick = "window.location.href='users.php'" class = "btn btn-primary btn-lg btn-block">VIP用户管理</button><br>
    <button onclick = "window.location.href='perks.php'" class = "btn btn-primary btn-lg btn-block">VIP用户配置管理</button><br>
    <button onclick = "window.location.href='add-users.html'" class = "btn btn-primary btn-lg btn-block">网页用户添加</button><br>
    <button onclick = "window.location.href='add-key.html'" class = "btn btn-primary btn-lg btn-block">添加随机卡密</button><br>
    <button onclick = "window.location.href='add-keys.html'" class = "btn btn-primary btn-lg btn-block">批量添加随机卡密</button>
</body>
<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</html>