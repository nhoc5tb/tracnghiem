<link href="<?php echo base_url() ?>assets/css/bootstrap-imageupload.css" rel="stylesheet">
<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>"><?php echo $controller_title ?></a></li>
</ol>

<div class="row">
<div class="col-md-12">
<div class="panel panel-default panel-table">
	<div class="panel-heading panel-heading-divider"><?php echo $controller_title ?></div>
		<div class="panel-body">
                
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                	<th style="width:90px">Thứ Tự</th>
                    <th>Tiêu đề</th>
                    <th>Slug</th>
                    <th>Ngày tạo</th>
                    <th>Người tạo</th>
                    <th>Hoạt Động</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($catalogs as $row):?>
                <tr id="id<?php echo $row->id ?>">
                    <td align="center"><strong><?php echo $row->order ?></strong></td>
                    <td><strong><?php echo $row->title ?></strong></td>
                    <td><?php echo $row->slug ?></td>
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
</div>
</div>
 
              <div class="panel panel-default panel-border-color panel-border-color-primary">
                <div class="panel-heading panel-heading-divider">Thêm Danh Mục Mặt Hàng</div>
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
                    
                  <form action="<?php echo base_url().$module.'/'.$controller.'/add' ?>"  style="border-radius: 0px;" class="form-horizontal group-border-dashed"  method="post" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" />
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Tên danh mục</label>
                      <div class="col-sm-6">
                        <input name="title" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->title;else echo set_value('title');?>" parsley-trigger="change" required="" placeholder="Tên danh mục" autocomplete="on" class="form-control" type="text">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Slug</label>
                      <div class="col-sm-6">
                        <input name="slug" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->slug;else echo set_value('slug');?>" placeholder="Tên trên url" class="form-control" type="text">
                      </div>
                    </div>
                    
                    <?php $this->load->view("blockmodule/upfile.php");?>
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Chuyên Mục</label>
                      <div class="col-sm-6">
                      	<select class="select2"  name="parent_id">
                              <option value="0">Là chuyên mục chính</option>  
							  <?php	
                              foreach($catalogs as $row){
									echo '<option value="'.$row->id.'" '.set_select('parent_id', $row->id, (!empty($getcsdl) && $getcsdl->parent_id == $row->id)).'>'.$row->title.'</option>';
                              }
							?>
						</select>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Keywords</label>
                      <div class="col-sm-6">
                        <input name="keywords" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->keywords;else echo set_value('keywords');?>" placeholder="Keywords" class="form-control" type="text">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Description</label>
                      <div class="col-sm-6">
                        <textarea class="form-control" name="description"><?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->description;else echo set_value('description');?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Thứ Tự</label>
                      <div class="col-sm-6">
                        <input name="order" value="<?php if(!validation_errors()) echo count($catalogs) + 1;else echo set_value('order');?>" style="width:100px" min="0" max="500" class="form-control" type="number">
                      </div>
                    </div>
                    
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label"></label>
                      <div class="col-sm-6">
                      		<button class="btn btn-primary btn-lg" type="submit">Thêm Danh Mục</button>
							<button class="btn btn-default btn-lg" type="button">Nhập Lại</button>  
                      </div>
                    </div>
                    
                    
                  </form>
                </div>
              </div>
            </div>

<?php $this->load->view("blockmodule/modal_dialog");?>   



	