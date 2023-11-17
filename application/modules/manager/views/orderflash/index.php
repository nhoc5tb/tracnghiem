<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>">Đơn Hàng</a></li>
	<li class="active"><?php echo $title ?></li>
</ol>
<div class="panel panel-default panel-table">
                <div class="panel-heading">Danh sách đơn hàng</div>
                <div class="panel-body">
                  <table class="table table-striped table-hover">
                    <thead>
                      <tr>
                        <th>Tên Khách Hàng</th>
                        <th>Thông Tin</th>
                        <th>Ngày Gửi</th>
                        <th>Trạng Thái</th>
                        <th class="actions"></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach($getcsdl['dataset'] as $row): ?>	
						<tr
						<?php 
							switch($row->status){
								case '0':
									echo ' style="background:#EFA565"';
									break;
								case '1':
									echo ' style="background:#F57375"';
									break;	
								case '2':
									echo ' style="background:#ABD882"';
									break;	
								case '4':
									echo ' style="color:#B9B9B9"';
									break;			
							}
						?>
                        >
							<td> <strong> <?php echo $row->name ?></strong> </td>
							<td><strong><?php echo $this->rulib->cutString($row->content,260) ?></strong></td>
                            <td>
							<?php echo $row->created ?>	
                            </td>
                            <td>
								<?php 
												switch($row->status){	//0 chưa kích hoạt - 2 đã kích hoạt - 3 đã đặt cọc - 1 đã hoàn thành
													case '0':
														echo 'Chưa xem';
														break;
													case '1':
														echo 'Đã hoàn thành';
														break;
													case '2':
														echo 'Đã xử lý';
														break;
													case '3':
														echo 'Đã huỷ đơn';
														break;	
													case '4';
														echo 'Chưa xử lý';
														break;
													case '5';
														echo 'Đã xem';
														break;	
															
												}?>
                            </td>
                            <td>                                            	
                                <a class="btn btn-lg btn-space btn-primary" href="<?php echo base_url().$module.'/OrderFlash/detail/'.$row->id ?>">Xem Đơn</a>
                             </td>
						</tr>
                    <?php endforeach ?> 
                  </table>
                </div>
                <div><?php echo $pagination ?></div>
              </div>


 <!--Thông báo xóa -->
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
              <p class="msg">Bạn có thực sử muốn xóa</p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-default">Không</button>
            <button type="button" data-dismiss="modal" class="btn btn-danger rbtn-ajaxdelete"  data-path="" >Đúng ! Tôi muốn xóa</button>
          </div>
        </div>
      </div>
    </div>
<!--Thông báo xóa-->   