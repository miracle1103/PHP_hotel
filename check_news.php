<?php 
include_once 'conn.php';
$lb=$_POST["lb"];
$name=$_GET['name'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>酒店优惠资讯列表</title>
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css" />
<link rel="stylesheet" href="css/custom.css" />
<link rel="stylesheet" href="css/demo_add.css" />
<link rel="stylesheet" href="css/font-awesome.min.css" />
<link rel="stylesheet" href="css/style.css" />
</head>

<body class="news_list_body">
<!--酒店优惠资讯列表-->
<div class="check_news_list">
	<div class="clearfix admin_con_top">
    	<h2 class="fl">已有酒店优惠资讯列表</h2>
        <?php 
			$sql="select * from xinwentongzhi where 1=1";
			$query=mysql_query($sql);
			$rowscount=mysql_num_rows($query);
		?>
        <p class="fr">共<span><?php echo $rowscount;?></span>条记录</p>
    </div>
    <div class="clearfix">
    	<p class=" all_del" id="all_del" onclick="deleteSelected()">批量删除</p>
        <form id="form1" name="form1" method="get" action="" class="fr">
            <input type="submit" name="Submit" value="查找" class="fr"/>
            <input type='text' style='display:none'> <!-- 针对firefox -->
            <input name="name" type="text" id="name" placeholder="搜索标题..." class="fr" autocomplete="off" value="<?php echo $name;?>"/>
        </form>
    </div>
    <div class="admin_news_list">
            <?php
                  $sql="select * from xinwentongzhi where 1=1";
				  if ($name!=""){
						$sql=$sql." and name like '%$name%'";
					}
				  if($lb!=""){
					  $sql=$sql." and cls='$lb'";
					  }
  					$sql=$sql." order by id desc";
					$query=mysql_query($sql);
 					$rowscount=mysql_num_rows($query);
				  if($rowscount==0)
				  {
					  ?>
                    <div class="date_null">抱歉，您的查询结果为空</div>
					<?php
					}
				  else
				  {
				  $pagelarge=10;//每页行数；
				  $pagecurrent=$_GET["pagecurrent"];
				  if($rowscount%$pagelarge==0)
				  {
						$pagecount=$rowscount/$pagelarge;
				  }
				  else
				  {
						$pagecount=intval($rowscount/$pagelarge)+1;
				  }
				  if($pagecurrent=="" || $pagecurrent<=0)
				{
					$pagecurrent=1;
				}
				 
				if($pagecurrent>$pagecount)
				{
					$pagecurrent=$pagecount;
				}
						$ddddd=$pagecurrent*$pagelarge;
					if($pagecurrent==$pagecount)
					{
						if($rowscount%$pagelarge==0)
						{
						$ddddd=$pagecurrent*$pagelarge;
						}
						else
						{
						$ddddd=$pagecurrent*$pagelarge-$pagelarge+$rowscount%$pagelarge;
						}
					}
					?>
					<table class="table table-bordered table-hover">
						<tr>
							<th><input type="checkbox" name="" id="checkall" value="" onclick="checkall();"/></th>
							<th>序号</th>
							<th style="width:230px;">标题</th>
							<th style="width:272px;">内容</th>
							<th>展示图片</th>
							<th>浏览次数</th>
							<th>添加人员</th>
							<th>添加时间</th>
							<th>操作</th>
						</tr>
					<?php
					for($i=$pagecurrent*$pagelarge-$pagelarge;$i<$ddddd;$i++)
					{
					  ?>
                    <tr>
                        <td><input type="checkbox" name="" id="" data-id="<?php echo mysql_result($query,$i,id);?>" value="" class="sel_btn"/></td>
                        <td><?php echo $i+1;?></td>
                        <td><?php echo mysql_result($query,$i,name);?></td>
                        <td><?php echo mysql_result($query,$i,context);?></td>
                        <td>
                            <a href="<?php echo mysql_result($query,$i,picture) ?>" target='_blank'>
                                <img src='<?php echo mysql_result($query,$i,picture) ?>' width='130' height='70' border='0'>
                            </a>
                        </td>
                        <td><?php echo mysql_result($query,$i,open);?></td>
                        <td><?php echo mysql_result($query,$i,personal);?></td>
                        <td><?php echo date('Y/m/d',strtotime(mysql_result($query,$i,"addtime")));?></td>
                        <td>
                           <a href="del.php?id=<?php echo mysql_result($query,$i,"id");?>&tablename=xinwentongzhi" 
                            onclick="return confirm('确认删除？')" class="m_b_5">
                                <i class="fa fa-trash b_r b_red material-icons"></i>
                                <span class="text_red">删除<span>
                           </a> 
                           <a href="update_news.php?id=<?php echo mysql_result($query,$i,"id");?>">
                                <i class="fa fa-pencil  b_r b_gree material-icons"></i>
                                <span class="text_gree">修改<span>
                           </a>
                        </td>
                    </tr>
					<?php
                        }
                     }
                 ?>
		</table>
    </div>
    <?php
	  if($rowscount > 10)
	  {
		  ?>
    <div class="clearfix news_list_page">
    	<p class="fl">
          <input type="button" class="btn btn-info"" name="Submit2" onclick="javascript:window.print();" value="打印本页" />
        </p>
        <p class="fr news_list_page_p">
            <a href="check_news.php?pagecurrent=1&name=<?php echo $name;?>">首页</a>
            <a href="check_news.php?pagecurrent=<?php echo $pagecurrent-1;?>&name=<?php echo $name;?>">上一页</a> 
            <a href="check_news.php?pagecurrent=<?php echo $pagecurrent+1;?>&name=<?php echo $name;?>">下一页</a>
            <a href="check_news.php?pagecurrent=<?php echo $pagecount;?>&name=<?php echo $name;?>">尾页</a>
            <span>第<?php echo $pagecurrent;?>页</span>
            <span>共<?php echo $pagecount;?>页</span>
            <span>共<?php echo $rowscount;?>条</span>
        </p>
    </div>
    <?php 
	}
	?>
</div>
<!--酒店优惠资讯列表end-->
<script src="js/jquery-2.1.3.min.js" type="text/javascript" charset="utf-8"></script>
<script src="js/sweetalert.min.js" type="text/javascript" charset="utf-8"></script>
<script language="javascript" >
//全选操作
function checkall() {
    var checkall = document.getElementById("checkall");
    var checkedall = checkall.checked;
    var sel_btn = document.getElementsByClassName("sel_btn");
    if(checkedall) {
        //全选
        for(var i = 0; i < sel_btn.length; i++) {
            //设置复选框的选中状态
            sel_btn[i].checked = true;
        }
    } else {
        //取消全选
        for(var i = 0; i < sel_btn.length; i++) {
            sel_btn[i].checked = false;
        }
    }
}
function deleteSelected(){
    //获取选中数据的id
    var select_boxes = $(".sel_btn");
    var ids = new Array();
    for(var i = 0; i < select_boxes.length; i++){
        if(select_boxes[i].checked){
            ids.push($(select_boxes[i]).attr('data-id'));
        } 
}
    //将选中的id发送到php处理文件中实现删除
    $.ajax({
        url: "del_all.php",
        type: "post",
        data: {
            table: "xinwentongzhi",
            ids: ids
        },
        success: function(res){
            if(res.code == 0){//没有选择任何数据
            	swal({
                  title: "警告！",
                  text: "请选择删除的数据！",
                  icon: "warning",
                });
                return false;
           	}
            if(res.code == 1){//后台返回code状态1表示执行成功
            	swal({
                  title: "成功！",
                  text: "成功删除"+res.n+"条数据",
                  icon: "success",
                  showConfirmButton: true
                }).then ((isConfirm) => {//执行成功后的回调
                    history.go(0);
                })
           }    
        }
            
    })
}
</script> 
</body>
</html>