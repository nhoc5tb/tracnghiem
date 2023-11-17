<link href="<?php echo base_url() ?>assets/css/bootstrap-imageupload.css" rel="stylesheet">
<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>"><?php echo $controller_title ?></a></li>
	<li class="active"><?php echo $title ?></li>
</ol>
<div class="row">
            <div class="col-md-12">
              <div class="panel panel-default panel-border-color panel-border-color-primary">
                <div class="panel-heading panel-heading-divider"><?php echo $title ?><span class="panel-subtitle"><?php echo $controller_title ?></a></span></div>
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
                  <form action="#" style="border-radius: 0px;" class="form-horizontal group-border-dashed" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" />
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Chọn Danh Mục</label>
                      <div class="col-sm-9">
                        <div style="max-width:500px">
                          <select class="select2" id="aj_danhmuc">
                            <option value="0">Chọn danh mục mặt hàng</option>
                            <?php 
                              foreach($catalogs as $row){
                                echo '<option value="'.$row->id.'">'.$row->title.'</option>';
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label"></label>
                      <div class="col-sm-9"> 
                        <select class="select2" name="id_product" id="lstBox1">
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Khuyến mãi</label>
                      <div class="col-sm-9">
                        <div class="input-group xs-mb-10" style="max-width:120px">
                           <input type="number" maxlength="100" minlength="0" value="0" class="form-control" name="value"><span class="input-group-addon">%</span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Ngày Kết Thúc</label>
                      <div class="col-sm-9">
                        <input type="text" data-mask="date" placeholder="DD/MM/YYYY" name="endsale" class="form-control" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->endsale;else echo set_value('endsale');?>">                        
                      </div>
                    </div>  
                     	<script type="text/javascript"> 
          						 	$(document).ready(function(){
          								var id_catalogs = $('#aj_danhmuc');
          								id_catalogs.select2({width: '300px'});
          								id_catalogs.on("select2:select", function (e) { 		
          									var args = JSON.stringify(e.params, function (key, value) {					
          										$.ajax({
          											url: path_full+'/Products_sale/ajax_getproduct',
          											data: {'id_catalogs':id_catalogs.val(),'ru_csrf_token_name':ru_csrf_token_name},	
          											type: 'POST',
          											success: function(data){
          												if(data.status){
          													var content = $.parseJSON(data.content);
                                    $("#lstBox1").empty();
                                    $("#lstBox1").select2('data', null);
                                    $("#lstBox1").select2({
                                      width: "100%",
                                      data: content
                                    }); 
                                    /*
          													var sel = $("#lstBox1");
          													sel.empty();												
          													for (var i=0; i<content.length; i++) {														
          													  sel.append('<option value="' + content[i].id + '">' + content[i].name + '</option>');
          													}
                                    */
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
          								
          							});							
                     	</script>
                    <div class="form-group">
                      <label class="col-sm-3 control-label"></label>
                      <div class="col-sm-9">
                      		<button class="btn btn-success" type="submit">Thêm Mặt Hàng Khuyến Mãi</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>