<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>"><?php echo $controller_title ?></a></li>
	<li class="active"><?php echo $title ?></li>
</ol>

    <div class="row">
            <div class="col-md-12">
              <div class="panel panel-default panel-border-color panel-border-color-primary">
                <div class="panel-heading panel-heading-divider"><?php echo $title ?><span class="panel-subtitle"><?php echo $controller_title ?></span></div>
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
                      <label class="col-sm-3 control-label">Tên đăng nhập</label>
                      <div class="col-sm-6">
                        <input name="username" parsley-trigger="change" required="" placeholder="tên đăng nhập" autocomplete="on" class="form-control" type="text">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Mật khẩu</label>
                      <div class="col-sm-6">
                        <input id="pass2" required="" placeholder="mật khẩu" class="form-control" name="password" type="password">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Xác nhận mật khẩu</label>
                      <div class="col-sm-6">
                        <input required="" data-parsley-equalto="#pass2" placeholder="xác nhận lại mật khẩu" class="form-control" name="password_c" type="password">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Tên hiển thị</label>
                      <div class="col-sm-6">
                        <input parsley-trigger="change" required="" placeholder="tên hiển thị ra ngoài" autocomplete="on" class="form-control" name="name" type="text">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">E-mail</label>
                      <div class="col-sm-6">
                        <input name="email" parsley-trigger="change" required="" placeholder="nhập email" autocomplete="off" class="form-control" type="email">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Số điện thoại</label>
                      <div class="col-sm-6">
                        <input class="form-control" placeholder="nhập số điện thoại" name="phone" type="text">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Nhóm quản lý</label>
                      <div class="col-sm-6">
                      	<select class="select2" name="roleid">
                            <?php if(!empty($role_group)): ?>
                            <?php foreach($role_group as $row): ?>
                            <?php if($row->role_id > 1 ): ?>
                            <option value="<?php echo $row->role_id ?>"><?php echo $row->role_name ?></option>
                            <?php endif ?>
                            <?php endforeach ?>
                            <?php endif ?>
						</select>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label"></label>
                      <div class="col-sm-6">
                      		<button class="btn btn-primary btn-lg" type="submit">Thêm Thành Viên</button>
							<button class="btn btn-default btn-lg" type="button">Nhập Lại</button>  
                      </div>
                    </div>
                    
                    
                  </form>
                </div>
              </div>
            </div>
          </div>