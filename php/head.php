<?php
session_start();
include_once('include/db.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<link href="img/inc.css?v2"  rel="stylesheet" />
<title>诸暨旅游Zhuji Travel</title>
<script src="include/jquery-1.3.2.min.js"></script>
<script src="include/function.js"></script>
</head>
<body>
<div style="width:100%;height:40px; background-color:#fff">
<nav class='menu'> 
<?php
if($M['id']){
   echo "尊敬的会员 {$M['username']} 您好，您可以：
   <a href='index.php'  class='member'>返回首页</a>  |  
   <a href='member.php?action=Logout' class='member'>退出登录</a>  |  
   <a href='member.php?action=Reg' class='member'>编辑账号</a>  |  
   <a href='ticket.php?action=showcart' class='member'>购物车</a>  |  
   <a href='ticket.php?action=orders_list' class='member'>我的订单</a>  | 
   
   <a href='admin.php' class='member'>管理后台</a>  |  &nbsp;";
}
else {
   ?>
   尊敬的访客您好，您可以：
    <a href='index.php' class='guest'>首页</a>  |   
    <a href='member.php?action=Reg' class='guest'>注册</a>  | 
    <a href='member.php?action=Login' class='guest'>登录</a>  |
    <a href='admin.php' class='guest'>管理后台</a>  | &nbsp;
   <?php
}
?>
</nav>
</div> 

<header class='top'><div class='logo'></div></header>
<div class='goodstype'><span style="margin-left:0px;"><a href='index.php'>网站首页</a></span>
<?php
$Type=getArr("select * from scenicspot order by sort desc");
foreach($Type as $new){
   echo "<span><a href='index.php?tid={$new['id']}'>{$new['title']}</a></span>";
}
?>
 
</div>
<section class='main'>

