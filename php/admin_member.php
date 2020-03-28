<?php
include_once("admin_head.php");
getadmin();
$action=isset($_GET['action'])?$_GET['action']:"list";
switch($action){
case "insert":
	$Arr=array();
	if(isset($_GET['id'])&&$_GET['id']){
		$id=intval($_GET['id']);
		$Arr=getone("select * from member where id='$id'");
		$Arr=fromTableInForm($Arr);
	}
	?>
	<script>
	function check(){
		if(!$('input[name=username]').val()){alert('用户名不能为空');$('input[name=username]').focus();return false;}
		<?php if(!$id) {?>
		if(!$('input[name=password]').val()){alert('密码不能为空');$('input[name=password]').focus();return false;}
		<?php }?>
		if(!$('input[name=realname]').val()){alert('真实姓名不能为空');$('input[name=realname]').focus();return false;}
	}
	</script>
	<form action='?action=save&id=<?php echo $id?>' method='post'  onsubmit='return check()' class='myform' style='width:420px;height:230px;'>
	<span class="myspan" style="width:70px;">用户名：</span><input name='username' style='width:160px;' value='<?php echo $Arr['username'];?>'><br>
	<span class="myspan" style="width:70px;">登录密码：</span><input name='password' type='password' style='width:160px;'><br> 
	<span class="myspan" style="width:70px;">真实姓名：</span><input name='realname' style='width:160px;' value='<?php echo $Arr['realname'];?>'><br>
	<span class="myspan" style="width:70px;">年龄：</span><input name='age' style='width:160px;' value='<?php echo $Arr['age'];?>'><br>
	<span class="myspan" style="width:70px;">性别：</span><select name='gender' style='width:160px;'><option>男</option><option <?php echo select("女",$Arr['gender']) ?>>女</option></select><br> 
	<center><input type='submit' value='保存' class='submit'></center>
    </form> 
	<?php
break;

case "save":
	$_POST=escapeArr($_POST);
	if($_POST['password']){$_POST['password']=md5($_POST['password']);}
	else unset($_POST['password']);	
	if(isset($_GET['id'])&&$_GET['id']){
		$id=intval($_GET['id']);
		$find=getone("select id from member where username='{$_POST['username']}' and id!=$id");
		if($find['id'])alert("该用户已存在","?action=list");
		update("member",$_POST,"id={$id}");	
	}
	else {
		$find=getone("select id from member where username='{$_POST['username']}'");
		if($find['id'])alert("该用户已存在","?action=add");
		insert("member",$_POST);
	} 
	if(isset($_POST['username']))
	alert("操作成功！","?action=list");
	else die($query);
break;

 
case "alldel":
    $key=isset($_POST["allidd"])&&$_POST["allidd"]?$_POST["allidd"]:array(intval($_GET['id']));
    for($i=0;$i<count($key);$i++){
        mysql_query("delete from member where id={$key[$i]}"); 	    
    }
    alert("成功删除".count($key)."条信息！","?action=list");
break;


case "list":
	echo "<form style='padding:0px;margin:0px;' action='?action=list' method='post'>
	<span class='status'>&nbsp;&nbsp;<i>会员管理</i></span>&nbsp;&nbsp;&nbsp;&nbsp;用户名：<input name='username' value='{$_REQUEST['username']}' style='padding:0px;margin:0px;'>
	<input type='submit' value='搜索'> <input type='button' onclick=\"location='?action=insert'\" value='新增'> </form>";   
	$fsql="";$fpage="";
	if(isset($_REQUEST['username'])&&$_REQUEST['username']){
	   $fsql.=" and username like '%{$_REQUEST['username']}%'";
	   $fpage="&username={$_REQUEST['username']}";
	}
	
	$countsql="select count(*) from  member where 1=1 $fsql";
	$pagesql="select * from  member where 1=1 $fsql order by id desc  ";
	$bottom="?action=list{$fpage}";
	$datasql=page($countsql,$pagesql,$bottom,15);
	echo "<form name='delform' id='delform' action='?action=alldel' method='post' class='margin0'>
	<table style='width:98%;' align='center'>";
	if($datasql){
	echo "<tr  bgcolor='#eeeeee' height='30' align='center'><td>账号</td><td>姓名</td><td>年龄</td><td>性别</td><td>管理</td></tr>";
	while($rs=fetch($datasql[1])){   
		echo "<tr height='20' onmouseover=\"this.bgColor = '{$W['tr_color']}'\" onmouseout=\"this.bgColor = ''\">
		  <td align='left'><input   type=checkbox value='{$rs['id']}'  name='allidd[]' id='allidd'>{$rs['username']}</td>
		  <td align='center'>{$rs['realname']}</td>
		  <td align='center'>{$rs['age']}</td>
		  <td align='center'>{$rs['gender']}</td>
		  <td align='center'>		  
		  <a href='?action=insert&id={$rs['id']}'>编辑</a>  &nbsp; &nbsp;
		  <a href='javascript:ask(\"?action=alldel&id={$rs['id']}\")'>删除</a>
		  </td>
		  </tr>";
	}
	echo "<tr><td colspan=6 align='right'>
				 <div style='width:280px;float:left'>{$datasql['pl']}{$datasql['pldelete']}</div>
				 <div  style='float:right'>{$datasql[2]}</div>
				 <div style='clear:both;'></div>
		  </td></tr>";
	}
	echo "</table></form>";
break;
}
include_once("admin_foot.php");
?>