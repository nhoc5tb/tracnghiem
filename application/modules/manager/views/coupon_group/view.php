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
    <label style="margin-left: 20px">Chức Năng :</label>
    <div class="btn-group" id="rujs-action">
        <button type="button" class="btn btn-primary">Active Mã</button>
        <button type="button" class="btn btn-danger">Tạm Khóa Mã</button>
        <button type="button" class="btn btn-success">Chuyển Giao Mã</button>
        <button type="button" class="btn btn-warning">Thu Hồi Mã</button>
        <button style="margin-left: 10px" type="button" class="btn btn-default" data-toggle="modal" data-target="#js-md-add-code">Tạo Thêm Mã</button>
    </div>
  </div>                    
  <div class="panel-body">
                
        <table class="table table-striped table-hover" id="table-data">
            <thead>
                <tr>
                  <th style="width:5%;">
                          <div class="be-checkbox be-checkbox-sm">
                            <input id="selectAll" type="checkbox">
                            <label for="selectAll"></label>
                          </div>
                  </th>
                  <th style="width:90px">Thứ Tự</th>
                  <th>Mã</th>
                  <th></th>
                  <th>Mã đơn dùng</th>
                  <th>Ngày tạo</th>
                  <th>Ngày sử dụng</th>                  
                  <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($getcsdl as $row):?>
                <tr id="id<?php echo $row->id ?>">
                  <td>
                    <div class="be-checkbox be-checkbox-sm">
                      <input id="check<?php echo $row->id ?>" type="checkbox" name="idcode" value="<?php echo $row->code ?>"><label for="check<?php echo $row->id ?>"></label>
                    </div>
                  </td>
                  <td align="center"><strong><?php echo $row->id ?></strong></td>                    
                  <td><input type="" value="<?php echo $row->code ?>" class="form-control input-sm" style="width: 100px;"></td>
                  <td>
                      <?php if(!empty($row->id_order)): ?>
                        <button class="btn btn-space btn-default btn-xs">Mã đã dùng</button>
                      <?php else: ?>                        
                        <?php 
                          switch ($row->status) {
                            case '0':
                              echo '<span class="label label-primary">Chưa active</span>';
                              break;
                            case '1':
                              echo '<span class="label label-warning">Active</span>';
                              break;
                            case '2':
                              echo '<span class="label label-danger">Tạm Khóa</span>';
                              break;  
                            default:
                              # code...
                              break;
                          }
                        ?> 
                        <?php 
                          switch ($row->publish) {
                            case '0':
                              echo '<span class="label label-primary">Chưa Chuyển Giao</span>';
                              break;
                            case '1':
                              echo '<span class="label label-warning">Đã Chuyển Giao</span>';
                              break;
                            case '2':
                              echo '<span class="label label-danger">Thu Hồi</span>';
                              break;  
                            default:
                              # code...
                              break;
                          }
                        ?> 
                      <?php endif ?>  
                  </td>
                  <td><?php echo $row->id_order ?></td> 
                  <td><?php echo $row->created_by ?></td>
                  <td><?php echo $row->use_day ?></td>              
                  <td>                       
                      <?php if(empty($row->id_order) && ($row->publish == 0 && $row->status == 0)): ?>
                        <a data-toggle="modal" data-target="#md-footer-danger" class="btn-delete btn btn-primary btn-danger" href="#" class="btn btn-danger ru-js-opendelete" data-id="<?php echo $row->id ?>" data-path="<?php echo base_url($module)."/".$controller ?>/code_clear">Xóa Mã</a>
                      <?php endif ?>
                  </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
        </div>
	</div>
</div>
</div>
 
</div>
<?php $this->load->view("blockmodule/modal_dialog");?>  
<!--Thêm Mã -->
<div id="js-md-add-code" tabindex="-1" role="dialog" class="modal fade" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><span class="mdi mdi-close"></span></button>
          </div>
          <div class="modal-body">
            <div class="modal-body form">
              <div class="form-group">
                <label>Số mã khuyến mãi mà bạn muốn thêm</label>
                <input type="number" name="code_add" value="1" class="form-control">
                <input type="hidden" name="id_group" value="<?php echo $coupon_group->id ?>">
              </div>                       
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-default">Hủy</button>
            <button type="button" data-dismiss="modal" class="btn btn-success ru-js-add" data-path="" >Tạo Thêm Mã</button>
          </div>
        </div>
    </div>
</div>
<!--Thêm Mã--> 



	