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
        url: '<?php echo base_url().$module ?>/products_sale/ajax_price',
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
                        
                        <div style="float:left;">
                         <a class="btn-edit btn btn-primary" href="<?php echo base_url().$module ?>/products_sale/add" style="float:right">Thêm Mặt Hàng Giảm Giá</a>
                      </div>
                        
                     </div>
                </div>
                <div class="panel-body">
                  <table class="table table-striped table-hover">
                    <thead>
                      <tr>
                        <th style="width:130px"></th>
                        <th>Tên</th>         
                        <th>Giá</th>
                        <th>Trạng thái</th>
                        <th class="actions"></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php                 
          foreach($getcsdl as $row): 
          ?>
            <tr id="id<?php echo $row->id ?>">
              <td>
              <?php 
                if(!empty($row->product->image)):
              ?>
                <img src="<?php echo $this->ruadmin->geturlimg($row->product->image,$config_upload["dirweb"]); ?>" width="130" />
              <?php else: ?>   
                <img src="<?php echo base_url() ?>assets/img/no_image.gif"  width="80"/> 
              <?php endif; ?>
                            
                            </td>
              <td>
                              <strong><?php echo $row->product->title ?></strong>
                              <p style="color:#929090;font-size:11px">
                                    <span> » Ngày đăng</span> <?php echo $row->product->created ?> <br>
                                    <span> » Đăng bởi</span> <?php echo $row->product->created_by ?><br>
                                    <span> » Mã EAN : </span> <?php echo $row->product->code_aen ?><br>
                                    <span> » Mã SKU : </span> <?php echo $row->product->code_sku ?>
                              </p>
                            </td>
                            
                            <td>
                                <div class="input-group xs-mb-10" style="width: 120px">                                 
                                  <input  type="number" maxlength="100" minlength="0" data-id="<?php echo $row->id ?>" data-price="<?php echo $row->value ?>" value="<?php echo number_format($row->value, 0, ',', '.');?>" class="form-control input-price" title="Click đôi vào để cập nhật giá">
                                  <span class="input-group-addon">%</span>
                                </div>
                            </td>
                            <td>                              
                              <div class="switch-button switch-button-yesno">
                                    <input type="checkbox" <?php echo ($row->status == "1")?'checked="true"':"" ?> id="swt<?php echo $row->id ?>"><span>
                                    <label class="status" data-id="<?php echo $row->id ?>" for="swt<?php echo $row->id ?>" data-path="<?php echo base_url($module)."/".$controller ?>/status/<?php echo $row->id ?>"></label></span>
                                </div>
                            </td>
                            <td>                                              
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