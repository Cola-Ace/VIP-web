<!DOCTYPE HTML>
<html>
<head>
    <meta charset = "UTF-8">
    <title>VIP管理系统-卡密</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.css">
    <link rel = "icon" href = "image/favicon.ico">
    <style>
        body {
            margin:0 auto;
            width:800px;
            height:700px;
        }
    </style>
</head>
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
    $sql = "SELECT * FROM vipCode";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        echo "<table class = 'table table-striped table-bordered'><thead><tr><th>VIP卡密</th><th>天数</th><th></th></tr></thead><tbody style = 'font-size:23px;'>";
        while ($row = $result->fetch_assoc()){
            echo "<tr><td>". $row["VIPKEY"] ."</td><td id = 'days'>" . $row["DAYS"] . "</td><td><button id = 'del' class = 'btn btn-primary' id = '". $row["VIPKEY"] ."'><i class = 'fa fa-times'></i> 删除</button></td></tr>";//<button type = 'button' class = 'btn btn-success' id = 'save'><i class = 'fa fa-check-square'></i> 保存更改</button>
        }
    } else {
        echo "数据库中没有VIP卡密哦~";
        return;
    }
?>
<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    $(function(){
        $("#save").hide();
        $("#del").click(function(){
            $keys = $(this).attr("id");
            $.post("del-keys.php", {
                key:$keys
            }, function(data, status){
                if (status != "success"){
                    alert("发送请求失败，请联系管理员");
                    return;
                }
                if (data != "success"){
                    alert("删除失败~");
                    return;
                }
                alert("删除成功~");
                window.location.reload();
            });
        });
        /*
        $("#days").click(function(){
            $(this).next("#save").show();
            $(this).attr("id", "edit");
            $(this).html("<form role = 'form'><div class = 'form-group'><input class = 'form-control' id = 'day' value = '" + $(this).val + "'></div></form>");
        });
        $("#save").click(function(){
            var day = $(this).prev("#edit").val;
        });*/
    });
</script>