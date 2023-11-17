<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>"><?php echo $controller_title ?></a></li>
</ol>
<div class="panel panel-default panel-table">
                <div class="panel-heading">Danh sách Trang</div>
                <div class="panel-body">
                  <table class="table table-striped table-hover">
                    <thead>
                      <tr>
                       	<th>Tên Mail</th>
                        <th>Tiêu đề</th>
                        <th>Người tạo</th>
                        <th>Ngày tạo</th>
                        <th>Sửa Lần Cuối</th>
                        <th>Người sửa</th>
                        <th>Trạng thái</th>
                        <th class="actions"></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 									
					foreach($getcsdl as $row): ?>	
						<tr id="id<?php echo $row->id ?>">							
							<td><strong><?php echo $row->name ?></strong></td>
                          	<td><?php echo $row->subject ?></td>
                           	<td><?php echo $row->created_by ?></td>
                            <td><?php echo $row->created ?></td>
                            <td><?php echo $row->modified ?></td>
                            <td><?php echo $row->modified_by ?></td>
                            <td>
                            	<div class="switch-button switch-button-yesno">
                                    <input type="checkbox" <?php echo ($row->status == 1)?'checked="true"':'' ?> id="swt<?php echo $row->id ?>"><span>
                                    <label class="status" data-id="<?php echo $row->id ?>" for="swt<?php echo $row->id ?>" data-path="<?php echo base_url($module)."/".$controller ?>/status/<?php echo $row->id ?>"></label></span>
                                </div>
                            </td>
                            <td>                                            	
                                <?php echo $this->rurole->showPermission("edit",$row->id) ?>
                             </td>
						</tr>
                        <?php endforeach ?> 
                  </table>
                </div>
              </div>
              <div class="pagination">
              	<?php echo $pagination ?>
              </div>
              
              
<?php $this->load->view("blockmodule/modal_dialog");?>
