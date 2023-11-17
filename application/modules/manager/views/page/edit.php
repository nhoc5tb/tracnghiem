<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>"><?php echo $controller_title ?></a></li>
	<li class="active"><?php echo $title ?></li>
</ol>
<div class="row">
            <div class="col-md-12">
              <div class="panel panel-default panel-border-color panel-border-color-primary">
                <div class="panel-heading panel-heading-divider">Sửa <?php echo $title ?><span class="panel-subtitle">Sửa nội dung <?php echo $title ?> cho website</span></div>
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
                  <form action="#" style="border-radius: 0px;" class="form-horizontal group-border-dashed" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" />
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Tiêu đề</label>
                      <div class="col-sm-10">
                        <input name="title" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->title;else echo set_value('title');?>" parsley-trigger="change" required="" placeholder="Tiêu đề" autocomplete="on" class="form-control" type="text">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Thẻ H1</label>
                      <div class="col-sm-10">
                        <input id="title" name="headingh1" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->headingh1;else echo set_value('headingh1');?>" parsley-trigger="change" required="" placeholder="Nếu rỗng sẽ lấy tiêu đề" class="form-control" type="text">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Slug</label>
                      <div class="col-sm-10">
                        <input placeholder="Slug cho seo" class="form-control" name="slug" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->slug;else echo set_value('slug');?>" type="text">
                      </div>
                    </div>
                           
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Chuyên mục</label>
                      <div class="col-sm-10">
                      	<select class="select2" name="group">
                              <?php	foreach($catalogs as $row){
										echo '<option value="'.$row->id.'" '.set_select('group', $row->id, (!empty($getcsdl) && $getcsdl->id_group == $row->id)).'>'.$row->title.'</option>';
								}
							?>
						</select>
                      </div>
                    </div>
                    
                    <?php 					  
                      $this->load->view("blockmodule/upfile.php",array("image"=>$getcsdl->image,"size"=>2))
                    ?>
                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Keywords</label>
                      <div class="col-sm-10">
                        <textarea type="text" class="form-control" name="keywords"><?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->keywords;else echo set_value('keywords');?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Description</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" name="description"><?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->description;else echo set_value('description');?></textarea>
                      </div>
                    </div>
                    
                    <div class="form-group">
                    	<label class="col-sm-2 control-label">Mô tả ngắn</label>
                    	<div class="col-sm-10">
                       	<textarea type="text" class="form-control" name="home_text"><?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->home_text;else echo set_value('home_text');?></textarea>
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
                      <label class="col-sm-2 control-label"></label>
                      <div class="col-sm-10">
                      		<button class="btn btn-success btn-lg" type="submit">Cập Nhật Bài Viết</button>
							<button class="btn btn-default btn-lg" type="button">Nhập Lại</button>  
                      </div>
                    </div>
                    
                    
                  </form>
                </div>
              </div>
            </div>
          </div>