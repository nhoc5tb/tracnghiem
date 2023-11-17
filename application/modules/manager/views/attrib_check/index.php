<link href="<?php echo base_url() ?>assets/css/bootstrap-imageupload.css" rel="stylesheet">
<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>"><?php echo $controller_title ?></a></li>
</ol>

<div class="row">
<div class="col-md-12">
<div class="panel panel-default panel-table">
	<div class="panel-heading panel-heading-divider">Thuộc Tính Chọn<span class="panel-subtitle">Danh sách thuộc tính chọn</span></div>
		<div class="panel-body">
                
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                	<th style="width:90px">Thứ Tự</th>
                    <th>Tiêu đề</th>
                    <th>Hình Ảnh</th>
                    <th>Nhóm thuộc tính</th>
                    <th>Loại thuộc tính</th>
                    <th>Ngày tạo</th>
                    <th>Người tạo</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($getcsdl as $key=>$row):?>
                <tr id="id<?php echo $row->id ?>">
                    <td align="center"><strong>#<?php echo $key+1 ?></strong></td>
                    <td><strong><?php echo $row->title ?></strong></td>
                    <td>
					<?php if(empty($row->image)):?>
					<?php else: 
						$img = json_decode($row->image);
					?>   
                        <img src="<?php echo $this->ruadmin->geturlimg($row->image,$config_upload["dirweb"]); ?>" style="max-width:100px;"/> 
					<?php endif; ?>
                    </td>
                    <td><?php echo $row->group_title ?></td>
                    <td><?php echo $row->type ?></td>
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
        </div>        
    	</div>
      <div class="pagination"><?php echo $pagination ?></div>
  </div>
</div>

 
              <div class="panel panel-default panel-border-color panel-border-color-primary">
                <div class="panel-heading panel-heading-divider">Thêm Thuộc Tính</div>
                <div class="panel-body">
                	<?php if (validation_errors()):?>					
                    <div role="alert" class="alert alert-contrast alert-danger alert-dismissible">
                        <div class="icon"><span class="mdi mdi-close-circle-o"></span></div>
                        <div class="message">
                          <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="mdi mdi-close"></span></button>
                          <?php if (validation_errors()) echo validation_errors(' ','<br>'); ?>
                        </div>
                      </div>
                    <?php endif; ?>
                  <form action=""  style="border-radius: 0px;" class="form-horizontal group-border-dashed"  method="post" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" />
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Tên thuộc tính</label>
                      <div class="col-sm-6">
                        <input name="title" value="<?php echo set_value('title');?>" parsley-trigger="change" required="" placeholder="Tên thuộc tính" autocomplete="on" class="form-control" type="text">
                      </div>
                    </div>
                    <script type="text/javascript">
          					$(document).ready(function(e) {
          						var group_check = $('select[name="group"]');
          						group_check.on("select2:select", function (e) { 
          							if($(this).find("option:selected").attr("rate") == 1)
          								$('#rate').css('display','block');
          							else
          								$('#rate').css('display','none');
          						});
          					});
                    </script>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Nhóm thuộc tính</label>
                      <div class="col-sm-6">
                      	<select class="select2"  name="group"> 
            							  <?php	
            							  foreach($group as $row){
            							  	echo '<option value="'.$row->id.'" rate="'.$row->rate.'">'.$row->title.'</option>';
            							  }
            							  ?>
          						</select>
                      </div>
                    </div>
                    
                    <div class="form-group" id="rate" style="display:none">
                      <label class="col-sm-3 control-label">Tỉ giá</label>
                      <div class="col-sm-6">
							<input type="text" data-mask="percent" placeholder="0%" class="form-control">
                      </div>
                    </div>
                    <?php $this->load->view("blockmodule/upfile.php");?>                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label"></label>
                      <div class="col-sm-6">
                      		<button class="btn btn-primary btn-lg" type="submit">Thêm Thuộc Tính</button>
							<button class="btn btn-default btn-lg" type="button">Nhập Lại</button>  
                      </div>
                    </div>
                    
                    
                  </form>
                </div>
              </div>
            </div>

<?php $this->load->view("blockmodule/modal_dialog");?>

	