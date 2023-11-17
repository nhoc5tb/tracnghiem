<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>"><?php echo $controller_title ?></a></li>
</ol>

<div class="row">
            <div class="col-md-12">
              <div class="panel panel-default panel-border-color panel-border-color-primary">
                <div class="panel-heading panel-heading-divider"><?php echo $title ?><span class="panel-subtitle">Cập nhật cho tài khoản của mình</span></div>
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
                  	<div class="form-group has-error">
                      <label class="col-sm-3 control-label">Nhập mật khẩu hiện tại</label>
                      <div class="col-sm-6">
                        <input value="" class="form-control" name="password_old" type="password">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Tên đăng nhập</label>
                      <div class="col-sm-6">
                        <input disabled value="<?php echo $getcsdl->username;?>" class="form-control" type="text">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Mật khẩu</label>
                      <div class="col-sm-6">
                        <input id="pass2" placeholder="mật khẩu" class="form-control" name="password" type="password">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Xác nhận mật khẩu</label>
                      <div class="col-sm-6">
                        <input rdata-parsley-equalto="#pass2" placeholder="xác nhận lại mật khẩu" class="form-control" name="password_c" type="password">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Tên hiển thị</label>
                      <div class="col-sm-6">
                        <input value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->name;else echo set_value('name');?>" parsley-trigger="change" required="" placeholder="tên hiển thị ra ngoài" autocomplete="on" class="form-control" name="name" type="text">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">E-mail</label>
                      <div class="col-sm-6">
                        <input value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->email;else echo set_value('email');?>" name="email" parsley-trigger="change" required="" placeholder="nhập email" autocomplete="off" class="form-control" type="email">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Số điện thoại</label>
                      <div class="col-sm-6">
                        <input value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->phone;else echo set_value('phone');?>" class="form-control" placeholder="nhập số điện thoại" name="phone" type="text">
                      </div>
                    </div>
                    
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label"></label>
                      <div class="col-sm-6">
                      		<button class="btn btn-primary btn-lg" type="submit">Cập Nhật Thông Tin</button>
							<button class="btn btn-default btn-lg" type="button">Nhập Lại</button>  
                      </div>
                    </div>
                    
                    
                  </form>
                </div>
              </div>
            </div>
          </div>