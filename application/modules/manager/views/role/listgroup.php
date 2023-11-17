<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>">Phân Quyền</a></li>
	<li class="active"><?php echo $title ?></li>
</ol>

<div class="panel panel-default panel-table">
                <div class="panel-heading">
                	Danh Sách Nhóm Quản Trị
                	<div class="tools">
                    	<button data-toggle="modal" data-target="#form-bp1" type="button" class="btn btn-space btn-primary">Tạo Nhóm Quản Trị</button>
                    </div>
                </div>
                
                
                <div class="panel-body">
                  <table class="table table-striped table-borderless">
                    <thead>
                      <tr>
                        <th style="width:50%;">Tên Nhóm</th>
                        <th style="width:10%;">Ngày Tạo</th>
                        <th class="number">Trạng Thái</th>
                        <th class="actions"></th>
                      </tr>
                    </thead>
                    <tbody class="no-border-x">
                    <?php if(!empty($getcsdl)): ?>
                    <?php foreach($getcsdl as $row): ?>
                    <?php if($row->role_id > 1 ): ?>
                      <tr>
                        <td><?php echo $row->role_name ?></td>
                        <td>n/a</td>
                        <td class="number"><?php echo $this->ruadmin->status($row->role_status) ?></td>
                        <td class="actions">
                        	<div class="btn-group">
                            	<button 
                                type="button" 
                                class="btn btn-primary rbtn-edit" 
                                data-id="<?php echo $row->role_id ?>" 
                                data-name="<?php echo $row->role_name ?>" 
                                data-status="<?php echo $row->role_status ?>" 
                                data-toggle="modal" data-target="#form-bp2" 
                                data-parent_id="<?php echo $row->parent_id ?>">Sửa</button>
                                <button data-toggle="modal" data-target="#md-footer-danger" type="button" data-id="<?php echo $row->role_id ?>" class="btn btn-space btn-danger rbtn-delete">Xóa</button>
                                <?php if($row->role_status > 0):?>
                                <a href="<?php echo base_url($module)."/".$controller ?>/Permission/<?php echo $row->role_id ?>" class="btn btn-primary">Cấp Quyền</a>
                                <?php else: ?>
                                <a  class="btn btn-default">Đang Khóa</a>
                                <?php endif ?>
                        	</div>
                        </td>
                      </tr>
					<?php endif ?>
					<?php endforeach ?>
					<?php endif ?>
                    </tbody>
                  </table>
                </div>
              </div>

<!-- Form Add -->
    <div id="form-bp1" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-primary">
      <div class="modal-dialog custom-width">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
            <h3 class="modal-title">Thêm Nhóm Quản Trị</h3>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Tên nhóm</label>
              <input type="email" placeholder="Tên nhóm quản trị" name="role_name" class="form-control">
            </div>
            <div class="form-group">
				<label>Nhóm Cha</label>
				<select class="form-control" name="parent_id">
					<option> -----------</option>
                    <?php if(!empty($getcsdl)): ?>
                    <?php foreach($getcsdl as $row): ?>
                    <?php if($row->role_id > 1 ): ?>
					<option value="<?php echo $row->role_id ?>"><?php echo $row->role_name ?></option>
					<?php endif ?>
					<?php endforeach ?>
					<?php endif ?>
				</select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-default md-close">Thoát</button>
            <button type="button" data-dismiss="modal" data-path="<?php echo base_url($module)."/".$controller ?>/ListGroup_ajax_insert" class="btn btn-primary md-close rbtn-add">Thêm</button>
          </div>
        </div>
      </div>
    </div>              

<!--Form Edit-->
    <div id="form-bp2" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-primary">
      <div class="modal-dialog custom-width">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close"><span class="mdi mdi-close"></span></button>
            <h3 class="modal-title">Sửa Nhóm Quản Trị</h3>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Tên nhóm</label>
              <input type="text" placeholder="Tên nhóm quản trị" name="role_name" class="form-control">
            </div>
            <div class="form-group">
				<label>Nhóm Cha</label>
				<select class="form-control" name="parent_id">
					<option> -----------</option>
                    <?php if(!empty($getcsdl)): ?>
                    <?php foreach($getcsdl as $row): ?>
                    <?php if($row->role_id > 1 ): ?>
					<option value="<?php echo $row->role_id ?>"><?php echo $row->role_name ?></option>
					<?php endif ?>
					<?php endforeach ?>
					<?php endif ?>
				</select>
            </div>
            <div class="form-group">
				<label>Trạng thái</label>
				<select class="form-control" name="role_status">
					<option value="1"> Hoạt Động </option>
                    <option value="0"> Tạm Ngưng </option>
				</select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-default md-close">Thoát</button>
            <button type="button" data-dismiss="modal" data-path="<?php echo base_url($module)."/".$controller ?>/ListGroup_ajax_edit" class="btn btn-primary md-close rbtn-ajaxedit">Cập Nhật</button>
          </div>
        </div>
      </div>
    </div>     

<!--Thông báo-->
<div id="md-footer-danger" tabindex="-1" role="dialog" class="modal fade" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><span class="mdi mdi-close"></span></button>
          </div>
          <div class="modal-body">
            <div class="text-center">
              <div class="text-danger"><span class="modal-main-icon mdi mdi-close-circle-o"></span></div>
              <h3>Cảnh Báo !</h3>
              <p>Bạn có thực sử muốn xóa nhóm quản trị</p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-default">Không</button>
            <button type="button" data-dismiss="modal" class="btn btn-danger rbtn-ajaxdelete"  data-path="<?php echo base_url($module)."/".$controller ?>/ListGroup_ajax_delete" >Đúng ! Tôi muốn xóa</button>
          </div>
        </div>
      </div>
    </div>