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
                    <th>Tên</th>
                    <th></th>
                    <th>Giảm</th>
                    <th>Tối đa</th>
                    <th>Số lần sử dụng</th>
                    <th>Ngày tạo</th>
                    <th>Người tạo</th>
                    <th>Hoạt Động</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($getcsdl as $row):?>
                <tr id="id<?php echo $row->id ?>">
                    <td align="center"><strong><?php echo $row->id ?></strong></td>                    
                    <td><strong><?php echo $row->name ?></strong></td>
                    <td><a class="btn-edit btn btn-primary" href="<?php echo base_url($module)."/".$controller ?>/view/<?php echo $row->id ?>">Lấy Mã</a></td>
                    <td><?php echo $row->discount ?></td>
                    <td><?php echo $row->max_amount ?></td>
                    <td><?php echo $row->limit_user ?></td>
                    <td><?php echo $row->created ?></td>
                    <td><?php echo $row->created_by ?></td>
                    <td>
                        <div class="switch-button switch-button-yesno">
                            <input type="checkbox" <?php echo ($row->status == 1)?'checked="true"':'' ?> id="swt<?php echo $row->id ?>"><span>
                            <label class="status" data-id="<?php echo $row->id ?>" for="swt<?php echo $row->id ?>" data-path="<?php echo base_url($module)."/".$controller ?>/status/<?php echo $row->id ?>"></label></span>
                        </div>
                    </td>
                    <td>
                        <?php echo $this->rurole->showPermission("edit",$row->id."?token=".$ru_csrf_token_name) ?>
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
                <div class="panel-heading panel-heading-divider">Thêm Nhóm Mã Khuyến Mãi</div>
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
                    
                  <form action="<?php echo base_url().$module.'/'.$controller ?>"  style="border-radius: 0px;" class="form-horizontal group-border-dashed"  method="post" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" />
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Tên nhóm</label>
                      <div class="col-sm-6">
                        <input name="name" value="<?php echo set_value('name');?>" parsley-trigger="change" required="" placeholder="" autocomplete="off" class="form-control input-sm" type="text">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Tiền Tố<br>là mã bắt đầu của code</label>
                      <div class="col-sm-6">
                        <input name="code" value="<?php echo set_value('code');?>" parsley-trigger="change" required="" placeholder="" autocomplete="off" class="form-control input-sm" type="text" style="max-width:200px">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Giảm</label>
                      <div class="col-sm-6">
                        <input name="discount" value="<?php echo set_value('discount');?>" placeholder="" class="form-control input-sm" type="text">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Loại giảm</label>
                      <div class="col-sm-6">
                        <select class="select2"  name="type">
                          <option value="1">Giảm %</option> 
                          <option value="2">Số tiền</option> 
                        </select>
                      </div>
                    </div>      

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Chi tiêu tối thiểu</label>
                      <div class="col-sm-6">
                        <input name="min_payments" value="<?php echo set_value('min_payments');?>" placeholder="" class="form-control input-sm" type="text" style="max-width:200px">
                      </div>
                    </div>  

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Giảm tố đa</label>
                      <div class="col-sm-6">
                        <input name="max_amount" value="<?php echo set_value('max_amount');?>" placeholder="" class="form-control input-sm" type="text" style="max-width:200px">
                      </div>
                    </div>              
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">User được dùng / lần</label>
                      <div class="col-sm-6">
                        <input name="limit_user" value="1" value="<?php echo set_value('limit_user');?>" style="max-width:100px" min="1" max="500" class="form-control input-sm" type="number">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Số lần mã được dùng</label>
                      <div class="col-sm-6">
                        <input name="limit_coupon" value="1" value="<?php echo set_value('limit_coupon');?>" style="max-width:100px" min="1" max="1500" class="form-control input-sm" type="number">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Miễn phí Ship</label>
                      <div class="col-sm-6 xs-pt-5">
                        <div class="switch-button switch-button-success">
                          <input name="free_ship" type="checkbox" id="free_ship"><span>
                            <label for="free_ship"></label></span>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Dùng chung mã #</label>
                      <div class="col-sm-6 xs-pt-5">
                        <div class="switch-button switch-button-warning">
                          <input type="checkbox" name="share_code" id="share_code"><span>
                            <label for="share_code"></label></span>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label"> Ngày hết hạn </label>
                      <div class="col-md-3 col-xs-7">
                        <div data-min-view="2" data-date-format="yyyy-mm-dd" class="input-group date datetimepicker">
                          <input name="expiry_date" size="16" type="text" value="<?php echo set_value('expiry_date');?>" class="form-control input-sm">
                          <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></span>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Số mã cần tạo</label>
                      <div class="col-sm-6">
                        <input name="number_codes" value="10" style="max-width:100px" min="1" max="1500" class="form-control input-sm" type="number">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label"></label>
                      <div class="col-sm-6">
                      		<button class="btn btn-primary btn-lg" type="submit">Thêm Mã</button>
							<button class="btn btn-default btn-lg" type="button">Nhập Lại</button>  
                      </div>
                    </div>
                    
                    
                  </form>
                </div>
              </div>
            </div>

<?php $this->load->view("blockmodule/modal_dialog");?>  



	