<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>"><?php echo $controller_title ?></a></li>
	<li class="active"><?php echo $title ?></li>
</ol>
<div class="row">
            <div class="col-md-12">
              <div class="panel panel-default panel-border-color panel-border-color-primary">
                <div class="panel-heading panel-heading-divider">Thêm <?php echo $controller_title ?></div>
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
                   
                   <div class="form-group">
                      <label class="col-sm-3 control-label">Danh Mục</label>
                      <div class="col-sm-9">
                      	<select class="select2" name="catalogs">
                              <?php	foreach($catalogs_full as $row){
									echo '<option value="'.$row->id.'">'.$row->title.'</option>';
								}
							?>
						</select>
                      </div>
                    </div> 
                                                          
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Thương Hiệu</label>
                      <div class="col-sm-9">
                      	<select class="select2" name="trademark">
                              <?php	foreach($trademark as $row){
									echo '<option value="'.$row->id.'">'.$row->title.'</option>';
								}
							?>
						</select>
                      </div>
                    </div>                                       
                                                           
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Nội dung</label>
                      <div class="col-sm-6">
                        <textarea class="form-control" name="content" style="height: 400px;"></textarea>
                      </div>
                    </div>
                         
                                                            
                    <div class="form-group">
                      <label class="col-sm-3 control-label"></label>
                      <div class="col-sm-9">
                      		<button class="btn btn-primary btn-lg" type="submit">Thêm Mới Hoặc Cập Nhật</button>
							<button class="btn btn-default btn-lg" type="button">Nhập Lại</button>  
                      </div>
                    </div>
                    
                    
                  </form>
                </div>
              </div>
            </div>
          </div>