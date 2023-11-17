<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>"><?php echo $controller_title ?></a></li>
	<li class="active"><?php echo $title ?></li>
</ol>
<div class="row">
            <div class="col-md-12">
              <div class="panel panel-default panel-border-color panel-border-color-primary">
                <div class="panel-heading panel-heading-divider">Sửa <?php echo $controller_title ?><span class="panel-subtitle">Sửa nội dung <?php echo $controller_title ?> cho website</span></div>
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
                      <label class="col-sm-3 control-label">Tên Mail</label>
                      <div class="col-sm-9">
                        <input name="name" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->name;else echo set_value('name');?>" parsley-trigger="change" required="" placeholder="" autocomplete="on" class="form-control" type="text">
                      </div>
                    </div>
                                       
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Subject</label>
                      <div class="col-sm-9">
                        <input name="subject" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->subject;else echo set_value('subject');?>" parsley-trigger="change" required="" placeholder="" autocomplete="on" class="form-control" type="text">
                      </div>
                    </div>                   
                          
                    
                    <?php $this->load->view("blockmodule/froalaeditor.php",array("name"=>"content","content_froalaeditor"=>$getcsdl->content))?>
                    
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label"></label>
                      <div class="col-sm-9">
                      		<button class="btn btn-primary btn-lg" type="submit">Cập Nhật Lại</button>
							<button class="btn btn-default btn-lg" type="button">Nhập Lại</button>  
                      </div>
                    </div>
                    
                    
                  </form>
                </div>
              </div>
            </div>
          </div>