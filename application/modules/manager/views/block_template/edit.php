<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>">Block Template</a></li>
	<li class="active"><?php echo $title ?></li>
</ol>
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
                  <form action="#" style="border-radius: 0px;" class="form-horizontal group-border-dashed" method="post" enctype="multipart/form-data">
                   	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" />
                   	<div class="form-group">
                      <label class="col-sm-3 control-label">Tên Block</label>
                      <div class="col-sm-9">
                        <input name="title" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->title;else echo set_value('title');?>" parsley-trigger="change" required="" placeholder="" autocomplete="on" class="form-control" type="text">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Tiêu đề của Block</label>
                      <div class="col-sm-9">
                        <input name="show_title" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->show_title;else echo set_value('show_title');?>" parsley-trigger="change" placeholder="" autocomplete="on" class="form-control" type="text">
                      </div>
                    </div>
                   
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Vị Trí Block</label>
                      <div class="col-sm-6">
						<select  class="select2" disabled>
                        <?php foreach($block as $key=>$row):?>
							<option value="<?php echo $key ?>" <?php echo set_select('position', $key, (!empty($getcsdl) && $getcsdl->position == $key))?>><?php echo $row["note"] ?></option>
						<?php endforeach ?>
                        </select>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Chức năng Block</label>
                      <div class="col-sm-6">
                      	<select class="select2" name="module">
                        <?php foreach($block_module as $key=>$row):?>
                        	<option value="<?php echo $key ?>" <?php echo set_select('module', $key, (!empty($getcsdl) && $getcsdl->module == $key)) ?>><?php echo $row ?></option>
						<?php endforeach ?>
                        </select>
                      </div>
                    </div>
                    
                    <div class="form-group ru-params" style="<?php echo ($getcsdl->module == "module_ads" or $getcsdl->module == "module_slider")?'':'display:none' ?>">
                      <label class="col-sm-3 control-label">Chọn nhóm quảng cáo</label>
                      <div class="col-sm-6">
                      	<select class="select2" name="params">
                        	<option value=""> --- Chọn nhóm quảng cáo --- </option>
                        	<?php foreach($ads as $row): ?>
                        	<option value="<?php echo $row->id ?>"><?php echo $row->title ?></option>
                        	<?php endforeach ?>
						</select>
                      </div>
                    </div>
                    
                    <div class="form-group ru-content" style="<?php echo ($getcsdl->module == "module_content")?'':'display:none' ?>">
                    	<label class="col-sm-3 control-label">Nội dung</label>
                    	<div class="col-sm-9">
                        <?php $this->load->view("blockmodule/froalaeditor.php",array("name"=>"content"))?>
                    	</div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label"></label>
                      <div class="col-sm-6">
                      		<button class="btn btn-primary btn-lg" type="submit">Cập Nhật Block Template</button>
							<button class="btn btn-default btn-lg" type="button">Nhập Lại</button>  
                      </div>
                    </div>
                    
                    
                  </form>
                </div>
              </div>
            </div>





	