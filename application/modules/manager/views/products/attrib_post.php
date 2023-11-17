<div id="attib_insert_<?php echo $set_attrib->id ?>" class="tab-pane <?php echo ($active==TRUE)?'active':'' ?> cont">
	<div class="form-group">	
		<div class="col-sm-12">
	    	<textarea style="height: 200px" class="form-control" name="<?php echo $getcsdl->id.'_'.$set_attrib->id ?>"><?php if(!empty($getcsdl_attrib) && !validation_errors()) echo $getcsdl_attrib->content;else echo set_value($getcsdl->id.'_'.$set_attrib->id);?></textarea>
		</div>
	</div>
</div>
