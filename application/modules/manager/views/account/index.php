<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>"><?php echo $controller_title ?></a></li>
</ol>
<div class="panel panel-default panel-table">
                <div class="panel-heading">Danh sách</div>
                <div class="panel-body">
                  <table class="table table-striped table-hover">
                    <thead>
                      <tr>
                        <th>Tên Đăng Nhập</th>
                        <th>Bí Danh</th>
                        <th>E-mail</th>
                        <th>Số Điện Thoại</th>
                        <th>Thuộc Nhóm</th>
                        <th>Đăng Nhập Lần Cuối</th>
                        <th>Ngày Tạo</th>
                        <th>Tạo Bởi</th>
                        <th></th>
                        <th class="actions"></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($getcsdl)): ?>
                    <?php foreach($getcsdl as $row): ?>
                      <tr id="id<?php echo $row->id ?>">
                        <td class="user-avatar"> <img src="<?php echo base_url() ?>assets/img/avatar6.png" alt="Avatar"><?php echo $row->username  ?></td>
                        <td><?php echo $row->name  ?></td>
                        <td><?php echo $row->email  ?></td>
                        <td><?php echo $row->phone  ?></td>
                        <td><?php echo $row->roleid  ?></td>
                        <td><?php echo $this->ruadmin->vn_date($row->lastvisited)   ?></td>
                        <td><?php echo $row->created   ?></td>
                        <td><?php echo $row->created_by ?></td>
                        <td>
                            <div class="switch-button switch-button-yesno">
                                <input type="checkbox" <?php echo ($row->status == 1)?'checked="true"':'' ?> id="swt<?php echo $row->id ?>"><span>
                                <label class="status" data-id="<?php echo $row->id ?>" for="swt<?php echo $row->id ?>" data-path="<?php echo base_url($module)."/".$controller ?>/status/<?php echo $row->id ?>"></label></span>
                            </div>
                        </td>
                        <td class="actions">
                        	<?php echo $this->rurole->showPermission("edit",$row->id) ?>
							<?php echo $this->rurole->showPermission("delete",$row->id) ?>
                        </td>
                      </tr>
                    </tbody>
					<?php endforeach ?>
					<?php endif ?>
                  </table>
                </div>
              </div>
<?php $this->load->view("blockmodule/modal_dialog");?>  