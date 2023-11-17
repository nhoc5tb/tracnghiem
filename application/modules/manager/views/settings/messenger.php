	<ol class="breadcrumb">
        <li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
        <li class="active"><?php echo $title ?></li>
    </ol>
<form action="" style="border-radius: 0px;" class="form-horizontal group-border-dashed" method="post" enctype="multipart/form-data">
  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" />
    <div class="row">
            <div class="col-md-12">
              <div class="panel panel-default panel-border-color panel-border-color-primary">
                <div class="panel-heading panel-heading-divider"><?php echo $title ?><span class="panel-subtitle">Cấu hình ngôn ngữ</span></div>
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
                   	<?php foreach($getcsdl as $row):?>
                    <div class="form-group">
                      <label class="col-sm-3 control-label"><?php echo $row->key?></label>
                      <div class="col-sm-6">
                       <input placeholder="" class="form-control" type="text" name="<?php echo base64_encode($row->key)?>" value="<?php echo $row->value?>">
                      </div>
                    </div>
                    <?php endforeach ?>
                </div>
              </div>
              
              
              <div class="form-group">
                      <label class="col-sm-3 control-label"></label>
                      <div class="col-sm-6">
                      		<button class="btn btn-default btn-primary btn-lg" type="submit">Lưu Ngôn Ngữ</button>
							<button class="btn btn-default btn-lg" type="button">Nhập Lại</button>  
                      </div>
                    </div>
            </div>
    </div>
</form>