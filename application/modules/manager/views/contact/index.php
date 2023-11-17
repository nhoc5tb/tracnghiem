<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>">Quản Trị Viên</a></li>
	<li class="active"><?php echo $title ?></li>
</ol>
<div class="panel panel-default panel-table">
                <div class="panel-heading">Danh sách Trang</div>
                <div class="panel-body">
                  <table class="table table-striped table-hover">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Tên</th>
                        <th>Tiêu đề</th>
                        <th>Nội dung</th>
                        <th>Số ĐT</th>
                        <th class="actions"></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 									
					foreach($getcsdl as $key=>$row): ?>	
						<tr id="id<?php echo $row->id ?>">
							<td>
							<?php 
								echo $key+1;
							?>                            
              </td>
              <td>
                <strong><?php echo $row->name ?></strong>
                <p style="color:#929090;font-size:11px">
                  <span> » E-mail:</span> <?php echo $row->email ?> <br>
                  <span> » Ngày gửi</span> <?php echo $row->created ?>
                </p>
              </td>
              <td>
                <a href="<?php echo base_url().$module ?>/contact/view/<?php echo $row->id ?>"><strong><?php echo $row->subject ?></strong></a>                           		
              </td>
              <td><?php echo $this->ruadmin->cutString($row->message,300) ?></td>
              <td><strong><?php echo $row->phone ?></strong></td>
              <td>
                <a class="btn btn-success" href="<?php echo base_url().$module ?>/contact/view/<?php echo $row->id ?>">Xem Chi Tiết</a>  
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
