<?php
/*
管理员登录退出逻辑
*/
include_once("admin_head.php");
$action=isset($_GET['action'])?$_GET['action']:"login";
switch($action){
	case "login"://登录表单
		if(isset($_SESSION['adminname'])&&$_SESSION['adminname'])echo "<script>location='admin_user.php?action=list'</script>";
		?>
		<script>
		function check(){
			if(!$('input[name=username]').val()){alert('用户名不能为空');$('input[name=username]').focus();return false;}
			if(!$('input[name=password]').val()){alert('密码不能为空');$('input[name=password]').focus();return false;}
		}
		</script>
		<div style="width:500px; height:300px;margin:100px auto;" align="center">&nbsp;&nbsp;
		<span class='status' style='font-size:20px;'><i>管理员登陆</i></span>&nbsp;&nbsp;&nbsp;&nbsp;
		<form class='myform' action='?action=logingo' method='post' onsubmit='return check()' >
		<span class='myspan px60'>用户名：</span><input name='username' style='width:150px;'><br><br>
		<span class='myspan px60'>密码：</span><input name='password' type='password' style='width:150px;'><br><br>
		<input type='submit' value='登录' class='submit'></form>
		</div>
		<?php
	break;
	  
	  
	case "logingo"://执行登录
		$_POST=escapeArr($_POST);
		$checkKey=array("username"=>"管理员账号@{clear;cut:255}");
		$row=getone("select * from user where username='{$_POST['username']}' and password='".md5($_POST['password'])."'");
		if($row['id']){
		   $_SESSION['adminname']=$row['username'];
		   $_SESSION['adminpassword']=$row['password'];	  
		   echo "<script>location='admin_user.php'</script>"; 
		   die();
		}
		else {
		   alert('账号错误','?action=login');
		}
		break;
		
		
	case "logout"://退出登录
		$_SESSION['adminname']="";
		$_SESSION['adminpassword']="";
		unset($_SESSION['adminname'],$_SESSION['adminpassword']);
		echo "<script>location='?action=login'</script>";
		break;
}
include_once("admin_foot.php");
?>
