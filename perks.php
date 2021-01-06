<!DOCTYPE HTML>
<html>
<head>
    <meta charset = "UTF-8">
    <title>VIP管理系统-用户配置</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.css">
    <script src = "https://cdn.jsdelivr.net/npm/sweetalert"></script>
    <link rel = "icon" href = "image/favicon.ico">
    <style>
        body {
            margin:0 auto;
            width:800px;
            height:700px;
        }
    </style>
</head>
<body>
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
    $sql = "SELECT * FROM vipPerks";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        function Color($str){
            if ($str == "{red}"){
                return "红色";
            } else if ($str == "{purple}"){
                return "紫色";
            } else if ($str == "{pink}"){
                return "粉色";
            } else if ($str == "{light_green}"){
                return "亮绿色";
            } else if ($str == "{dark_red}"){
                return "暗红色";
            } else if ($str == "rgb"){
                return "RGB";
            }
        }
        echo "<table class = 'table table-striped table-bordered'><thead><tr><th>SteamID</th><th>聊天前缀</th><th>进服提示</th><th>前缀颜色</th><th>名字颜色</th></th><th>聊天颜色</th><th></th></tr></thead><tbody style = 'font-size:23px;'>";
        while ($row = $result->fetch_assoc()){
            echo "<tr><td>". $row["authId"] ."</td><td>" . $row["chatTag"] . "</td><td>". $row["joinMsg"] ."</td><td>". Color($row["tagColor"]) ."</td><td>". Color($row["nameColor"]) ."</td><td>". Color($row["chatColor"]) ."</td><td><button class = 'btn btn-primary' id = '". $row["authId"] ."'><i class = 'fa fa-times'></i> 删除</button></td></tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "数据库中没有用户配置哦~";
        return;
    }
?>
</body>
<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    $(function(){
        $("button").click(function(){
            $authid = $(this).attr("id");
            $(this).html("<span id = 'icon' class = 'fa fa-spinner fa-spin'></span> 正在删除...");
            $("button").attr("disabled", "disabled");
            $.post("del-perks.php", {
                steamid:$authid
            }, function(data, status){
                if (status != "success"){
                    swal("错误", "发送请求失败", "error");
                    $("button").removeAttr("disabled");
                    $(this).html("<i class = 'fa fa-times'></i> 删除");
                    return;
                }
                if (data != "success"){
                    swal("错误", "删除失败", "error");
                    $("button").removeAttr("disabled");
                    $(this).html("<i class = 'fa fa-times'></i> 删除");
                    return;
                }
                swal("成功", "删除成功", "success").then((value) => {
                    window.location.reload();
                })
            });
        });
    });
</script>
</html>