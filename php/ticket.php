<?php
include_once("head.php");
$action=isset($_GET['action'])?$_GET['action']:"index";
switch($action){
	case "index":
		$goodsArr=getone("select * from ticket where id=".intval($_GET['id']));
		$goodstypeArr=getone("select * from scenicspot where id='{$goodsArr['tid']}'");
		echo "
		<div style='height:30px;color:#000;margin:10px;'>您的位置：<a href='index.php' class='link2'>首页</a> >
		<a href='index.php?tid=$goodstypeArr[id]' class='link2'>$goodstypeArr[title]</a> > $goodsArr[title]  </div>
		<div style='margin:20px auto;width:800px; '>
		 <div style='width:306px;float:left;border:solid 1px #ccc;'>
		   <img src='{$goodsArr['picurl']}' style='border:solid 3px #fff;width:300px;height:200px;'>
		 </div>
		 <div style='width:450px;float:right;font-weight:bold;line-height:3;color:#000' align='left'>
		   景区名称：{$goodstypeArr['title']}<br>
		   景点名称：{$goodsArr['title']}<br>
		   景点票价：{$goodsArr['price']}<br>
		   订购数量：<input name='num' value=1 style='width:30px;'><br>
		   <input type='button' onclick=\"";
		   if(!$M[id]) echo "alert('请登录后再订票！');";
		   else echo"location='?action=addcart&id={$_GET['id']}&num='+$('input[name=num]').val()";
		   echo"\" value='订购' class='submit'>
		 </div>
		 <div style='clear:both'></div>
		</div>
		<div style='line-height:3;width:800px;margin:20px auto;color:#000' align='left'>
		   <b>商品简介：</b><div style='text-indent:2em'>{$goodsArr['content']}</div>
		</div>";
	break;
	
	case "addcart":
		if(!$M[id])die();
		$id=intval($_GET['id']);
		$num=intval($_GET['num']);
		$search=getone("select * from shoppingcart where gid='$id' and buyname='$M[username]'");//查询购物车里是否有该商品，如果有，加上数量
		
		if($search['id'])query("update shoppingcart set num=num+$num where id=$search[id]");
		else query("insert into  shoppingcart set num=$num,gid='$id',buyname='$M[username]',ptime='".time()."'");//如果没有，写入购物车表
		echo "<script>location='?action=showcart'</script>";
    break;
	
	case "showcart":
		if(!$M[id])die();
		echo "<br><br><b>我的购物车</b>
		<table style='width:800px;' align='center'><tr style='height:30px; background:#FFCC00;font-weight:bold' align='center'><td>商品</td><td>单价</td><td>订购数量</td><td>总价</td><td>管理</td></tr>";
		$query=query("select * from shoppingcart where buyname='$M[username]'");
		$z=0;
		while($row=fetch($query)){
			$ticket=getone("select * from ticket where id='$row[gid]'");
			$scenicspot=getone("select * from scenicspot where id='{$ticket['tid']}'");
			$thisz=$ticket['price']*$row[num];//总价
			echo "<tr  style='height:30px;color:#000'>
			<td align='center'>{$scenicspot['title']}/{$ticket[title]}</td>
			<td align='center'>$ticket[price]</td>
			<td align='center'>$row[num]</td>
			<td align='center'>$thisz</td>
			<td align='center'>
			<input name='change$row[id]' style='width:30px;' value=1> 
			<input type='button' value=' + ' onclick=\"location='?action=change&tag=jia&id=$row[id]&num='+$('input[name=change$row[id]]').val()+'' \"> 
			<input type='button' value=' - ' onclick=\"location='?action=change&tag=jian&id=$row[id]&num='+$('input[name=change$row[id]]').val()+'' \">
			<input type='button' value='删'  onclick=\"location='?action=del&id=$row[id]'\" > 
			</td>
			</tr>";
			$z+=$thisz;
			
		}
		echo "<tr  style='height:30px;'><td colspan=5>总计：$z 元</td>  </tr></table>";
		if($z>0){?>
            <form action='?action=addorders' method='post'>
            <center><input type='submit'  value='提交订单' class='submit'></center>
            </form>
            <?php
		}
    break;
	
	case "del":
		if(!$M[id])die();
		$id=intval($_GET['id']);
		query("delete from shoppingcart where id='$id' and buyname='$M[username]'");
		echo "<script>location='?action=showcart'</script>";
	break;
	
	case "change":
		if(!$M[id])die();
		$id=intval($_GET['id']);
		$num=intval($_GET['num']);
		$tag=$_GET['tag']=='jia'?"+":"-";
		query("update shoppingcart set num=num$tag$num where id='$id' and buyname='$M[username]'");
		echo "<script>location='?action=showcart'</script>";
	break;
	
	case "addorders":
		if(!$M[id])die();
		$_POST=escapeArr($_POST);
		$query=query("select * from shoppingcart where buyname='$M[username]'");
		$array=array();
		while($row=fetch($query)){
			$array[]="$row[gid]:$row[num]";
		}
		$str=implode(",",$array);
		
		$query=query("insert into orders set
		title='".date("YmdHis$M[id]")."',
		gid='{$str}',
		uid='{$M['id']}',
		status=1,
		ptime=".time());
		if($query){
			//更新paymoney
			$insertId=mysql_insert_id();
			$Arr=getone("select * from orders  where id=$insertId and uid='{$M['id']}'"); 
			$goodsArr=explode(",",$Arr['gid']);
			$zongjia=0;
			foreach($goodsArr as $new){
			   $tempArr=explode(":",$new);
			   $ticket=getone("select * from ticket where id={$tempArr[0]}");
			   $zongjia+=$ticket['price']*$tempArr[1];
			}
			query("update orders  set paymoney='$zongjia' where id=$insertId and uid='{$M['id']}'");
			//清空购物车
			query("delete from shoppingcart where buyname='$M[username]'");
			echo"<script>alert('订单提交成功！');parent.location.href='/zq/php/alipay.trade.page.pay-PHP-UTF-8/index.php';</script>";
			
			
		}
    break;

    case "orders_list":
		if(!$M[id])die();
		$countsql="select count(*) from orders where uid='{$M['id']}'";
		$pagesql="select * from  orders where uid='{$M['id']}' order by id desc  ";
		$bottom="?action=orders_list";
		$datasql=page($countsql,$pagesql,$bottom,15);
		echo "
		<table style='width:98%;margin-top:10px;' align='center'>";
		if($datasql){
		echo "<tr  bgcolor='#eeeeee' height='30' align='center'>
		<td>订单编号</td><td>订单详细</td><td>商品总价</td><td>订单总价</td>
		<td>状态</td><td>时间</td></tr>";	
		while($rs=fetch($datasql[1])){     
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
			 
			 echo "<tr height='20' onmouseover=\"this.bgColor = '{$W['tr_color']}'\" onmouseout=\"this.bgColor = ''\" style='color:#000'>
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
			  </tr>";
		}
		echo "<tr><td colspan=8 align='right'>
					 <div style='width:280px;float:left'></div>
					 <div  style='float:right'>{$datasql[2]}</div>
					 <div style='clear:both;'></div>
			  </td></tr>";
		}
		echo "</table>";
    break;
}
include_once("foot.php");
?>
