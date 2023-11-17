<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>"><?php echo $controller_title ?></a></li>
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
                      <label class="col-sm-3 control-label">Danh sách                     
                      </label>
                      <div class="col-sm-6">
                        <textarea style="height: 550px;" name="list_attrib" class="form-control"></textarea>
                        <p>*Mỗi giá trị nằm trên 1 dong</p>
                      </div>
                    </div>
                    <script type="text/javascript">
					$(document).ready(function(e) {
						var group_check = $('select[name="group"]');
						group_check.on("select2:select", function (e) { 
							if($(this).find("option:selected").attr("rate") == 1)
								$('#rate').css('display','block');
							else
								$('#rate').css('display','none');
						});
					});
                    </script>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Nhóm thuộc tính</label>
                      <div class="col-sm-6">
                      	<select class="select2" name="group">
                        	<?php						
                            foreach($group as $row){
                            	echo '<option value="'.$row->id.'" '.set_select('group', $row->id, (!empty($getcsdl) && $getcsdl->group == $row->id)).'>'.$row->title.'</option>';
							}                            
                        	?>
						</select>
                      </div>
                    </div>
                    
                    <div class="form-group" id="rate" style="display:none">
                      <label class="col-sm-3 control-label">Tỉ giá</label>
                      <div class="col-sm-6">
							<input type="text" data-mask="percent" value="<?php echo $row->rate ?>" placeholder="0%" class="form-control">
                      </div>
                    </div>                
                    <div class="form-group">
                      <label class="col-sm-3 control-label"></label>
                      <div class="col-sm-6">
                      		<button class="btn btn-success btn-lg" type="submit">Nhập Nhanh</button>
							<button class="btn btn-default btn-lg" type="button">Nhập Lại</button>  
                      </div>
                    </div>
                    
                    
                  </form>
                </div>
              </div>
            </div>





	