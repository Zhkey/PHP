<?php
session_start();
include_once('include/db.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<link href="img/inc.css?v4" rel="stylesheet" />
<title>诸暨旅游Zhuji Travel</title>
<script src="include/jquery-1.3.2.min.js"></script>
<script src="include/function.js"></script>
<script>
/*显示子菜单*/
function showmt(div){
	$('#bodyleft').find("div").hide();
	$('#bodyleft').find("div[id="+div+"]").toggle(300);
	setCookie("acmenu",div,600);
}
$().ready(function(){
	with(document.documentElement) {
		bodywidth=(scrollWidth>clientWidth)?scrollWidth:clientWidth;
		bodyheight= clientHeight;
	}
	var bodyleft=200;var bodytop=120;
	var bodyright=bodywidth-bodyleft;
	var bodyheight=bodyheight-bodytop;
	//1、定义顶部高度
	$('.bodytop').css({'height':bodytop+'px'});
	//2、定义左侧菜单宽度和高度 
	$('#bodyleft').css({'width':bodyleft+'px'});
	$('#bodyleft').css({'height':bodyheight+'px'});
	//3、定义右侧层的高度和宽度
	$('#bodyright').css({'width':bodyright+'px'});
	$('#bodyright').css({'height':bodyheight+'px'});
	//4、定义iframe框架的高度和宽度
	$("#mainframe").css({'width':bodyright+'px'});
	$("#mainframe").css({'height':bodyheight+'px'});
	//5、显示默认的菜单
	$('#bodyleft').find("div").hide();
	var acmenu=getCookie("acmenu");
	if(acmenu==null){
		  $('#bodyleft').find("div[id=mt1]").toggle(300);
	}
	else  $('#bodyleft').find("div[id="+acmenu+"]").toggle(300);
})
</script>
</head>
<body style="overflow:hidden;background-image:url(); background-color:#fff">
<header class='bodytop'><div>诸暨旅游Zhuji Travel</div></header>
<nav class='bodyleft' id='bodyleft'>
    <span class='mt' onClick="showmt('mt1')">快捷通道</span>
    <div id='mt1'>
        <span class='md'>▶ &nbsp; <a href='index.php' target="_blank">前台首页</a></span><br />
        <span class='md'>▶ &nbsp; <a href="javascript:if(confirm('您真的要退出吗？')) window.open('admin_login.php?action=logout','mainframe')">退出登录</a></span><br />
    </div>
    
    <span class='mt' onClick="showmt('mt2')">系统管理</span>
    <div id='mt2'>
        <span class='md'>▶ &nbsp; <a href='admin_user.php?action=insert' target="mainframe">新增管理员</a></span><br />
        <span class='md'>▶ &nbsp; <a href='admin_user.php?action=list' target="mainframe">管理员列表</a></span><br />
    </div>
    
    <span class='mt' onClick="showmt('mt3')">会员管理</span>
    <div id='mt3'>
        <span class='md'>▶ &nbsp; <a href='admin_member.php?action=insert' target="mainframe">注册会员</a></span><br />
        <span class='md'>▶ &nbsp; <a href='admin_member.php?action=list' target="mainframe">会员列表</a></span><br />
    </div>   
    
    <span class='mt' onClick="showmt('mt4')">票务管理</span>
    <div id='mt4'>
        <span class='md'>▶ &nbsp; <a href='admin_scenicspot.php?action=list' target="mainframe">景区管理</a></span><br />
        <span class='md'>▶ &nbsp; <a href='admin_ticket.php?action=list' target="mainframe">票务管理</a></span><br />
        <span class='md'>▶ &nbsp; <a href='admin_orders.php?action=list' target="mainframe">订单管理</a></span><br />  
    </div>
</nav>

<section align="left" id='bodyright' class="bodyright">
    <iframe id='mainframe' class='mainframe' name='mainframe'  frameborder="0" scrolling="yes" src="admin_login.php"></iframe>
</section>
</body>
</html>
<?php mysql_close($conn);?>