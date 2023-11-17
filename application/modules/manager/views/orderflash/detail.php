<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>">Đơn Hàng</a></li>
	<li class="active"><?php echo $title ?></li>
</ol>
<div class="panel panel-default">
<div class="panel-heading">Chi tiết Đơn Hàng Khách Đặt Từ Web Mã Số <strong><?php echo $getcsdl->id ?></strong></div>
	<div class="panel-body">
       <div class="panel panel-flat">
       		<div class="panel-heading">Khách Hàng</div>
       		<div class="panel-body">
       			<p>Khách hàng : <strong><?php echo $getcsdl->name ?></strong><br>
       			Ngày Tạo : <strong><?php echo $getcsdl->created ?></strong></p>
       			<?php echo $getcsdl->content ?>
       		</div>
       </div>  
       <a href="<?php echo base_url().$module."/sale/create_web/".$getcsdl->id ?>" class="btn btn-success">Chuyển Qua Tạo Đơn</a>
       <br>
       <p><?php echo $getcsdl->note_admin ?></p>           
	</div>
</div>