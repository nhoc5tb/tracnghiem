<style type="text/css">
	.table tbody tr td.user-info span{
		padding-left: 10px;
	}
	.table-striped .status span:nth-child(2) strong{
		display: inline-block;
		padding: 2px;
		padding-left: 5px;
		padding-right: 5px;
	}
</style>
<div class="panel panel-default panel-table">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
		<li><a href="<?php echo base_url().$module."/".$controller?>">Quản Trị Viên</a></li>
		<li class="active"><?php echo $title ?></li>
	</ol>
	<div class="row">
		 <!--Responsive table-->
            <div class="col-sm-12">
              <div class="panel panel-default panel-table">
               
                <div class="panel-heading">                    						
					
					<div class="input-group xs-mb-15" style="float: left;">
					<?php
						if($this->input->get("q")){
							$q = $this->input->get("q");
						}else{
							$q = null;
						}
					?>	
						<input type="text" class="form-control input-xs input-search" value="<?php echo $q ?>" style="width: 450px;float: left;height: 30px;display: inline-block" placeholder="Tìm kiếm đơn (tên KH, số ĐT, Địa chỉ, email, ...)">
						<button type="button" class="btn btn-success btn-search" style="border-radius: 0">Tìm Khách Hang</button></span>
					</div> 
               		
                </div>
                <div class="panel-body">
                  <table class="table table-striped table-hover">
                    <thead>
                      <tr>                        
                        <th style="width:10%;">Mã KH</th>
                        <th style="width:15%;">Khách Hàng</th>
                        <th style="width:15%;">Địa chỉ</th>                    
                        <th style="width:10%;"></th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php 
	
						if(!empty($getcsdl) > 0):
						foreach($getcsdl as $row):
			   				$background = "border-left: 3px solid #a5d6fb";
								$status = "<strong style='background: #a5d6fb;'>Báo giá</strong>";
			   
                     ?>
                      <tr class="online" id="id<?php echo $row->id ?>">                       
                        <td class="user-avatar cell-detail user-info" style="<?php echo $background?>;">
                        	<span><strong><?php echo $row->code ?></strong></span>
                        	<span class="cell-detail-description">Tạo bởi : <strong><?php echo $row->created_by ?></strong></span>
                        	<span class="cell-detail-description">Tạo ngày : <strong><?php echo $row->created ?></strong></span>
                        </td>
                        
                        <td class="cell-detail status"> 
                        	<span>Tên KH  : <strong><?php echo $row->name ?></strong></span>
                        	<span>Sô ĐT: <strong><?php echo $row->phone ?></strong></span>
                        	<span>E-mail: <strong><?php echo $row->email ?></strong></span>
                        </td>
                        
                        <td class="cell-detail">                         	
                        	<strong><?php echo $row->address ?></strong></span>
                        </td>
                        
                        <td class="text-right">
                          <div class="btn-group btn-hspace" style="display: none;">
                            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Chức Năng <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                            <ul role="menu" class="dropdown-menu pull-right">     
                              <li><a href="<?php echo base_url().$module."/".$controller."/sale_detail?code=".base64_encode($row->code) ?>">
									<span class="mdi mdi-eye" style="font-size: 18px;width: 20px"></span> &nbsp; Xem Khách KH</a>
                              </li>                             
                              <li class="divider"></li>
                              <li><a href="#" style="color: #EB0003;font-weight: 600;" class="btn-index-canel-order" data-id="<?php echo $row->code ?>"><span class="mdi mdi-delete" style="font-size: 18px;width: 20px"></span> Xóa KH</a></li>
                            </ul>
                          </div>
                        </td>
                      </tr>
                     <?php endforeach ?> 
                     <?php endif ?>  
                    </tbody>
                  </table>
                </div>
                
                <div class="pagination">
        	<?php echo $pagination ?>
          </div>
                
              </div>
            </div>
            
            
            
            
          </div>
          
          
          
        </div>	
        	
	</div><!-- row -->
</div>

<!-- thông báo trả về <button data-modal="full-primary" class="btn btn-space btn-primary md-trigger">Primary</button> -->
<div id="open-erro" class="modal-container modal-full-color modal-full-color-primary modal-effect-8">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
                      </div>
                      <div class="modal-body">
                        <div class="text-center"><span class="modal-main-icon mdi mdi-info-outline"></span>
                          <h3>Thông Báo Từ Hệ Thống</h3>
                          <p></p>
                         
                          <div class="xs-mt-50">
                            <button type="button" data-dismiss="modal" class="btn btn-default btn-space modal-close">Thoát</button>
                            <button type="button" data-dismiss="modal" class="btn btn-success btn-space modal-close">Đồng Ý</button>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer"></div>
                    </div>
                  </div>      
 <?php $this->load->view("blockmodule/modal_dialog");?>                        
               
              
             