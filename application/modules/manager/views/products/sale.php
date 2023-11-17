<script type="text/javascript">
  $(document).ready(function(e) {
        $('.input-price').dblclick(function(){      
      $.ajax({//ajax
        type: "POST",
        data:{ 
            'id_product':   $(this).attr('data-id'),
            'price' : stringToint($(this).val()),
            'ru_csrf_token_name':ru_csrf_token_name
        },
        url: '<?php echo base_url().$module ?>/products/ajax_price',
        success: function(data){
           $.gritter.add({
            title: 'Hệ Thống',
            text: data.content,
            class_name: 'color success'
           });
        },
        error: function() {
          console.log('Không thể sử lý, thử lại hoặc vào trang sửa sản phẩm');
        }
      });//#ajax
    });
    function stringToint(string){ 
      string = Number(string.replace(/[^0-9\,-]+/g,""));
      string = parseInt(string);
      if(isNaN(string)){
         return 0;
       }      
       else{
         return string;
       }   
    }
    });
</script>

<ol class="breadcrumb">
  <li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
  <li><a href="<?php echo base_url().$module."/".$controller?>">Quản Trị Viên</a></li>
  <li class="active"><?php echo $title ?></li>
</ol>
<div class="panel panel-default panel-table">
                <div class="panel-heading">Danh sách
                  <div class="tools">                        
                        <div class="btn-group btn-hspace" style="float:left;margin-right:10px">
                         <button type="button" data-toggle="dropdown" class="btn btn-success dropdown-toggle"><?php echo $cur_catalog ?> <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                         <ul role="menu" class="dropdown-menu">
                              <li><a href="<?php echo base_url().$module ?>/products">Tìm tất cả</a></li>
                             <?php  foreach($catalogs as $row): ?>
                              <li><a href="<?php echo base_url().$module ?>/products/?filter=<?php echo $row->id ?>"><?php echo $row->title ?></a></li>
                             <?php endforeach;?>
                         </ul>
                        </div>
                        
                        <div style="float:left;">
                         <a class="btn-edit btn btn-primary" href="<?php echo base_url().$module ?>/products/add" style="float:right">Thêm Mặt Hàng</a>
                      </div>
                        
                     </div>
                </div>
                <div class="panel-body">
                  <table class="table table-striped table-hover">
                    <thead>
                      <tr>
                        <th style="width:130px"></th>
                        <th>Tiêu đề</th>
                        <th>Tag</th>
                        <th>Chuyên mục</th>
                        <th style="width:260px">Giá</th>
                        <th>Trạng thái</th>
                        <th class="actions"></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php                 
          foreach($getcsdl as $row): 
          ?>
            <tr>
              <td>
              <?php 
                if(!empty($row->image)):
              ?>
                <img src="<?php echo $this->ruadmin->geturlimg($row->image,$config_upload["dirweb"]); ?>" width="130" />
              <?php else: ?>   
                <img src="<?php echo base_url() ?>assets/img/no_image.gif"  width="80"/> 
              <?php endif; ?>
                            
                            </td>
              <td>
                              <a href="<?php echo base_url().$row->catalogs_slug."/".$row->slug ?>.html" title="Xem bài" target="_blank"><strong><?php echo $row->title ?></strong></a>
                              <p style="color:#929090;font-size:11px">
                                    <span> » Ngày đăng</span> <?php echo $row->created ?> <br>
                                    <span> » Đăng bởi</span> <?php echo $row->created_by ?><br>
                                    <span> » Mã EAN : </span> <?php echo $row->code_aen ?><br>
                                    <span> » Mã SKU : </span> <?php echo $row->code_sku ?>
                              </p>
                            </td>
                            <td><strong><?php echo $row->code_sku  ?></strong></td>
                            <td><?php echo $row->catalogs_title  ?></td>
                            <td>
              <?php if($row->price > 0):?>
                                <div class="input-group xs-mb-10">
                                  <span class="input-group-addon">$</span>
                  <input type="text" data-id="<?php echo $row->id ?>" data-price="<?php echo $row->price ?>" value="<?php echo number_format($row->price, 0, ',', '.');?>" class="form-control input-price"><span class="input-group-addon">VNĐ</span>
                                </div>
              <?php else: ?>
                Liên Hệ    
              <?php endif ?>  
                            </td>
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