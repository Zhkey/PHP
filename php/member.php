<?php
include_once("head.php");
$action=isset($_GET['action'])?$_GET['action']:"Login";
switch($action){
	case "Login":
		?>
		<script>
		function check(){
			if(!$('input[name=username]').val()){alert('用户名不能为空');$('input[name=username]').focus();return false;}
			if(!$('input[name=password]').val()){alert('密码不能为空');$('input[name=password]').focus();return false;}
		}
		</script>
		<div style='margin:100px auto;width:300px;' align='left'>
		<span class='status' style='font-size:20px;'>&nbsp;&nbsp;<i>会员登录</i></span>&nbsp;&nbsp;&nbsp;&nbsp;
		<form class='myform' action='?action=LoginGo' method='post' onsubmit='return check()' style='width:250px;'>
		<span class='myspan' style='width:70px;'>用户名：</span><input name='username' style='width:150px;'><br><br>
		<span class='myspan' style='width:70px;'>密码：</span><input name='password' type='password' style='width:150px;'><br><br>
		<center> <input type='submit' value='登录' class='submit'> <input  onclick="location='?action=Reg'"  type='button' value='注册' class='submit'></center>
		</form>
		</div>
		<?php
	break;
	
	case "LoginGo":
		$_POST=escapeArr($_POST);
		$row=getone("select * from member where username='{$_POST['username']}' and password='".md5($_POST['password'])."'");
		if($row['id']){
			$_SESSION['membername']=$row['username'];
			$_SESSION['memberpassword']=$row['password'];	  
			echo "<script>location='index.php'</script>";
		}
		else {alert('用户名或密码错误','index.php');}	
	break;
	
	case "Reg":
		?>
		<script>
		function check(){
			if(!$('input[name=username]').val()){alert('用户名不能为空');$('input[name=username]').focus();return false;}
			if(!$('input[name=realname]').val()){alert('姓名不能为空');$('input[name=realname]').focus();return false;}
			if(!$('input[name=age]').val()){alert('年龄不能为空');$('input[name=age]').focus();return false;}
			<?php if(!$M['id']) {?>
			if(!$('input[name=password]').val()){alert('密码不能为空');$('input[name=password]').focus();return false;}
			<?php }?>
		}
		</script>
		<div style='width:430px;margin:20px auto;' align='left'>
		<span class='status' style='font-size:20px;'>&nbsp;&nbsp;<i>会员<?php echo $M['id']?"编辑":"注册"; ?></i></span>&nbsp;&nbsp;&nbsp;&nbsp;
		 <form class='myform' action='?action=Save' method='post' onsubmit='return check()' enctype='multipart/form-data'>
		 <span class='myspan' style='width:70px;'>用户名：</span><input name='username'   style='width:150px;' value='<?php echo $M['username'] ?>'><br><br>
		 <span class='myspan' style='width:70px;'>密码：</span><input name='password' type='password' style='width:150px;'><br><br>
		 <span class='myspan' style='width:70px;'>姓名：</span><input name='realname'   style='width:150px;' value='<?php echo $M['realname'] ?>'><br><br>
		 <span class='myspan' style='width:70px;'>年龄：</span><input name='age'   style='width:150px;' value='<?php echo $M['age'] ?>'><br><br>
		 <span class='myspan' style='width:70px;'>性别：</span><select name='gender'   style='width:150px;'><option>男</option><option <?php echo select('女',$M['gender']) ?>>女</option></select><br><br>
		 <span class='myspan' style='width:70px;'>上传头像：</span><input type='file' style='width:220px;' id='upload' name='upload'><br>		
		 <center> <input type='submit' value='注册' class='submit'></center>
		 </form>
		</div>
		<?php
	break;
	
	case "Save":
		$_POST=escapeArr($_POST);
		//
		$exname=strtolower(substr($_FILES['upload']['name'],(strrpos($_FILES['upload']['name'],'.')+1)));
		$uploadfile = getname($exname);
		$exetxt=array("jpg","gif","png");
		if(in_array($exname,$exetxt,true)&&$_FILES['upload']['size']>0&&move_uploaded_file($_FILES['upload']['tmp_name'],$uploadfile))
		$_POST['picurl']=$uploadfile; 
		// 
		if($_POST['password']) $_POST['password']=md5($_POST['password']);else unset($_POST['password']);
		if(!$_POST['picurl'])unset($_POST['picurl']); 
		 
		if($M['id']) {
		    $find=getone("select id from member where username='{$_POST['username']}' and id!={$M['id']}");
		    if($find['id']){
		        alert("该用户已存在，请重新填写","?action=Reg");
			    die();    
		    }
		    update("member",$_POST," id={$M['id']}");
		}
		else{
		    $find=getone("select id from member where username='{$_POST['username']}'");
		    if($find['id']){
			    alert("该用户已存在，请重新填写","?action=Reg");
			    die();    
		    }
		    insert("member",$_POST," id={$M['id']}");
		}

		if($_POST['username']){
			if($M['id']) alert('编辑成功','index.php');
			else         alert('注册成功！请登录...','index.php');
		}
	break;
	
	case "Logout":
		$_SESSION['membername']="";
		$_SESSION['memberpassword']="";
		unset($_SESSION['membername'],$_SESSION['memberpassword']);
		echo "<script>location='index.php'</script>";
	break;
}
include_once("foot.php");
?>