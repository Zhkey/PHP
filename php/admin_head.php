<?php
session_start();
include_once('include/db.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<link href="img/inc.css?v4" rel="stylesheet" />
<script src="include/jquery-1.3.2.min.js"></script>
<script src="include/function.js"></script>
<body style="background-image:url(); background-color:#fff">
<section class='welcome'> >> 欢迎您，<?php echo $A['username']?"管理员：".$A['username']:"请登录后使用后台"?></section>