<link href="<?php echo base_url() ?>assets/css/bootstrap-imageupload.css" rel="stylesheet">
<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>"><?php echo $controller_title ?></a></li>
	<li class="active"><?php echo $title ?></li>
</ol>
<form action="#" style="border-radius: 0px;" class="form-horizontal group-border-dashed" method="post" enctype="multipart/form-data">
  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" />
<div class="row">
  <div class="col-md-8">
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
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Tiêu đề</label>
                      <div class="col-sm-10">
                        <input name="title" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->title;else echo set_value('title');?>" required placeholder="Tiêu đề" autocomplete="on" class="form-control input-sm" type="text">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Slug</label>
                      <div class="col-sm-10">
                        <input placeholder="Slug cho seo" class="form-control input-sm" name="slug" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->slug;else echo set_value('slug');?>" type="text">
                      </div>
                    </div>
                    
                    <?php $this->load->view("blockmodule/upfile.php",array("image"=>$getcsdl->image,"size"=>"min"));?>
                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Giá bán</label>
                      <div class="col-sm-10">
                      	<div class="input-group xs-mb-10" style="max-width:500px">
                        	<span class="input-group-addon">$</span>
							             <input type="text" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->price;else echo set_value('price');?>" class="form-control" name="price">
                      	</div>
                      </div>
                    </div>

                    <?php $this->load->view("products/products_variant",array("image"=>$getcsdl->image,"size"=>"min"));?>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Mặt hàng mua chung</label>
                      <div class="col-sm-10">
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
                     		<select name="product_combo[]" multiple class="form-control" id="lstBox2" style="min-height: 150px">
                     		<?php foreach($products_combo as $row):?>
                     			<option selected value="<?php echo $row->id ?>"><?php echo $row->name ?></option>';
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
                    
                    
                    
                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label"></label>
<!--Default Tabs-->
                    <?php if(!empty($get_attib_insert)):?> 
                    <div class="col-sm-10">
                        <div class="tab-container">
                          <ul class="nav nav-tabs">
                            <?php foreach ($tab_attrib as $key => $value): ?>
                            <li <?php echo ($key==0)?'class="active"':'' ?>><a href="#attib_insert_<?php echo $value->id ?>" data-toggle="tab"><?php echo $value->title ?></a></li>
                          <?php endforeach ?>
                          </ul>
                          <div class="tab-content" style="padding-right: 0;padding-left: 0;margin-bottom: 0;">
                          <?php foreach($get_attib_insert as $row): ?>                            
                              <?php echo $row ?>                            
                          <?php endforeach ?> 
                          </div> 
                          </div>
                        </div>
                      </div>
                    <!--Success Tabs-->
                    <?php endif ?>


<div class="form-group">
                      <label class="col-sm-2 control-label">Mô tả ngắn SP</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" name="home_text" style="height: 200px;"><?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->home_text;else echo set_value('home_text');?></textarea>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-12 control-label" style="text-align: left;font-weight: 600;margin-bottom: 10px;">Bài viết chi tiết của sản phẩm</label>
                      <div class="col-sm-12">                       		
                        	<?php 
            								if(!empty($getcsdl) && !validation_errors()) 
            									$content =  $getcsdl->body_text;
            								else 
            									$content =  set_value('body_text');	
            							$this->load->view("blockmodule/froalaeditor.php",array("name"=>"body_text","content_froalaeditor"=>$content));
            							?>                            
                      </div>
                    </div>
                                             
                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label"></label>
                      <div class="col-sm-10">
                      		<button class="btn btn-success" type="submit">Cập Nhật Mặt Hàng</button>
							            <button class="btn btn-default" type="button">Nhập Lại</button>  
                      </div>
                    </div>
                    
                    
                  
                </div>
              </div>
            </div>
      <!-- phần nội dung hay điền -->
      <div class="col-md-4">
        <div class="panel panel-default panel-border-color panel-border-color-primary">          
          <div class="panel-body">

            <div class="form-group">
                      <label class="col-sm-3 control-label">Keywords</label>
                      <div class="col-sm-9">
                        <textarea type="text" class="form-control" name="keywords"><?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->keywords;else echo set_value('keywords');?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Description</label>
                      <div class="col-sm-9">
                        <textarea class="form-control" name="description"><?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->description;else echo set_value('description');?></textarea>
                      </div>
                    </div>

            <div class="form-group">
                      <label class="col-sm-3 control-label">Mã EAN</label>
                      <div class="col-sm-9">
                        <input style="width:150px" placeholder="Mã EAN" class="form-control" name="code_aen" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->code_aen;else echo set_value('code_aen');?>" type="text">
                        <a href="https://www.ean-search.org/?q=" target="_blank">* Check Mã</a>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Mã SKU</label>
                      <div class="col-sm-9">
                        <input style="width:250px" readonly class="form-control input-sm" name="code_sku" value="<?php echo $getcsdl->code_sku;?>" type="text">
                      </div>
                    </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default panel-border-color panel-border-color-primary">          
          <div class="panel-body">              
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Chuyên mục</label>
                      <div class="col-sm-9">
                        <select class="select2" name="catalogs">
            <?php foreach($catalogs as $row){
                  echo '<option value="'.$row->id.'" '.set_select('catalogs', $row->id, (!empty($getcsdl) && $getcsdl->catalogs == $row->id)).'>'.$row->title.'</option>';
                }
            ?>
            </select>
                      </div>
                    </div>

              <div class="form-group">
                      <label class="col-sm-3 control-label">Chuyên mục phụ</label>
                      <div class="col-sm-9">
                        <select multiple="multiple" class="tags" name="sub_categories[]">
                        <?php 
                          $tmp_sub_categories = json_decode($getcsdl->sub_categories);
                          $_themes = NULL;
                          foreach($catalogs_full as $row){
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
                      <label class="col-sm-3 control-label">Thương Hiệu</label>
                      <div class="col-sm-9">
                        <select class="select2" name="trademark">
                          <option value="0">Chọn thương hiệu</option>
                          <?php foreach($trademark as $row){
                          echo '<option value="'.$row->id.'" '.set_select('trademark', $row->id, (!empty($getcsdl) && $getcsdl->trademark == $row->id)).'>'.$row->title.'</option>';
                          }
                          ?>
                        </select>
                      </div>
                    </div>
            </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default panel-border-color panel-border-color-primary">          
          <div class="panel-body"> 
                    <?php if(!empty($get_attib_check)): ?>
                    <?php foreach($get_attib_check as $row){
                        echo $row;
                    }?>
                    <?php endif ?>                    
                    
            <div class="form-group">
              <label class="col-sm-3 control-label"></label>
              <div class="col-sm-9">
                <button class="btn btn-default" id="update-product" type="button">Cập Nhật Thuộc Tính Sản Phẩm</button>
              </div>    
          </div> <!-- panel-body -->   
        </div>
      </div>      
      <!-- phần nội dung hay điền -->      
  </div>
</form>
<script type="text/javascript">
  $(document).ready(function(e) {
    $("#update-product").click(function(){
      var form = $('.form-horizontal');
      $.ajax( {
        type: "POST",
        url: form.attr('action'),
        data: form.serialize(),
        success: function( response ) {
          $("html").html(response);
        }
      });
    })
  });
</script>            