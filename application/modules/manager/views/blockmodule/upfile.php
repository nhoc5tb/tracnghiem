<div class="form-group">
<?php if(isset($size)): ?>
	<label class="col-sm-<?php echo $size ?> control-label">Hình đại diện</label>
		<div class="col-sm-10">	
<?php else: ?>	
	<label class="col-sm-3 control-label">Hình đại diện</label>
		<div class="col-sm-6">
<?php endif ?>			
			<div class="imageupload">
			<link href="<?php echo base_url() ?>assets/css/bootstrap-imageupload.css" rel="stylesheet">
			<!-- bootstrap-imageupload. -->
			<div class="panel-heading clearfix">
				<div class="btn-group pull-right">
					<button type="button" class="btn btn-default active">Tải File</button>					
					<button type="button" class="btn btn-default">URL</button>
					<button type="button" class="btn btn-default">Thư Viện</button>
				</div>
			</div>
			<?php	
				if(!empty($image)):
					$img = $this->ruadmin->geturlimg($image,$config_upload["dirweb"]);
				?>
            <div class="panel-body" style="padding-bottom:0px;">
            	<img src="<?php echo $img ?>" alt="Image preview" class="thumbnail" style="max-width: 210px; max-height: 250px; margin-top:5px;">
            </div>
            <?php endif ?>
			<div class="file-tab panel-body">
				<label class="btn btn-default btn-file">
					<span>Browse</span>
					<?php if(!isset($type_name)):?>
					<input type="file" name="image">
					<?php else:?>
					<input type="file" name="<?php echo $type_name ?>">
					<?php endif ?>
				</label>
				<button type="button" class="btn btn-default">Xóa</button>
			</div>			
			<div class="url-tab panel-body">
				<div class="input-group">
					<input type="text" class="form-control hasclear" placeholder="Image URL">
					<div class="input-group-btn">
						<button type="button" class="btn btn-default">Mở Hình</button>
					</div>
				</div>
				<button type="button" class="btn btn-default">Xóa</button>
				<input type="hidden" name="image_url">
			</div>
			<div class="lib-tab panel-body">
				<div class="input-group">
					<input id="input_lib" type="text" class="form-control hasclear" placeholder="">
					<div class="input-group-btn">
						<button type="button" class="btn btn-space btn-default"> Mở Thư Viện</button>
					</div>
				</div>
				<button type="button" class="btn btn-default">Xóa</button>
				<input type="hidden" name="image_lib">
			</div>
		</div>
		<!-- bootstrap-imageupload. -->
	</div>
</div>
<div id="md-library" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-primary">
     <div class="modal-dialog" style="width: 1024px">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><span class="mdi mdi-close"></span></button>
            <h3 class="modal-title">Thư Viện Hình Đã Tải Lên</h3>
          </div>
          <div class="modal-body" style="max-height: 500px;overflow-x: auto;">
           	<div id="ru-content-img">
           	</div>
          </div>
        </div>
      </div>
</div>


<script type="text/javascript">
	//assets\js\bootstrap-imageupload.js
var imageUploadURL = path_full + "/wysiwyg/upload";	
var imageManagerLoadURL = path_full + '/wysiwyg';
var imageManagerDeleteURL = path_full + '/wysiwyg/delete';
<?php 
	if(isset($folder_scan)): 
?>
var folder_scan = "<?php echo $folder_scan ?>";
<?php 
	else: 
	$this->config->load('template');			
	$folder_scan = 'image_'.$controller;	
?>
var folder_scan = "<?php echo $folder_scan ?>";
<?php endif ?>
</script>