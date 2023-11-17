<link href="<?php echo base_url() ?>assets/css/bootstrap-imageupload.css" rel="stylesheet">
<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>">Danh Mục Block Template</a></li>
	<li class="active"><?php echo $title ?></li>
</ol>

 <div class="row">
 
 <div class="col-md-12">
<div class="panel panel-default panel-table">
	<div class="panel-heading panel-heading-divider">Danh Mục <span class="panel-subtitle">Block Template</span></div>
		<div class="panel-body">
                
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Tên Block</th>
                    <th>Title Block</th>
                    <th>Vị Trí Block</th>
                    <th>Module</th>
                    <th>Người tạo</th>
                    <th>Ngày tạo</th>
                    <th>Người sửa</th>
                    <th>Ngày sửa</th>
                    <th>Hoạt Động</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php 			
			foreach($getcsdl as $row):?>
                <tr id="id<?php echo $row->id ?>">
                    <td><strong><?php echo $row->title ?></strong></td>
                    <td><strong><?php echo $row->show_title ?></strong></td>
                    <td><?php echo $row->position ?></td>
                    <td><?php  echo $block_module[$row->module] ?></td>                				
                    <td><?php echo $row->created ?></td>
                    <td><?php echo $row->created_by ?></td>
                    <td><?php echo $row->modified ?></td>
                    <td><?php echo $row->modified_by ?></td>
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
        </div>
	</div>
</div>
</div>
 

<?php $this->load->view("blockmodule/modal_dialog");?>  



	