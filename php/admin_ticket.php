<?php
include_once("admin_head.php");
getadmin();
$action=isset($_GET['action'])?$_GET['action']:"list";
switch($action){
	case "insert": 
		$Arr=array();
		if(isset($_GET['id'])&&$_GET['id']){
			$id=intval($_GET['id']);
			$Arr=getone("select * from ticket where id='$id'");
			$Arr=fromTableInForm($Arr);
		}
		?>
		<script>
		function check(){
			if(!$('input[name=title]').val()){alert('标题不能为空');$('input[name=title]').focus();return false;}
		}
		</script>
		<form action='?action=save&id=<?php echo  $id?>' method='post'  onsubmit='return check()' class='myform' enctype='multipart/form-data'  style='width:720px;height:400px;'> 
         <span class='myspan' style='width:80px;'>所属景区：</span><select name='tid'><?php
         $Type=getArr("select * from scenicspot order by sort desc");
         foreach($Type as $new){
             echo "<option value='{$new['id']}' ".select($new['id'],$Arr['tid']).">{$new['title']}</option>";
         }
         ?></select><br />
		 <span class='myspan' style='width:80px;'>景点名称：</span><input name='title' style='width:160px;' value='<?php echo $Arr['title'] ?>'><br>
		 <span class='myspan' style='width:80px;'>简介：</span><textarea name='content' style='width:600px;height:160px;'><?php echo $Arr['content'] ?></textarea><br>
		 <span class='myspan' style='width:80px;'>票价：</span><input name='price' style='width:160px;' value='<?php echo $Arr['price'] ?>'><br>
		 <span class='myspan' style='width:80px;'>上传图片：</span><input type='file' style='width:220px;' id='upload' name='upload'><br>
		 <center><input type='submit' class='submit' value='保存'></center>
		</form>
		<?php
	break;
	
	case "save":
		$_POST=escapeArr($_POST);
		//
		$exname=strtolower(substr($_FILES['upload']['name'],(strrpos($_FILES['upload']['name'],'.')+1)));
		$uploadfile = getname($exname);
		$exetxt=array("jpg","gif","png");
		if (in_array($exname,$exetxt,true)&&$_FILES['upload']['size']>0&&move_uploaded_file($_FILES['upload']['tmp_name'],$uploadfile))
		$_POST['picurl']=$uploadfile;
		if(!$_POST['picurl'])unset($_POST['picurl']); 
		//
 		if(isset($_GET['id'])&&$_GET['id']){
			$id=intval($_GET['id']);
            update("ticket",$_POST," id=$id"); 
		}
		else{
			insert("ticket",$_POST); 
		} 
		alert("操作成功！","?action=list");
	break;
	 
	case "alldel":
		$key=isset($_POST["allidd"])&&$_POST["allidd"]?$_POST["allidd"]:array(intval($_GET['id']));
		for($i=0;$i<count($key);$i++){ 
			if(!$find) query("delete from  ticket  where id={$key[$i]}");
		}
		alert('成功删除'.count($key).'条信息！','?action=list');
	break;
	   
	case "list":
		echo "<form style='padding:0px;margin:0px;' action='?action=list' method='post'>
		<span class='status'>&nbsp;&nbsp;<i>票务管理</i></span> &nbsp;
		<select name='tid'><option value='不限'>景区不限</option>";
		$Type=getArr("select * from scenicspot order by sort desc");
		foreach($Type as $new){
			echo "<option value='{$new['id']}' ".select($_REQUEST['tid'],$new['id']).">{$new['title']}</option>";
		}
		echo"</select> 
		<input type='text' placeholder='请输入标题' value='{$_REQUEST['title']}' name='title'>
		<input type='submit'  value='搜索'>
		<input type='button' onclick=\"location='?action=insert'\" value='发布'> </form>";    
		$fsql=$fpage="";	
		if(isset($_REQUEST['tid'])&&$_REQUEST['tid']!="不限"){
			$fsql.=" and tid ='{$_REQUEST['tid']}'";
			$fpage.="&tid={$_REQUEST['tid']}";
		}
		if(isset($_REQUEST['title'])&&$_REQUEST['title']){
			$fsql.=" and title like '%{$_REQUEST['title']}%'";
			$fpage.="&title={$_REQUEST['title']}";
		}
		$countsql="select count(*) from ticket where 1=1 $fsql";
		$pagesql="select * from ticket where 1=1 $fsql order by id desc";
		$bottom="?action=list{$fpage}";
	 
		$datasql=page($countsql,$pagesql,$bottom,15);
		echo "<form name='delform' id='delform' action='?action=alldel' method='post' class='margin0'>
		<table style='width:98%;' align='center'>";
		if($datasql){
		echo "<tr  bgcolor='#eeeeee' height='30' align='center'><td>景点</td><td>景区</td><td>票价</td><td>图片</td><td>管理</td></tr>";
		while($rs=fetch($datasql[1])){
			$type=getone("select * from scenicspot where id='{$rs['tid']}'");
			echo "<tr height='20' onmouseover=\"this.bgColor = '{$W['tr_color']}'\" onmouseout=\"this.bgColor = ''\">
			  <td align='left'><input   type=checkbox value='{$rs['id']}'  name='allidd[]' id='allidd'>{$rs['title']}</td>	
			  <td align='center'>{$type['title']}</td>	 
			  <td align='center'>{$rs['price']}</td> 
			  <td align='center'><a href='{$rs['picurl']}' target='_blank'><img src='{$rs['picurl']}' style='width:40px;height:30px;border:0px;'></a></td>		 
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