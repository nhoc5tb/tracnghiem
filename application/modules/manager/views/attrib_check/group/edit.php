<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>"><?php echo $controller_title ?></a></li>
	<li class="active"><?php echo $title ?></li>
</ol>
<link href="<?php echo base_url() ?>assets/css/bootstrap-imageupload.css" rel="stylesheet">
 <div class="row">
 
 <div class="col-md-12">
              <div class="panel panel-default panel-border-color panel-border-color-primary">
                <div class="panel-heading panel-heading-divider">Cập Nhật Nhóm Thuộc Tính</div>
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
                  <form action="#" style="border-radius: 0px;" class="form-horizontal group-border-dashed"   method="post" enctype="multipart/form-data">
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
							  <option value="radio" <?php echo set_select('type', 'radio', (!empty($getcsdl) && $getcsdl->type == 'radio')) ?>>Chọn một</option>
							  <option value="checkbox" <?php echo set_select('type', 'checkbox', (!empty($getcsdl) && $getcsdl->type == 'checkbox')) ?>>Chọn nhiều</option>
						</select>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Loại sử dụng</label>
                      <div class="col-sm-6">
                      	<select class="select2"  name="type_action">
							  <option value="textarea" <?php echo set_select('type_action', 'textarea', (!empty($getcsdl) && $getcsdl->type_action == 'textarea')) ?>>Nội dung</option>
							  <option value="image" <?php echo set_select('type_action', 'image', (!empty($getcsdl) && $getcsdl->type_action == 'image')) ?>>Hình ảnh</option>
						</select>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Sử dụng tỉ giá</label>
                      <div class="col-sm-6">
                      	<select class="select2"  name="rate">
							  <option value="0" <?php echo set_select('rate', '0', (!empty($getcsdl) && $getcsdl->rate == '0')) ?>>Không dùng</option>
							  <option value="1" <?php echo set_select('rate', '1', (!empty($getcsdl) && $getcsdl->rate == '1')) ?>>Có dùng</option>
						</select>
                      </div>
                    </div>
                    
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Mô tả chức năng</label>
                      <div class="col-sm-6">
                        <textarea class="form-control" name="description"><?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->description;else echo set_value('description');?></textarea>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label"></label>
                      <div class="col-sm-6">
                      		<button class="btn btn-success btn-lg" type="submit">Cập Nhật Nhóm</button>
							<button class="btn btn-default btn-lg" type="button">Nhập Lại</button>  
                      </div>
                    </div>
                    
                    
                  </form>
                </div>
              </div>
            </div>





	