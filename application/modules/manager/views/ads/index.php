<link href="<?php echo base_url() ?>assets/css/bootstrap-imageupload.css" rel="stylesheet">
<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>"><?php echo $controller_title ?></a></li>
</ol>

 <div class="row">
 
 <div class="col-md-12">
<div class="panel panel-default panel-table">
	<div class="panel-heading panel-heading-divider">Danh Mục Quảng Cáo<span class="panel-subtitle">Phân nhóm cho quảng cáo</span></div>
		<div class="panel-body">
        <?php if(count($getcsdl) > 0):?>        
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                	<th style="width:90px;text-align: center">#</th>
                    <th>Tên</th>
                    <th>Loại</th>
                    <th>Nhóm</th>
                    <th>Ngày tạo</th>
                    <th>Người tạo</th>
                    <th>Trạng thái</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php 
			foreach($getcsdl as $key=>$row):
			?>
                <tr id="id<?php echo $row->id ?>">
                    <td align="center"><strong>#<?php echo $key+1 ?></strong></td>
                    <td>
                    	<strong><?php echo $row->title ?></strong>
                        <br>
                        <?php if($row->type == 1):?>							
						<?php if(!empty($row->image)):?>
						<img src="<?php echo $this->ruadmin->geturlimg($row->image,$config_upload["dirweb"]); ?>" height="85" />
                        <?php endif ?>
                        <?php endif ?>
					</td>
                    <td>
					<?php 
						switch($row->type){
							case '1':
								echo "Hình ảnh";
								break;
							case '3':
								echo "Mã code";
								break;
							default:
								echo "N/A";
								break;		
						}
					?>
                    </td>
                    <td><?php echo $row->group_title ?></td>
                    <td><?php echo $row->created ?></td>
                    <td><?php echo $row->created_by ?></td>
                    <td>
                        <div class="switch-button switch-button-yesno">
                            <input type="checkbox" <?php echo ($row->status == 1)?'checked="true"':'' ?> id="swt<?php echo $row->id ?>"><span>
                            <label class="status" data-id="<?php echo $row->id ?>" for="swt<?php echo $row->id ?>" data-path="<?php echo base_url($module)."/".$controller ?>/status/<?php echo $row->id ?>"></label></span>
                        </div>
                    </td>
                    <td>
                        <?php echo $this->rurole->showPermission("edit",$row->id) ?>
                        <?php echo $this->rurole->showPermission("delete",$row->id) ?>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
        <?php endif ?>
        </div>
	</div>
</div>
</div>
<div class="pagination">
                <?php echo $pagination ?>
              </div>
 
<?php $this->load->view("blockmodule/modal_dialog");?>         





	