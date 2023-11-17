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
                  <form action="#" style="border-radius: 0px;" class="form-horizontal group-border-dashed"   method="post" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" />
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Tên</label>
                      <div class="col-sm-6">
                        <input name="title" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->name;else echo set_value('title');?>" parsley-trigger="change" required="" placeholder="Tên danh mục" autocomplete="on" class="form-control" type="text">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Slug</label>
                      <div class="col-sm-6">
                        <input name="slug" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->slug;else echo set_value('slug');?>" placeholder="Tên trên url" class="form-control" type="text">
                      </div>
                    </div> 
                     <?php $this->load->view("blockmodule/upfile.php",array("image"=>$getcsdl->image,"size"=>"min"));?>   

                     <div class="form-group">
                      <label class="col-sm-2 control-label">Thương Hiệu</label>
                      <div class="col-sm-6">
                        <select class="select2" name="trademark">
                          <option value="0">Chọn thương hiệu</option>
                          <?php foreach($trademark as $row){
                          echo '<option value="'.$row->id.'" '.set_select('trademark', $row->id, (!empty($getcsdl) && $getcsdl->id_trademark == $row->id)).'>'.$row->title.'</option>';
                          }
                          ?>
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Tìm Theo Danh Mục <br>*<span class="text-danger">Chọn sản phẩm thuộc dòng sản phẩm hoặc thuộc bộ sưu tập</span></label>
                      <div class="col-sm-9">
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
                        <?php foreach($products as $key=>$row):?>  
                          <option value="<?php echo $row->id ?>"><?php echo $row->title ?></option>
                        <?php endforeach ?>  
                        </select>
                      </div>
                        
                      <script src="<?php echo base_url() ?>assets/js/jquery.selectlistactions.js"></script>
                      <script type="text/javascript"> 
                      $(document).ready(function(){
                        var id_catalogs = $('#aj_danhmuc');
                        id_catalogs.select2({width: '100%'});
                        id_catalogs.on("select2:select", function (e) {     
                          var args = JSON.stringify(e.params, function (key, value) {         
                            $.ajax({
                              url: path_full+'/Products/ajax_getproduct',
                              data: {'id_catalogs':id_catalogs.val()},  
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
                      <label class="col-sm-2 control-label">Danh sách sản phảm</label>
                      <div class="col-md-10">
                        <table class="table table-striped table-hover">
                          <thead>
                            <tr>
                              <th style="width:90px">Thứ Tự</th><th></th><th>Tên sản phẩm</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach($products as $key=>$row):?>
                            <tr id="id<?php echo $row->id ?>">
                              <td align="center"><strong><?php echo $key+1 ?></strong></td>
                              <td>
                              <?php 
                                  if(!empty($row->image)):
                                ?>
                                  <img src="<?php echo $this->ruadmin->geturlimg($row->image,$folder["dirweb"]); ?>" width="50" />
                                <?php else: ?>   
                                  <img src="<?php echo base_url() ?>assets/img/no_image.gif"  width="50"/> 
                                <?php endif; ?>
                              </td>
                              <td><strong><?php echo $row->title ?></strong></td>                      
                            </tr>
                            <?php endforeach ?>
                          </tbody>
                        </table>
                      </div>
                    </div>  
                    <div class="form-group">

                      <label class="col-sm-2 control-label">keywords</label>

                      <div class="col-sm-6">

                        <input name="sllug" value="<?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->keywords;else echo set_value('keywords');?>" placeholder="Keywords" class="form-control" type="text">

                      </div>

                    </div>

                    

                    <div class="form-group">

                      <label class="col-sm-2 control-label">Description</label>

                      <div class="col-sm-6">

                        <textarea class="form-control" name="description"><?php if(!empty($getcsdl) && !validation_errors()) echo $getcsdl->description;else echo set_value('description');?></textarea>

                      </div>

                    </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
						<div class="col-sm-10">												
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

                      <label class="col-sm-2 control-label">Thứ Tự</label>

                      <div class="col-sm-6">

                        <input name="order" value="<?php if(!empty($getcsdl)&&!validation_errors()) echo $getcsdl->order;else echo set_value('order');?>" style="width:100px" min="0" max="100" class="form-control" type="number">

                      </div>

                    </div>

                    

                    

                    <div class="form-group">

                      <label class="col-sm-2 control-label"></label>

                      <div class="col-sm-6">

                      		<button class="btn btn-success btn-lg" type="submit">Cập nhật dòng sản phẩm</button>

							<button class="btn btn-default btn-lg" type="button">Nhập Lại</button>  

                      </div>

                    </div>

                    

                    

                  </form>

                </div>

              </div>

            </div>











	