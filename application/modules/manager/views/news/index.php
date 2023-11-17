<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>"><?php echo $controller_title ?></a></li>
</ol>
<div class="panel panel-default panel-table">
                <div class="panel-heading">Danh sách
                	<div class="tools">                        
                        <div class="btn-group btn-hspace" style="float:left;margin-right:10px">
                   			 <button type="button" data-toggle="dropdown" class="btn btn-success dropdown-toggle"><?php echo $cur_catalog ?> <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                   			 <ul role="menu" class="dropdown-menu">
                             	<li><a href="<?php echo base_url().$module ?>/news">Tìm tất cả</a></li>
                             <?php	foreach($catalogs as $row): ?>
                             	<li><a href="<?php echo base_url().$module ?>/news/?catalogs=<?php echo $row->id ?>"><?php echo $row->title ?></a></li>
                             <?php	
							 endforeach;
                             ?>
                   			 </ul>
                        </div>
                        
                        <div style="float:left;">
                   			 <a class="btn-edit btn btn-primary" href="<?php echo base_url().$module ?>/news/add" style="float:right">Thêm Tin Tức</a>
                     	</div>
                        
                     </div>
                </div>
                <div class="panel-body">
                  <table class="table table-striped table-hover">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Tiêu đề</th>
                        <th>Chuyên mục</th>
                        <th>Người tạo</th>
                        <th>Ngày tạo</th>
                        <th>Trạng thái</th>
                        <th class="actions"></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 								
					foreach($getcsdl as $row): ?>
						<tr id="id<?php echo $row->id ?>">
							<td>
							<?php 
								if(!empty($row->image)):
							?>
								<img src="<?php echo $this->ruadmin->geturlimg($row->image,$config_upload["dirweb"]); ?>" width="130" />
							<?php endif ?>
                            
                            </td>
							<td><a href="<?php echo base_url().$row->slug_catalogs."/".$row->slug ?>.html" title="Xem bài" target="_blank"><strong><?php echo $row->title ?></strong></a></td>
                            <td><?php echo $row->catalog  ?></td>
                            <td><?php echo $row->modified_by ?></td>
                            <td><?php echo $row->modified ?></td>
                            <td>
                            	<div class="switch-button switch-button-yesno">
                                    <input type="checkbox" <?php echo ($row->status == "1")?'checked="true"':"" ?> id="swt<?php echo $row->id ?>"><span>
                                    <label class="status" data-id="<?php echo $row->id ?>" for="swt<?php echo $row->id ?>" data-path="<?php echo base_url($module)."/".$controller ?>/status/<?php echo $row->id ?>"></label></span>
                                </div>
                            </td>
                            <td>                                            	
                                <?php echo $this->rurole->showPermission("edit",$row->id) ?>
                        		<?php echo $this->rurole->showPermission("delete",$row->id) ?>
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