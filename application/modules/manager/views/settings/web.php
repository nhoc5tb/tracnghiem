	<ol class="breadcrumb">
        <li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
        <li><a href="<?php echo base_url().$module."/".$controller?>">Cấu hình web</a></li>
        <li class="active"><?php echo $title ?></li>
    </ol>
<form action="" style="border-radius: 0px;" class="form-horizontal group-border-dashed" method="post" enctype="multipart/form-data">
  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" />
    <div class="row">
            <div class="col-md-12">
              <div class="panel panel-default panel-border-color panel-border-color-primary">
                <div class="panel-heading panel-heading-divider"><?php echo $title ?><span class="panel-subtitle">Cấu hình thông tin website</span></div>
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
                   
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Hotline</label>
                      <div class="col-sm-6">
                       <input placeholder="Hotline" class="form-control" type="text" name="hotline" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->hotline;else echo set_value('hotline');?>">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Địa chỉ</label>
                      <div class="col-sm-6">
                       <input placeholder="Hotline" class="form-control" type="text" name="location" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->location;else echo set_value('location');?>">
                      </div>
                    </div>
                   
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Hình ảnh post MXH</label>
                      <div class="col-sm-6">
                      <input placeholder="Hình ảnh" class="form-control" type="text" name="image" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->image;else echo set_value('image');?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Maps Google</label>
                      <div class="col-sm-6">
                      <input placeholder="Hình ảnh" class="form-control" type="text" name="maps" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->maps;else echo set_value('maps');?>">
                      </div>
                    </div>
                </div>
              </div>
              
              <div class="panel panel-default panel-border-color panel-border-color-primary">
                <div class="panel-heading panel-heading-divider">Mạng xã hội<span class="panel-subtitle">Liên kết mạng xã hội của website</span></div>
                <div class="panel-body">
                	
                  	                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Facebook</label>
                      <div class="col-sm-6">
                        <input placeholder="Facebook" class="form-control" type="text" name="facebook" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->facebook;else echo set_value('facebook');?>">
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Pinterest</label>
                      <div class="col-sm-6">
                        <input placeholder="Pinterest" class="form-control" name="pinterest" type="text" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->pinterest;else echo set_value('pinterest');?>">
                      </div>
                    </div>
                   <div class="form-group">
                      <label class="col-sm-3 control-label">Twitter</label>
                      <div class="col-sm-6">
                        <input placeholder="Twitter" class="form-control" name="home_text" type="text" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->twitter;else echo set_value('twitter');?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Instagram</label>
                      <div class="col-sm-6">
                        <input placeholder="Instagram" class="form-control" name="instagram" type="text" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->instagram;else echo set_value('instagram');?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Youtube</label>
                      <div class="col-sm-6">
                        <input placeholder="Youtube" class="form-control" name="instagram" type="text" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->youtube;else echo set_value('youtube');?>">
                      </div>
                    </div>
                    
                  
                </div><!-- panel-body -->
              </div><!-- panel panel-default panel-border-color panel-border-color-primary -->
              
              <div class="panel panel-default panel-border-color panel-border-color-primary">
                <div class="panel-heading panel-heading-divider">Mã theo dõi web<span class="panel-subtitle">Cấu hình công cụ theo dõi bên thứ ba</span></div>
                <div class="panel-body">
                	
                  	                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Analytics</label>
                      <div class="col-sm-6">
                      <textarea class="form-control" name="analytics"><?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->analytics;else echo nl2br(set_value('analytics'));?></textarea>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Adwords</label>
                      <div class="col-sm-6">
                      <textarea class="form-control" name="adwords"><?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->adwords;else echo nl2br(set_value('adwords'));?></textarea>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Facebook Ads</label>
                      <div class="col-sm-6">
                      <textarea class="form-control" name="facebook_ads"><?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->facebook_ads;else echo nl2br(set_value('facebook_ads'));?></textarea>
                      </div>
                    </div>
                    
                  
                </div><!-- panel-body -->
              </div><!-- panel panel-default panel-border-color panel-border-color-primary -->
              
              <div class="panel panel-default panel-border-color panel-border-color-primary">
                <div class="panel-heading panel-heading-divider">Cấu hình gửi mail<span class="panel-subtitle">Cấu hình gửi mail qua </span></div>
                <div class="panel-body">                	
                  	                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Mail Host</label>
                      <div class="col-sm-6">
                      <input class="form-control" name="mail_host" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->mail_host;else echo nl2br(set_value('mail_host'));?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Mail Port</label>
                      <div class="col-sm-6">
                      <input class="form-control" name="mail_port" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->mail_port;else echo nl2br(set_value('mail_port'));?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Mail User</label>
                      <div class="col-sm-6">
                      <input class="form-control" name="mail_user" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->mail_user;else echo nl2br(set_value('mail_user'));?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Mail Pass</label>
                      <div class="col-sm-6">
                      <input class="form-control" name="mail_pass" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->mail_pass;else echo nl2br(set_value('mail_pass'));?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Mail Name</label>
                      <div class="col-sm-6">
                      <input class="form-control" name="mail_name" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->mail_name;else echo nl2br(set_value('mail_name'));?>">
                      </div>
                    </div>
                </div><!-- panel-body -->
              </div><!-- panel panel-default panel-border-color panel-border-color-primary -->
              
              <div class="panel panel-default panel-border-color panel-border-color-primary">
                <div class="panel-heading panel-heading-divider">Cấu hình plugin<span class="panel-subtitle">Cấu hình plugin từ bên thứ 3 như chát facebook </span></div>
                <div class="panel-body">    
                    <div class="form-group">
                    	<label class="col-sm-3 control-label">Chát Fb</label>
                    	<div class="col-sm-6">
                    		<input class="form-control" name="id_fanpage" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->id_fanpage;else echo nl2br(set_value('id_fanpage'));?>">
                    	</div>
                    </div>
                </div><!-- panel-body -->
              </div><!-- panel panel-default panel-border-color panel-border-color-primary -->
              
              
              <div class="form-group">
                      <label class="col-sm-3 control-label"></label>
                      <div class="col-sm-6">
                      		<button class="btn btn-default btn-primary btn-lg" type="submit">Lưu Cấu Hình</button>
							<button class="btn btn-default btn-lg" type="button">Nhập Lại</button>  
                      </div>
                    </div>
              
              
              
            </div>
          </div></form>