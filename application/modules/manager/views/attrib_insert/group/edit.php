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
							  <option value="text" <?php echo set_select('type', 'text', (!empty($getcsdl) && $getcsdl->type == 'text')) ?>>Nội dung</option>
							  <option value="post" <?php echo set_select('type', 'post', (!empty($getcsdl) && $getcsdl->type == 'post')) ?>>Bài viết</option>
							  <option value="image" <?php echo set_select('type', 'image', (!empty($getcsdl) && $getcsdl->type == 'image')) ?>>Hình ảnh</option>
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





	