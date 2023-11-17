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
<script type="text/javascript" src="<?php echo base_url() ?>assets/lib/datetimepicker/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/lib/datetimepicker/js/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/lib/datetimepicker/css/daterangepicker.css" />


<script type="text/javascript">
  
$(function() {
  $('input[name="daterange"]').daterangepicker({
    opens: 'left',
    ranges: {
           'Hôm nay': [moment(), moment()],
           'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           '7 Ngày quá': [moment().subtract(6, 'days'), moment()],
           '30 Ngày quá': [moment().subtract(29, 'days'), moment()],
           'Tháng này': [moment().startOf('month'), moment().endOf('month')],
           'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
    locale: {
      format: 'DD/MM/YYYY'
    }
  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });

});
</script>

<div class="main-content container-fluid">      
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
            <input type="text" class="form-control input-xs input-search" value="<?php echo $q ?>" style="width: 450px;float: left;height: 30px;display: inline-block" placeholder="Tìm kiếm đơn (tên KH, số ĐT, Địa chỉ, email, mã đơn ...)">
            <button type="button" class="btn btn-primary btn-search" style="border-radius: 0">Tìm Đơn</button></span>
          </div>
                                  
                  <div class="tools" style="float: right;margin-left: 10px;display: none;">
                  <?php
                    $action = $this->input->get("ac");
                    switch($action){
                      case "chuagiao";
                        $action = "Đã Chốt";
                        break;
                      case "trengay";
                        $action = "Trễ Ngày";
                        break;
                      case "conno";
                        $action = "Còn Nợ";
                        break;
                      case "dathanhtoan";
                        $action = "Đã Thanh Toán";
                        break;
                      case "baogia";
                        $action = "Báo Giá";
                        break;
                      case "dahuy";
                        $action = "Đã Hủy";
                        break;  
                      case "xuatvat";
                        $action = "Danh sách VAT";
                        break;    
                      default:
                        $action = "Tất cả";
                        break;
                    }
                    ?>
                    <div class="btn-group btn-hspace">
                            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><?php echo $action ?> <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                            <ul role="menu" class="dropdown-menu pull-right">
                              <li><a href="#" class="loc" data-action="all">Tất cả</a></li>
                              <li style="background: #fac2a4"><a href="#" class="loc" data-action="chuagiao">Chưa xem</a></li>
                              <li style="background: #fc7878"><a href="#" class="loc" data-action="trengay">Hoàn thành</a></li>                             
                              <li style="background: #eaa5fb"><a href="#" class="loc" data-action="conno">Đơn bị hủy</a></li>
                              <li style="background: #c5c6c6"><a href="#" class="loc" data-action="dahuy">Chưa xử lý</a></li>
                            </ul>
                          </div>
                  </div>
                  <?php
            if(!empty($this->input->get("start")) && !empty($this->input->get("end"))):
          ?>
            <input type="text" class="form-control input-xs" style=" float: right; width: 185px;display: none;" name="daterange" value="<?php echo $this->input->get("start"); ?> - <?php echo $this->input->get("end") ?>" />
          <?php
            else:
          ?>
            <input type="text" class="form-control input-xs" style=" float: right; width: 185px;display: none;"" name="daterange" value="" />
          <?php 
            endif; 
          ?>
                  
                    
                  
                </div>
                <div class="panel-body">
                  <table class="table table-striped table-hover">
                    <thead>
                      <tr>                        
                        <th style="width:15%;">Mã Đơn</th>
                        <th style="width:10%;">Trạng Thái Đơn</th>
                        <th style="width:13%;">Khách Hàng</th>
                        <th style="width:10%;">Tổng Tiền</th>                 
                        <th style="width:10%;"></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
                    if(!empty($getcsdl) > 0):
                    foreach($getcsdl as $row):
                        switch ($row->status) {
                          case '0':
                            $background = "border-left: 3px solid #a5d6fb";
                            $status = "<strong style='background: #a5d6fb;'>Chưa xem</strong>";
                            break;
                          case '1':
                            $background = "border-left: 3px solid #fac2a4";
                            $status = "<strong style='background: #fac2a4;'>Hoàn thành</strong>";
                            break;
                          case '2':
                            $background = "border-left: 3px solid #c5c6c6";
                            $status = "<strong style='background: #c5c6c6;'>Đơn bị hủy</strong>";
                            break; 
                          case '3':
                            $background = "border-left: 5px solid #eaa5fb";
                            $status = "<strong style='background: #eaa5fb;'>Chưa xử lý</strong>";
                            break;  
                          default:
                            # code...
                            break;
                        }                
                     ?>
                      <tr class="online" id="id<?php echo $row->id ?>">                       
                        <td class="user-avatar cell-detail user-info" style="<?php echo $background?>;">
                          <span><strong><?php echo $row->code_view ?></strong></span>
                          <span class="cell-detail-description">Tạo ngày : <strong><?php echo $row->created ?></strong></span>
                        </td>
                        
                        <td class="cell-detail status"> 
                          <span>Tình trạng : <?php echo $status;?></span>
                        </td>
                        
                        <td class="cell-detail"> 
                          <span><strong><?php echo $row->name ?></strong></span>
                          <span class="cell-detail-description">Số Phone : <strong><?php echo $row->phone ?></strong></span>  
                        </td>
                        
                        <td class="cell-detail"> 
                          <span class="cell-detail-description">Tổng tiền : <strong><?php echo number_format((int)$row->total_order, 0, ',', '.') ?> đ</strong></span>
                          <?php if(!empty($row->coupon)): ?>
                          <span class="cell-detail-description">Sử dụng Coupon : <strong><?php echo $row->coupon; ?></strong></span>
                          <?php endif ?>
                          <span><strong><?php echo number_format((int)$row->total_order - (int)$row->sale, 0, ',', '.') ?> đ</strong></span>
                        </td>    
                        <td class="text-right">
                          <div class="btn-group btn-hspace">
                            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Chức Năng <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                            <ul role="menu" class="dropdown-menu pull-right">                                                                               
                              <li>
                                <a href="<?php echo base_url().$module."/".$controller."/detail/".$row->code_view ?>">
                                <span class="mdi mdi-eye" style="font-size: 18px;width: 20px"></span> &nbsp; Mở đơn hàng</a>
                              </li>
                              <?php
                                if($row->status != "1"):
                              ?>
                              <li class="divider"></li>
                              <li><a href="#" style="color: #EB0003;font-weight: 600;" class="btn-index-canel-order" data-id="<?php echo $row->code_view ?>"><span class="mdi mdi-delete" style="font-size: 18px;width: 20px"></span> Hủy Đơn</a></li>
                              <?php endif ?>
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
                      
               
              
             