<?php
include_once("head.php");
$action=isset($_GET['action'])?$_GET['action']:"index";
switch($action){
	case "index":
		$fsql=$fpage="";	
		if(isset($_REQUEST['tid'])){
			$tid=intval($_REQUEST['tid']);
			$fsql.=" and tid='$tid'";
			$fpage.="&tid=$tid";
		}
		$countsql="select count(*) from ticket where 1=1 $fsql";
		$pagesql="select * from ticket where 1=1 $fsql order by id desc";
		$bottom="?action=list{$fpage}";
		$datasql=page($countsql,$pagesql,$bottom,15);
		if($datasql){
			while($rs=fetch($datasql[1])){
				$scenicspot=getone("select * from scenicspot where id='{$rs['tid']}'");
				echo "<div class='goods'>
				   <a href='ticket.php?id={$rs['id']}'><img src='{$rs['picurl']}'></a>
				   <div style='line-height:2'>
				   {$scenicspot['title']}<br>
				   {$rs['title']}&nbsp;&nbsp;<span style='color:#ff0000'>￥{$rs['price']}</span>
				   </div>
				  </div>";		  
			}
			echo "<div  style='clear:left;text-align:right'>{$datasql[2]}</div>";
		}
	break;
}
include_once("foot.php");
?>