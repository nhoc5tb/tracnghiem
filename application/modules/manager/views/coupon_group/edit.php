<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>"><?php echo $controller_title ?> : </a></li>
	<li class="active"><?php echo $title ?></li>
</ol>
<link href="<?php echo base_url() ?>assets/css/bootstrap-imageupload.css" rel="stylesheet">
 <div class="row">
 
 <div class="col-md-12">
              <div class="panel panel-default panel-border-color panel-border-color-primary">
                <div class="panel-heading panel-heading-divider"><?php echo $title ?></div>
                <div class="panel-body">                
                  <?php if (validation_errors()):?>         
                    <div role="alert" class="alert alert-contrast alert-danger alert-dismissible">
                        <div class="icon"><span class="mdi mdi-close-circle-o"></span></div>
                        <div class="message">
                          <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="mdi mdi-close"></span></button>
                          <?php if (validation_errors()) echo validation_errors(' ','<br>'); ?>
                        </div>
                      </div>
                    <?php endif; ?>
                    
                  <form action="#"  style="border-radius: 0px;" class="form-horizontal group-border-dashed"  method="post" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" />
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Tên nhóm</label>
                      <div class="col-sm-6">
                        <input name="name" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->name;else echo set_value('name');?>" parsley-trigger="change" required="" placeholder="" autocomplete="off" class="form-control input-sm" type="text">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Tiền Tố<br>là mã bắt đầu của code</label>
                      <div class="col-sm-6">
                        <input name="" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->code;else echo set_value('code');?>" parsley-trigger="change" required="" placeholder="" autocomplete="off" class="form-control input-sm" type="text" style="max-width:200px" readonly>
                      </div>
                    </div>

                    <!-- sản phẩm tồn tại -->
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Áp dụng với Sản phẩm</label>
                      <div class="col-sm-6">
                        <div class="col-sm-12" style="padding: 0;margin-bottom: 10px">
                          <select class="select2" id="aj_danhmuc">
                            <option value="0">Chọn danh mục sản phẩm</option>
                            <?php 
                              foreach($catalogs as $row){
                                echo '<option value="'.$row->id.'">'.$row->title.'</option>';
                              }
                            ?>
                          </select>
                      </div>
                      <div class="col-sm-5" style="padding: 0;margin-bottom: 10px">
                        <select multiple class="form-control" id="lstBox1" style="min-height: 150px">
                        </select>
                      </div>  
                      <div class="col-sm-1" style="margin-bottom: 10px">
                        <input type='button' id='btnAllRight' value='>>' class="btn btn-space btn-warning" style="min-width: 100%"/><br />
                        <input type='button' id='btnRight'    value='>'  class="btn btn-space btn-warning" style="min-width: 100%"/><br />
                        <input type='button' id='btnLeft'     value='<'  class="btn btn-space btn-warning" style="min-width: 100%"/><br />
                        <input type='button' id='btnAllLeft'  value='<<' class="btn btn-space btn-warning" style="min-width: 100%"/>
                      </div>  
                      <div class="col-sm-6" style="padding: 0;margin-bottom: 10px">
                        <select name="app_products[]" multiple class="form-control" id="lstBox2" style="min-height: 150px">
                        <?php foreach($app_products as $row):?>
                          <option selected value="<?php echo $row->id ?>"><?php echo $row->title ?></option>';
                        <?php endforeach ?>
                       </select>
                      </div>
                      <script src="<?php echo base_url() ?>assets/lib/jquery/jquery.min.js" type="text/javascript"></script>  
                      <script src="<?php echo base_url() ?>assets/js/jquery.selectlistactions.js"></script>
                      <script type="text/javascript"> 
                        $(document).ready(function(){
                          var id_catalogs = $('#aj_danhmuc');
                          id_catalogs.select2({width: '100%'});
                          id_catalogs.on("select2:select", function (e) {     
                            var args = JSON.stringify(e.params, function (key, value) {         
                              $.ajax({
                                url: path_full+'/Products/ajax_getproduct',
                                data: {'id_catalogs':id_catalogs.val(),'ru_csrf_token_name':ru_csrf_token_name},  
                                type: 'POST',
                                success: function(data){
                                  if(data.status){
                                    var content = $.parseJSON(data.content);
                                    var sel = $("#lstBox1");
                                    sel.empty();                        
                                    for (var i=0; i<content.length; i++) {                            
                                      sel.append('<option value="' + content[i].id + '">' + content[i].name + '</option>');
                                    }
                                  }else{
                                    $.gritter.add({
                                      title: 'Thông Báo',
                                      text: data.msg,
                                      time: '3000',
                                      class_name: 'color danger',
                                      after_close: function(e, manual_close){
                                      }
                                    });
                                  }
                                          
                                },
                                error: function() { 
                                  console.log('Lỗi ajax');          
                                }
                              });//$.ajax       
                            });//--------------     
                          });
                          $('#btnRight').click(function (e) {           
                            $('select').moveToListAndDelete('#lstBox1', '#lstBox2');
                            $('#lstBox2 option').prop('selected', true);
                            e.preventDefault();
                          });

                          $('#btnAllRight').click(function (e) {
                            $('select').moveAllToListAndDelete('#lstBox1', '#lstBox2');
                            $('#lstBox2 option').prop('selected', true);
                            e.preventDefault();
                          });

                          $('#btnLeft').click(function (e) {
                            $('select').moveToListAndDelete('#lstBox2', '#lstBox1');
                            $('#lstBox2 option').prop('selected', true);
                            e.preventDefault();
                          });

                          $('#btnAllLeft').click(function (e) {
                            $('select').moveAllToListAndDelete('#lstBox2', '#lstBox1');
                            $('#lstBox2 option').prop('selected', true);
                            e.preventDefault();
                          });
                        });             
                      </script>
                      </div>
                    </div>  
                    <!-- #sản phẩm tồn tại -->
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Áp dụng với Danh mục</label>
                      <div class="col-sm-9">
                        <select multiple="multiple" class="select2 tags" name="app_catalogs[]">
                        <?php 
                          $tmp_sub_categories = json_decode($getcsdl->app_catalogs);
                          $_themes = NULL;
                          foreach($catalogs as $row){
                            if(!empty($tmp_sub_categories)){                
                              foreach($tmp_sub_categories as $_row){
                                if($_row == $row->id){ 
                                  $_themes = ' selected="true"';
                                  break;
                                }else{
                                  $_themes = '';
                                }
                              }
                            }
                            echo '<option value="'.$row->id.'"'.$_themes.'>'.$row->title.'</option>';
                          }
                        ?>
                        </select>
                      </div>
                    </div>
                    



                    <div class="form-group">
                      <label class="col-sm-3 control-label">Giảm</label>
                      <div class="col-sm-6">
                        <input name="discount" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->discount;else echo set_value('discount');?>" placeholder="" class="form-control input-sm" type="text">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Loại giảm</label>
                      <div class="col-sm-6">
                        <select class="select2"  name="type">
                          <option value="1">Giảm %</option> 
                          <option value="2">Số tiền</option> 
                        </select>
                      </div>
                    </div>      

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Chi tiêu tối thiểu</label>
                      <div class="col-sm-6">
                        <input name="min_payments" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->min_payments;else echo set_value('min_payments');?>" placeholder="" class="form-control input-sm" type="text" style="max-width:200px">
                      </div>
                    </div>  

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Giảm tố đa</label>
                      <div class="col-sm-6">
                        <input name="max_amount" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->max_amount;else echo set_value('max_amount');?>" placeholder="" class="form-control input-sm" type="text" style="max-width:200px">
                      </div>
                    </div>              
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">User được dùng / lần</label>
                      <div class="col-sm-6">
                        <input name="limit_user" value="1" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->limit_user;else echo set_value('limit_user');?>" style="max-width:100px" min="1" max="500" class="form-control input-sm" type="number">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Số lần mã được dùng</label>
                      <div class="col-sm-6">
                        <input name="limit_coupon" value="1" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->limit_coupon;else echo set_value('limit_coupon');?>" style="max-width:100px" min="1" max="500" class="form-control input-sm" type="number">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Miễn phí Ship</label>
                      <div class="col-sm-6 xs-pt-5">
                        <div class="switch-button switch-button-success">
                          <input name="free_ship" type="checkbox" id="free_ship"><span>
                            <label for="free_ship"></label></span>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Dùng chung mã #</label>
                      <div class="col-sm-6 xs-pt-5">
                        <div class="switch-button switch-button-warning">
                          <input type="checkbox" name="share_code" id="share_code"><span>
                            <label for="share_code"></label></span>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label"> Ngày hết hạn </label>
                      <div class="col-md-3 col-xs-7">
                        <div data-min-view="2" data-date-format="yyyy-mm-dd" class="input-group date datetimepicker">
                          <input name="expiry_date" size="16" type="text" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->expiry_date;else echo set_value('expiry_date');?>" class="form-control input-sm">
                          <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></span>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Số mã cần tạo</label>
                      <div class="col-sm-6">
                        <input name="number_codes" value="10" style="max-width:100px" min="1" max="1500" class="form-control input-sm" type="number">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label"></label>
                      <div class="col-sm-6">
                          <button class="btn btn-primary btn-lg" type="submit">Cập Nhật Nhóm</button>
                          <button class="btn btn-default btn-lg" type="button">Nhập Lại</button>  
                      </div>
                    </div>
                    
                    
                  </form>
                </div>
              </div>
            </div>





	