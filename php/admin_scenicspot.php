<?php
include_once("admin_head.php");
getadmin();
$action=isset($_GET['action'])?$_GET['action']:"list";
switch($action){
	case "insert": 
		$Arr=array();
		if(isset($_GET['id'])&&$_GET['id']){
			$id=intval($_GET['id']);
			$Arr=getone("select * from scenicspot where id='$id'");
			$Arr=fromTableInForm($Arr);
		}
		?>
		<script>
		function check(){
			if(!$('input[name=title]').val()){alert('名称不能为空');$('input[name=title]').focus();return false;}
		}
		</script>
		<form action='?action=save&id=<?php echo  $id?>' method='post'  onsubmit='return check()' class='myform'  style='width:720px;height:230px;'> 
		 <span class='myspan' style='width:80px;'>名称：</span><input name='title' style='width:160px;' value='<?php echo $Arr['title'] ?>'><br>
		 <span class='myspan' style='width:80px;'>序号：</span><input name='sort' style='width:160px;' value='<?php echo $Arr['sort'] ?>'><br>
		 <center><input type='submit' class='submit' value='保存'></center>
		</form>
		<?php
	break;
	
	case "save":
		$_POST=escapeArr($_POST);
		$baseQuery="title='{$_POST['title']}',sort='{$_POST['sort']}'";
		if(isset($_GET['id'])&&$_GET['id']){
			$id=intval($_GET['id']);
			$query="update scenicspot set  $baseQuery   where id={$id}";
		}
		else{
			$query="insert into scenicspot set $baseQuery";
		} 
		if(isset($_POST['title'])&&query($query))
		alert("操作成功！","?action=list");
		else die($query);
	break;
	 
	case "alldel":
		$key=isset($_POST["allidd"])&&$_POST["allidd"]?$_POST["allidd"]:array(intval($_GET['id']));
		for($i=0;$i<count($key);$i++){ 
			query("delete from scenicspot  where id={$key[$i]}");
		}
		alert('成功删除'.count($key).'条信息！','?action=list');
	break;
	   
	case "list":
		echo "<form style='padding:0px;margin:0px;' action='?action=list' method='post'>
		<span class='status'>&nbsp;&nbsp;<i>景区管理</i></span> 
		<input type='button' onclick=\"location='?action=insert'\" value='新增'></form>";       
		$countsql="select count(*) from  scenicspot";
		$pagesql="select * from scenicspot order by sort desc,id desc";
		$bottom="?action=list";
		$datasql=page($countsql,$pagesql,$bottom,15);
		echo "<form name='delform' id='delform' action='?action=alldel' method='post' class='margin0'>
		<table style='width:98%;' align='center'>";
		if($datasql){
			echo "<tr  bgcolor='#eeeeee' height='30' align='center'><td>景区名称</td><td>序号</td><td>管理</td></tr>";
			while($rs=fetch($datasql[1])){
				echo "<tr height='30' onmouseover=\"this.bgColor = '{$W['tr_color']}'\" onmouseout=\"this.bgColor = ''\">
				  <td align='left'><input   type=checkbox value='{$rs['id']}'  name='allidd[]' id='allidd'>{$rs['title']}</td>
				  <td align='center'>{$rs['sort']}</td>
				  <td align='center'>	 
				  <a href='?action=insert&id={$rs['id']}'>编辑</a>  &nbsp; &nbsp;
				  <a href='javascript:ask(\"?action=alldel&id={$rs['id']}\")'>删除</a>
				  </td>
				  </tr>";		  
			}
			echo "<tr><td colspan=5 align='right'>
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