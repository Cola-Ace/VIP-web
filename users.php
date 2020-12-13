<!DOCTYPE HTML>
<html>
<head>
    <meta charset = "UTF-8">
    <title>VIP管理系统-用户</title>
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
    //验证用户是否已登录
    if (!isset($_COOKIE["user"]) || !isset($_COOKIE["pass"])){
        echo "<script>window.location.href = 'login.html';</script>";
        return;
    }
    //验证用户是否存在及密码是否正确
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
    $sql = "SELECT * FROM vipUsers";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        echo "<table class = 'table table-striped table-bordered'><thead><tr><th>SteamID</th><th>到期时间</th><th></th></tr></thead><tbody style = 'font-size:23px;'>";
        while ($row = $result->fetch_assoc()){
            $time = date("Y-m-d", $row["expireStamp"]);
            echo "<tr><td>". $row["authId"] ."</td><td>" . $time . "</td><td><button class = 'btn btn-primary' id = '". $row["authId"] ."'><i class = 'fa fa-times'></i> 删除</button></td></tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "未检测到VIP用户的存在哦~";
    }
?>
<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    $(function(){
        $("button").click(function(){
            $authid = $(this).attr("id");
            $.post("del-users.php", {
                steamid:$authid
            }, function(data, status){
                if (status != "success"){
                    alert("发送请求失败，请联系管理员");
                    return;
                }
                if (data != "success"){
                    alert("删除用户失败~");
                    return;
                }
                alert("删除成功~");
                window.location.reload();
            });
        });
    });
</script>