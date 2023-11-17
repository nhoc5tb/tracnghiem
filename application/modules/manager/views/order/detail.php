<style type="text/css">
  .timeline:before{
    left: 93px;
  }
  .timeline-date{
    width: 80px;
  }
  .timeline-item{
    padding-left: 115px;
  }
  .timeline-item:before{    
    left: 85px;
  }
</style>
<div class="main-content container-fluid">      
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
    <li><a href="<?php echo base_url().$module."/".$controller?>">Quản Trị Viên</a></li>
    <li class="active"><?php echo $title ?></li>
  </ol>
  <div class="row">
    <div class="col-sm-8">
      <div class="panel panel-default">
        <div class="panel-heading">Thông Tin</div>
        <div class="panel-body">
          <table class="table table-condensed table-bordered ">
            <tbody>
              <tr>
                <td colspan="2"><b>Tên khách hàng:</b> <?php echo $order->name ?></td>
              </tr>
              <tr>
                <td colspan="2"><b>Địa chỉ:</b> <?php echo $order->address.", ".$order->ward.", ".$order->district.", ".$order->province ?></td>
              </tr>
              <tr>
                <td><b>Điện thoại : </b> <?php echo $order->phone ?></td>                
                <td><b>E-mail :</b> <?php echo $order->email ?></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="panel-heading">Đơn hàng <strong>#<?php echo $order->code_view ?></strong></div>
        <div class="panel-body">
          <table class="table table-condensed table-hover table-bordered table-striped">
             <thead>
              <tr>
                <th>#</th>
                <th>Mã</th>
                <th>Tên</th>
                <th class="number">Giá</th>
                <th class="number">Số Lượng</th>
                <th class="number">Thành tiền</th>
              </tr>
             </thead>
             <tbody>
             <?php 
              $stt = 1;
              foreach($order_detail as $row):?>
              <tr>
                <td><?php echo $stt ?></td>
                <td><?php echo $row->code ?></td>
                <td><?php echo $row->name ?></td>
                <td class="number"><?php echo number_format((int)$row->price, 0, ',', '.') ?> đ</td>
                <td class="number"><?php echo $row->qty ?></td>               
                <td class="number"><?php echo number_format((int)$row->price * (int)$row->qty, 0, ',', '.') ?> đ</td>
              </tr>                                       
            <?php 
               $stt++;
               endforeach ?> 
                      </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="6"></td>
                      </tr> 
                      <tr>
                        <td colspan="5" class="number">Tổng tiền</td>
                        <td colspan="2"><strong><?php echo number_format((int)$order->total_order, 0, ',', '.') ?> đ</strong></td>
                      </tr>
                      <tr>
                        <td colspan="5" class="number">Phí vận chuyển</td>
                        <td colspan="2"><strong><?php echo number_format((int)$phiship, 0, ',', '.') ?> đ</strong></td>
                      </tr> 
                      <?php if(!empty($order->coupon)): ?>
                      <tr>
                        <td colspan="5" class="number">Mã khuyến mãi : <?php echo $coupon->code ?></td>                        
                        <td colspan="2"><strong> - <?php echo number_format((int)$coupon->value, 0, ',', '.') ?> đ</strong></td>
                      </tr>
                          <?php if($coupon->free_ship): ?>
                      <tr>
                        <td colspan="5" class="number">Mã khuyến mãi có Free Ship :</td>                        
                        <td colspan="2"><strong> - <?php echo number_format((int)$phiship, 0, ',', '.') ?> đ</strong></td>
                      </tr>   
                          <?php endif ?>                                 
                      <?php endif ?>
                      <tr>
                        <td colspan="5" class="number">Thực Trả</td>
                        <td colspan="2"><strong><?php echo number_format((int)$thuctra, 0, ',', '.') ?> đ</strong></td>
                      </tr>
                    </tfoot>
          </table>
          
          <div class="panel-heading">Ghi chú</div>

          <div class="panel-body">
            <?php echo nl2br($order->review_note) ?>
          </div>
          <form action="#" style="border-radius: 0px;" class="form-horizontal group-border-dashed"   method="post" enctype="multipart/form-data">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" />
               <div class="form-group">                      
                  <div class="col-sm-6">
                    <select class="select2"  name="status">  
                      <option value="1" <?php echo set_select('status', $order->status, (!empty($order) && $order->status == 1)) ?>>Hoàn thành</option>  
                      <option value="2" <?php echo set_select('status', $order->status, (!empty($order) && $order->status == 2)) ?>>Đơn bị hủy</option>  
                      <option value="3" <?php echo set_select('status', $order->status, (!empty($order) && $order->status == 3)) ?>>Chưa xử lý</option>  
                    </select>
                  </div>   
                  <div class="col-sm-6">
                    <button class="btn btn-space btn-primary btn-lg" type="submit">Thay Đổi Trạng Thái Đơn</button>
                  </div>  
            </div>
          </form>  
          <div class="form-group" style="display: none">  
            <button data-id="<?php echo base_url().$module."/".$controller."/order_print?action=print&code=".$order->code_view;?>" class="btn btn-lg btn-space btn-default btn-print"><span class="mdi mdi-print"></span> Xuất Bản In</button>
            
          </div>
          
        </div>        
        
      </div>
      
      
      
   
    </div>
    <div class="col-sm-4">      
      <ul class="timeline">
      <?php foreach($log as $row): ?>
        <li class="timeline-item">
          <div class="timeline-date"><span><?php echo date_format(date_create($row->created),"d/m/Y"); ?></span></div>
          <div class="timeline-content">
            <div class="timeline-avatar"><img src="<?php echo base_url() ?>assets/img/avatar6.png" alt="Avatar" class="circle"></div>
            <div class="timeline-header"><span class="timeline-time"><?php echo date_format(date_create($row->created),"H:i:s"); ?></span>
            <span class="timeline-autor"><?php echo $row->created_by ?></span>
            <br>
            <p class="timeline-activity"><?php echo $row->content ?></p>
            </div>
          </div>
        </li>                
      <?php endforeach ?>
      </ul>
    </div>    
  
</div>


<iframe style="display: none" id="printf"></iframe>


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
  <!-- Nifty Modal-->
<div id="form-action" class="modal-container colored-header colored-header-success custom-width modal-effect-9">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
      <h3 class="modal-title">Thông Báo</h3>
    </div>
    <div class="modal-body form">
                        
    </div>
    <div class="modal-footer">
      <button type="button" data-dismiss="modal" class="btn btn-default modal-close">Cancel</button>
      <button type="button" data-dismiss="modal" class="btn btn-success">Proceed</button>
    </div>
  </div>
</div>
<div class="modal-overlay"></div>     
                                                     