<!DOCTYPE HTML>
<html>
<head>
    <meta charset = "UTF-8">
    <title>VIP管理系统-卡密</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.css">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
            $key = $row["VIPKEY"];
            echo "<tr><td id = 'key'>". $key ."</td><td id = 'days'><button onclick = \"setModal('". $key ."')\" data-toggle='modal' id = 'day' class = 'btn btn-primary' data-target = '#modal'>" . $row["DAYS"] . "</button></td><td><button id = 'del' class = 'btn btn-primary' id = '". $row["VIPKEY"] ."'><i class = 'fa fa-times'></i> 删除</button></td></tr>";
        }
    } else {
        echo "数据库中没有VIP卡密哦~";
        return;
    }
?>
<!-- 模态框（Modal） -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel" value = ""></h4>
			</div>
			<div class="modal-body">
				<form role = "form">
                    <div class = "form-group">
                        <input type = "text" class = "form-control" placeholder = "请输入新的天数" id = "newDays">
                    </div>
                </form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				<button type="button" class="btn btn-primary" id = "submitDays">提交更改</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>
<script>
    function setModal(str){
        $("#myModalLabel").val(str);
        $("#myModalLabel").text("卡密：" + str);
    }
    $(function(){
        $("#submitDays").click(function(){
            var g_day = $("#newDays").val();
            if (g_day <= 0){
                swal("错误", "天数填写错误", "error");
                return;
            }
            $(this).attr("disabled", "disabled");
            $(this).html("<span id = 'icon' class = 'fa fa-spinner fa-spin'></span> 正在更改...")
            var g_key = $("#myModalLabel").val();
            $.post("change-days.php", {
                key:g_key,
                day:g_day
            }, function(data, status){
                if (status != "success"){
                    swal("错误", "发送请求失败", "error");
                    $(this).removeAttr("disabled");
                    $(this).text("提交更改");
                    return;
                }
                if (data != "success"){
                    swal("错误", "更改失败", "error");
                    $(this).removeAttr("disabled");
                    $(this).text("提交更改");
                    return;
                }
                swal("成功", "更改成功", "success");
                window.location.reload();
            });
        });
        $("#save").hide();
        $("#del").click(function(){
            $keys = $(this).attr("id");
            $.post("del-keys.php", {
                key:$keys
            }, function(data, status){
                if (status != "success"){
                    swal("错误", "发送请求失败", "error");
                    return;
                }
                if (data != "success"){
                    swal("错误", "删除失败", "error");
                    return;
                }
                swal("成功", "删除成功", "success").then((value) => {
                    window.location.reload();
                });
            });
        });
    });
</script>