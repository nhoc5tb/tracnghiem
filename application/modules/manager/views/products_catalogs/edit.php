<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>"><?php echo $controller_title ?> : </a></li>
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
                    
                    <?php $this->load->view("blockmodule/upfile.php",array("image"=>$getcsdl->image));?>                    
                    
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
                        <input name="sllug" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->keywords;else echo set_value('keywords');?>" placeholder="Keywords" class="form-control" type="text">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Description</label>
                      <div class="col-sm-6">
                        <textarea class="form-control" name="description"><?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->description;else echo set_value('description');?></textarea>
                      </div>
                    </div>
                    
                    
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Thuộc tính nhập</label>
                      <div class="col-sm-6">
                      <?php 
						$seclected = json_decode($getcsdl->attrib);
						foreach($attrib as $row):
							$seclected_text = '';
							if(!empty($seclected)){
								foreach($seclected as $SECLECTED){
									if($SECLECTED == $row->id) $seclected_text = 'checked="true"';
								}
							}
						?>
                        <div class="">
                          	<input type="checkbox"  <?php echo $seclected_text ?> name="attrib[]" value="<?php echo $row->id ?>">
                            <label for="check6"><?php echo $row->title ?></label>
                        </div>
                       <?php endforeach ?> 
                      </div>
                    </div>
                    
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Thuộc tính chọn</label>
                      <div class="col-sm-6">
                      <?php 
						$seclected = json_decode($getcsdl->attrib_check);
						foreach($attrib_check as $row):
							$seclected_text = '';
							if(!empty($seclected)){
								foreach($seclected as $SECLECTED){
									if($SECLECTED == $row->id) $seclected_text = 'checked="true"';
								}
							}
						?>
                        <div class="">
                          	<input type="checkbox"  <?php echo $seclected_text ?> name="attrib_check[]" value="<?php echo $row->id ?>">
                            <label for="check6"><?php echo $row->title ?></label>
                        </div>
                       <?php endforeach ?> 
                      </div>
                    </div>
                    
                    <div class="form-group">
						<div class="col-sm-12">												
						<?php 
						if(!empty($getcsdl) && !validation_errors()) 
							$content =  $getcsdl->body_text;
						else 
							$content =  set_value('body_text');	
						$this->load->view("blockmodule/froalaeditor.php",array("name"=>"body_text","content_froalaeditor"=>$content));
						?>
						</div>
					</div>
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Thứ Tự</label>
                      <div class="col-sm-6">
                        <input name="order" value="<?php if(!empty($getcsdl)&&!validation_errors()) echo $getcsdl->order;else echo set_value('order');?>" style="width:100px" min="0" max="500" class="form-control" type="number">
                      </div>
                    </div>
                    
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label"></label>
                      <div class="col-sm-6">
                      		<button class="btn btn-success btn-lg" type="submit">Cập Nhật Danh Mục</button>
							<button class="btn btn-default btn-lg" type="button">Nhập Lại</button>  
                      </div>
                    </div>
                    
                    
                  </form>
                </div>
              </div>
            </div>





	