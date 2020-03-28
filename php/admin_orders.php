<?php
include_once("admin_head.php");
getadmin();
$action=$_GET['action'];
switch($action){
	case "edit":
		$id=intval($_GET['id']);
		$Arr=getone("select * from orders where id=$id");
		$Arr=fromTableInForm($Arr);
		?>
		<script>
		function check(){
			if(!$('input[name=paymoney]').val()){alert('订单价格不能为空');$('input[name=paymoney]').focus();return false;}
		 }
		</script>
		<form style='width:420px;height:230px;' action='?action=save&id=<?php echo $id?>' method='post'  onsubmit='return check()' class='myform' enctype='multipart/form-data' >
		 <span class='myspan' style='width:80px;'>订单价格：</span><input name='paymoney' style='width:60px;' value='<?php  echo $Arr['paymoney']?$Arr['paymoney']:$zongjia; ?>'><br>
		 <span class='myspan' style='width:80px;'>订单状态：</span><select name='status'>
		 <option value='4' <?php echo select($Arr['status'],4)?>>已取票</option>
		 <option value='3' <?php echo select($Arr['status'],3)?>>已支付</option>
		 <option value='2' <?php echo select($Arr['status'],2)?>>支付失败</option>
		 <option value='1' <?php echo select($Arr['status'],1)?>>未支付</option>
		 </select> <br />
		 <center><input type='submit' value='编辑' class='submit'></center>
         </form>
		<?php
	break;
	
	case "save":
		$_POST=escapeArr($_POST);
		$id=intval($_GET['id']);
		if(isset($_POST['paymoney'])&&update("orders",$_POST,"id=$id"))
		alert("编辑成功！","?action=list");
	break;
	
	case "alldel":
		$key=isset($_POST["allidd"])?$_POST["allidd"]:array($_GET['id']);
		for($i=0;$i<count($key);$i++){
			query("delete from orders where id={$key[$i]}"); 
		}
		alert("成功删除".count($key)."条信息！","?action=list");
	break;
	
	case "list":
		echo "<form style='padding:0px;margin:0px;' action='?action=list' method='post'>
		<span class='status'>&nbsp;&nbsp;<i>订单管理</i></span>&nbsp;&nbsp;&nbsp;&nbsp;
		会员名：<input name='s_username' value='{$_REQUEST['s_username']}'>
		订单状态：<select name='status' style='padding:0px;margin:0px;'>
		<option>不限</option>
		<option value='4' ".select($_REQUEST['status'],"4").">已取票</option>
		<option value='3' ".select($_REQUEST['status'],"3").">已支付</option>
		<option value='2' ".select($_REQUEST['status'],"2").">支付失败</option>
		<option value='1' ".select($_REQUEST['status'],"1").">未支付</option>
		</select>
		<input type='submit' value='搜索'>  </form>";   
		$fsql="";$fpage="";  
		if(isset($_REQUEST['s_username'])&&$_REQUEST['s_username']){
			$member=getone("select * from member where username='{$_REQUEST['s_username']}'");
			$fsql.=" and uid='{$member['id']}'";
			$fpage.="&s_username={$_REQUEST['s_username']}";			
		}
		if(isset($_REQUEST['status'])&&$_REQUEST['status']!=='不限'){
			$fsql.=" and status='{$_REQUEST['status']}'";
			$fpage.="&status={$_REQUEST['status']}";
		}
		$countsql="select count(*) from orders where 1=1 $fsql";
		$pagesql="select * from  orders where 1=1 $fsql order by id desc  ";
		$bottom="?action=list{$fpage}";
		$datasql=page($countsql,$pagesql,$bottom,15);
		echo "<form name='delform' id='delform' action='?action=alldel' method='post' class='margin0'>
		<table style='width:98%;' align='center'>";
		if($datasql){
		echo "<tr  bgcolor='#eeeeee' height='30' align='center'>
		<td style='width:10px'></td>
		<td>会员</td>
		<td>订单编号</td><td>订单详细</td><td>票面总价</td><td>订单总价</td><td>状态</td>
		<td>时间</td><td>管理</td></tr>";	
		while($rs=fetch($datasql[1])){
		  $member=getone("select * from member where id='{$rs['uid']}'");
		  $goodsArr=explode(",",$rs['gid']);
		  $retrunStr="";
		  $zongjia=0;
		  foreach($goodsArr as $new){
			 $tempArr=explode(":",$new);
			 $ticket=getone("select * from ticket where id={$tempArr[0]}");
			 $scenicspot=getone("select * from scenicspot where id='{$ticket['tid']}'");
			 $retrunStr.="{$scenicspot['title']}/{$ticket['title']},单价：{$ticket['price']},数量：{$tempArr[1]},小计：";
			 $retrunStr.=$ticket['price']*$tempArr[1];
			 $retrunStr.="元<br>";
			 $zongjia+=$ticket['price']*$tempArr[1];
		  }
		  
		  echo "<tr height='20' onmouseover=\"this.bgColor = '{$W['tr_color']}'\" onmouseout=\"this.bgColor = ''\">
			  <td><input   type=checkbox value='{$rs['id']}'  name='allidd[]' id='allidd'></td>
			  <td align='center'>{$member['username']}</td>
			  <td align='center'>{$rs['title']}</td>
			  <td align='left'>{$retrunStr}</td>
			  <td align='center'>{$zongjia}</td>
			  <td align='center'>{$rs['paymoney']}</td>
			  <td align='center'>";
			  switch($rs['status']){
				  case "1":echo "未支付";break;
				  case "2":echo "支付失败";break;
				  case "3":echo "已支付";break;
				  case "4":echo "已取票";break;
			  }
			  echo"</td>
			  <td align='center'>".date("Y-m-d H:i:s",$rs['ptime'])."</td>
			  <td align='center'>		  
			  <a href='?action=edit&id={$rs['id']}'>编辑</a>  &nbsp; &nbsp;
			  <a href='javascript:ask(\"?action=delete&id={$rs['id']}\")'>删除</a>  &nbsp; &nbsp; 
			  </td>
			  </tr>";
		}
		echo "<tr><td colspan=11 align='right'>
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