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
                <div class="panel-heading panel-heading-divider"><?php echo $title ?><span class="panel-subtitle">Cấu hình thông tin thẻ Meta</span></div>
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
                      <label class="col-sm-3 control-label">Tên website</label>
                      <div class="col-sm-6">
                        <input placeholder="Tên website" class="form-control" type="text" name="site_name" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->site_name;else echo set_value('site_name');?>">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Tiêu đề nặc định</label>
                      <div class="col-sm-6">
                       <input placeholder="Tên website" class="form-control" type="text" name="site_title" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->site_title;else echo set_value('site_title');?>">
                      </div>
                    </div>
                     <div class="form-group">
                      <label class="col-sm-3 control-label">Mail Liên Hệ</label>
                      <div class="col-sm-6">
                       <input placeholder="Tên website" class="form-control" type="text" name="site_mail" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->site_mail;else echo set_value('site_mail');?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Keywords</label>
                      <div class="col-sm-6">
                        <textarea class="form-control" name="keywords"><?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->keywords;else echo set_value('keywords');?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Description</label>
                      <div class="col-sm-6">
                        <textarea class="form-control" name="description"><?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->description;else echo set_value('description');?></textarea>
                      </div>
                    </div>                    
                   
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Hình ảnh post MXH</label>
                      <div class="col-sm-6">
                      <input placeholder="Hình ảnh" class="form-control" type="text" name="image" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->image;else echo set_value('image');?>">
                      </div>
                    </div>
                </div>
              </div>
              
              <div class="form-group">
                      <label class="col-sm-3 control-label"></label>
                      <div class="col-sm-6">
                      		<button class="btn btn-default btn-primary btn-lg" type="submit">Lưu Cấu Hình</button>
							<button class="btn btn-default btn-lg" type="button">Nhập Lại</button>  
                      </div>
                    </div>
              
              
              
            </div>
          </div></form>