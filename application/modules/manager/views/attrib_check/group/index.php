<link href="<?php echo base_url() ?>assets/css/bootstrap-imageupload.css" rel="stylesheet">
<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>"><?php echo $controller_title ?></a></li>
</ol>

<div class="row">
<div class="col-md-12">
<div class="panel panel-default panel-table">
	<div class="panel-heading panel-heading-divider">Nhóm Thuộc tính chọn <span class="panel-subtitle">Danh sách nhóm thuộc tính chọn của sản phẩm</span></div>
		<div class="panel-body">
                
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                	<th style="width:90px">Thứ Tự</th>
                    <th>Tiêu đề</th>
                    <th>Loại thuộc tính</th>
                    <th>Loại sử dụng</th>
                    <th>Mô tả</th>
                    <th>Người tạo</th>
                    <th>Người tạo</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($catalogs as $key=>$row):?>
                <tr id="id<?php echo $row->id ?>">
                    <td align="center"><strong>#<?php echo $key+1 ?></strong></td>
                    <td><strong><?php echo $row->title ?></strong></td>
                    <td>
					<?php 
					if($row->type == 'radio'){
						echo 'Chọn một';
					}elseif($row->type == 'checkbox'){
						echo 'Chọn nhiều';
					}
					?>
                    </td>
                    <td>
                    <?php 
                    	if($row->type_action == 'textarea'){
                    		echo 'Nội dung';
                    	}elseif($row->type_action == 'image'){
                    		echo 'Hình ảnh';
                    	}
                    ?>
                    </td>
                    <td><?php echo nl2br($row->description) ?></td>
                    <td><?php echo $row->created ?></td>
                    <td><?php echo $row->created_by ?></td>
                    <td>
                        <div class="switch-button switch-button-yesno">
                            <input type="checkbox" <?php echo ($row->status == 1)?'checked="true"':'' ?> id="swt<?php echo $row->id ?>"><span>
                            <label class="status" data-id="<?php echo $row->id ?>" for="swt<?php echo $row->id ?>" data-path="<?php echo base_url($module)."/".$controller ?>/group_status/<?php echo $row->id ?>"></label></span>
                        </div>
                    </td>
                    <td>
                        <?php echo $this->rurole->showPermission("group_edit",$row->id) ?>
                        <?php echo $this->rurole->showPermission("group_del",$row->id) ?>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
        </div>
	</div>
</div>
</div>
 
              <div class="panel panel-default panel-border-color panel-border-color-primary">
                <div class="panel-heading panel-heading-divider">Thêm Nhóm</div>
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
                      <label class="col-sm-3 control-label">Tên nhóm</label>
                      <div class="col-sm-6">
                        <input name="title" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->title;else echo set_value('title');?>" parsley-trigger="change" required="" placeholder="Tên danh mục" autocomplete="on" class="form-control" type="text">
                      </div>
                    </div>
                    
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Loại thuộc tính</label>
                      <div class="col-sm-6">
                      	<select class="select2"  name="type">
                            <option value="radio">Chọn một</option>
                            <option value="checkbox">Chọn nhiều</option>
						</select>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Loại sử dụng</label>
                      <div class="col-sm-6">
                      	<select class="select2"  name="type_action">
                            <option value="textarea">Nội dung</option>
                            <option value="image">Hình ảnh</option>  
						</select>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Sử dụng tỉ giá</label>
                      <div class="col-sm-6">
                      	<select class="select2"  name="rate">
                            <option value="0">Không dùng</option>
							<option value="1">Có dùng</option>
						</select>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Mô tả chức năng</label>
                      <div class="col-sm-6">
                        <input name="description" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->description;else echo set_value('description');?>" placeholder="description" class="form-control" type="text">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label"></label>
                      <div class="col-sm-6">
                      		<button class="btn btn-primary btn-lg" type="submit">Thêm Nhóm</button>
							<button class="btn btn-default btn-lg" type="button">Nhập Lại</button>  
                      </div>
                    </div>
                    
                    
                  </form>
                </div>
              </div>
            </div>

<?php $this->load->view("blockmodule/modal_dialog");?> 



	