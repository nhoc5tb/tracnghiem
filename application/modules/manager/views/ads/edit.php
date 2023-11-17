<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>"><?php echo $controller_title ?></a></li>
	<li class="active"><?php echo $title ?></li>
</ol>
<link href="<?php echo base_url() ?>assets/css/bootstrap-imageupload.css" rel="stylesheet">
 <div class="row">
 	<div class="col-md-12">
		<div class="panel panel-default panel-border-color panel-border-color-primary">
			<div class="panel-heading panel-heading-divider"><?php echo $title ?></div>
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
                      <label class="col-sm-3 control-label">Tên quảng cáo</label>
                      <div class="col-sm-6">
                        <input name="title" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->title;else echo set_value('title');?>" parsley-trigger="change" required="" placeholder="Tên danh mục" autocomplete="on" class="form-control" type="text">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Loại quảng cáo</label>
                      <div class="col-sm-6">
						<select  class="select2" name="type">
							<option value="1" <?php echo set_select('type', 1, (!empty($getcsdl) && $getcsdl->type == 1))?>>Hình ảnh</option>
							<option value="3" <?php echo set_select('type', 3, (!empty($getcsdl) && $getcsdl->type == 3))?>>Sử dụng Code</option>
						</select>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Nhóm quảng cáo</label>
                      <div class="col-sm-6">
                      	<select class="select2"  name="id_group"> 
							  <?php	
                              foreach($ads_groups as $row){
									echo '<option value="'.$row->id.'" '.set_select('id_group', $row->id, (!empty($getcsdl) && $getcsdl->id_group == $row->id)).'>'.$row->title.'</option>';
                              }
							?>
						</select>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Liên kết</label>
                      <div class="col-sm-6">
                        <input name="link" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->link;else echo set_value('link');?>" placeholder="Tên trên url" class="form-control" type="text">
                      </div>
                    </div>
                    <?php 
                      if(!empty($getcsdl)){
                        $this->load->view("blockmodule/upfile.php",array("image"=>$getcsdl->image));                        
                      }else{
                        $this->load->view("blockmodule/upfile.php");  
                      }
                    ?>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Sử dụng Code</label>
                      <div class="col-sm-6">
                        <textarea class="form-control" name="body_text"><?php if(!empty($getcsdl) && !validation_errors()) echo htmlspecialchars_decode($getcsdl->body_text);else echo set_value('body_text');?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Thứ Tự</label>
                      <div class="col-sm-6">
                        <input name="order" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->order;else echo set_value('order');?>" style="width:100px" min="1" max="1000" class="form-control" type="number">
                      </div>
                    </div>
                    
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label"></label>
                      <div class="col-sm-6">
                      		<button class="btn btn-primary btn-lg" type="submit"><?php echo $title ?></button>
							            <button class="btn btn-default btn-lg ru-btn-clear" type="button">Nhập Lại</button>  
                      </div>
                    </div>
                    
                    
                  </form>
                </div>
	</div>
</div>





	