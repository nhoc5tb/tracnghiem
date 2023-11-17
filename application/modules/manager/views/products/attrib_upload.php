<link href="<?php echo base_url() ?>assets/lib/dm-uploader/css/jquery.dm-uploader.min.css" rel="stylesheet">
<link href="<?php echo base_url() ?>assets/lib/dm-uploader/styles.css" rel="stylesheet">
      
<div id="attib_insert_<?php echo $set_attrib->id ?>" class="tab-pane <?php echo ($active==TRUE)?'active':'' ?> cont">
	<div class="form-group">	
		<div class="col-sm-12"> 
         <div class="col-md-6 col-sm-12" style="padding-left: 0;">          
          <!-- Our markup, the important part here! -->
          <div id="drag-and-drop-zone" class="dm-uploader p-5">
            <h3 class="mb-5 mt-5 text-muted">Kéo Thẻ File Ảnh Vào Đây</h3>

            <div class="btn btn-primary btn-block mb-5">
                <span>Lấy Ảnh Thông Qua Trình Duyệt</span>
                <input type="file" title='Click to add Files' />
            </div>
          </div><!-- /uploader -->
        </div>
        <div class="col-md-6 col-sm-12" style="padding-right: 0;">
          <div class="card h-100">
            <div class="card-header">
              <strong>Danh sách File</strong>
            </div>

            <ul class="list-unstyled p-2 d-flex flex-column col" id="files">
            <?php
			if(!empty($getcsdl_attrib)):
				$img = json_decode($getcsdl_attrib->content);
				if(!empty($img)):
					foreach($img as $row):
			?>
				<li class="media">    
				<?php
					$array = explode('.', $row);
					$extension = end($array);
					if($extension == "mp4"):
				?>
					<video width="150" height="100" controls>
						<source src="<?php echo base_url().'upload/products/attrib/'.$getcsdl->id.'/'.$row ?>" type="video/mp4">
					</video>
				<?php else: ?>
					<img class="mr-3 mb-2 preview-img" src="<?php echo base_url().'upload/products/attrib/'.$getcsdl->id.'/'.$row ?>" alt="">
				<?php endif ?>	
					<div class="media-body mb-1">
					  <p class="mb-2">
						<strong><?php echo $row ?></strong> <br><span class="text-muted text-primary">Đã up</span> - <strong class="text-muted text-danger img_remove">Xóa</strong>
					  </p>					  					  
					</div>
				</li>
			<?php			
					endforeach;
				else:
					echo '<li class="text-muted text-center empty">Hiện chưa có File </li>';
				endif;	
			else:
				echo '<li class="text-muted text-center empty">Hiện chưa có File </li>';
			endif;
			?> 
              
            </ul>
          </div>
        </div>
        
        
        
	</div>
</div>      
</div>   
<script type="text/javascript">
var imageUploadURL = '<?php echo base_url().$module.'/'.$controller ?>/attrib_upload_file_ajax/<?php echo $getcsdl->id.'/'.$set_attrib->id ?>';	
var imageManagerDeleteURL = '<?php echo base_url().$module.'/'.$controller ?>/attrib_remove_file_ajax';
var maxFileSize = 30*(1024*1024);
var id_product = "<?php echo $getcsdl->id ?>";
</script>
    <script src="<?php echo base_url() ?>assets/lib/dm-uploader/js/jquery.dm-uploader.js"></script>
    <script src="<?php echo base_url() ?>assets/lib/dm-uploader/demo-ui.js"></script>
    <script src="<?php echo base_url() ?>assets/lib/dm-uploader/demo-config.js"></script>

    <!-- File item template -->
    <script type="text/html" id="files-template">
      <li class="media">    
		<img class="mr-3 mb-2 preview-img" src="<?php echo base_url() ?>assets/img/noimage.png" alt="Mới đăng">
		<div class="media-body mb-1">
		  <p class="mb-2">
			<strong>%%filename%%</strong> <br><span class="text-muted">Waiting</span> - <strong class="text-danger img_remove">Xóa</strong>
		  </p>
		  <div class="progress mb-2">
			<div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" 
			  role="progressbar"
			  style="width: 0%" 
			  aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
			</div>
		  </div>
		</div>
	  </li>
    </script>

    <!-- Debug item template -->
    <script type="text/html" id="debug-template">
      <li class="list-group-item text-%%color%%"><strong>%%date%%</strong>: %%message%%</li>
    </script>